const fs = require('fs');
const path = require('path');
const { execSync } = require('child_process');
const webpack = require('webpack');
const Dotenv = require('dotenv-webpack');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CopyPlugin = require('copy-webpack-plugin');
const ImageMinimizerPlugin = require('image-minimizer-webpack-plugin');
const glob = require('glob');

class SyncColorsPlugin {
    apply(compiler) {
        compiler.hooks.beforeCompile.tapAsync('SyncColorsPlugin', (params, callback) => {
            try {
                execSync('node bin/sync-colors.js', { cwd: __dirname, stdio: 'ignore' });
            } catch (e) {
                // Ignore if sync-colors fails (e.g. colors.json missing)
            }
            callback();
        });
    }
}

/**
 * Discover block style entries: each block folder under blocks/ that has
 * style.scss or style.css becomes an entry "blocks/<name>/style" -> style.css
 */
function getBlockStyleEntries() {
    const blocksDir = path.join(__dirname, 'blocks');
    const entries = {};
    const dirs = glob.sync(path.join(blocksDir, '*')).filter(p => fs.statSync(p).isDirectory());
    for (const blockDir of dirs) {
        const name = path.basename(blockDir);
        const scss = path.join(blockDir, 'style.scss');
        const css = path.join(blockDir, 'style.css');
        if (fs.existsSync(scss)) {
            entries[`blocks/${name}/style`] = `./blocks/${name}/style.scss`;
        } else if (fs.existsSync(css)) {
            entries[`blocks/${name}/style`] = `./blocks/${name}/style.css`;
        }
    }
    return entries;
}

const sassLoaderOptions = {
    implementation: require('sass'),
    sassOptions: { quietDeps: true },
};

const sharedCssRule = {
    test: /\.(scss|css)$/,
    use: [
        MiniCssExtractPlugin.loader,
        {
            loader: 'css-loader',
            options: {
                importLoaders: 2,
                sourceMap: true,
                url: false,
            },
        },
        {
            loader: 'postcss-loader',
            options: {
                postcssOptions: {
                    plugins: ['autoprefixer'],
                },
            },
        },
        {
            loader: 'sass-loader',
            options: sassLoaderOptions,
        },
    ],
};

module.exports = [
    // Main app bundle (JS + CSS)
    {
        entry: {
            app: './src/js/app.js',
        },
        output: {
            filename: 'js/[name].js',
            path: path.resolve(__dirname, './assets/'),
        },
        // stats: 'minimal',
        devtool: 'source-map',
        module: {
            rules: [
                {
                    test: /\.js$/,
                    exclude: /(node_modules)/,
                    use: {
                        loader: 'babel-loader',
                        options: {
                            presets: ['@babel/preset-env'],
                        },
                    },
                },
                sharedCssRule,
            ],
        },
        plugins: [
            new SyncColorsPlugin(),
            new Dotenv({ path: './.env' }),
            new MiniCssExtractPlugin({
                filename: 'css/[name].css',
                chunkFilename: '[id].css',
            }),
            new CopyPlugin({
                patterns: [
                    {
                        from: 'assets/images/source/**/*',
                        to: 'images/[name][ext]',
                        context: path.resolve(__dirname),
                        noErrorOnMissing: true,
                    },
                ],
            }),
        ],
        optimization: {
            minimizer: [
                '...',
                new ImageMinimizerPlugin({
                    minimizer: [
                        {
                            implementation: ImageMinimizerPlugin.sharpMinify,
                            options: {
                                encodeOptions: {
                                    jpeg: { quality: 85 },
                                    png: {},
                                    webp: { quality: 85 },
                                },
                            },
                            filter: (source, sourcePath) => !/\.(svg)$/i.test(sourcePath),
                        },
                        {
                            implementation: ImageMinimizerPlugin.svgoMinify,
                            options: {
                                encodeOptions: {
                                    multipass: true,
                                    plugins: ['preset-default'],
                                },
                            },
                            filter: (source, sourcePath) => /\.(svg)$/i.test(sourcePath),
                        },
                    ],
                }),
            ],
        },
    },
    // Block styles: compile each blocks/<name>/style.scss (or .css) → blocks/<name>/style.css
    ...(function () {
        const blockStyleEntries = getBlockStyleEntries();
        if (Object.keys(blockStyleEntries).length === 0) return [];
        return [
            {
                entry: blockStyleEntries,
                output: {
                    path: path.resolve(__dirname),
                    filename: '[name].js',
                },
                stats: 'minimal',
                devtool: 'source-map',
                module: {
                    rules: [sharedCssRule],
                },
                plugins: [
                    new SyncColorsPlugin(),
                    new MiniCssExtractPlugin({
                        filename: '[name].css',
                    }),
                ],
            },
        ];
    })(),
];
