module.exports = {
    plugins: {
        'postcss-pxtorem': {
            propList: [
                'font',
                'font-size',
                'line-height',
                'letter-spacing',
                'margin',
                'margin-top',
                'margin-right',
                'margin-bottom',
                'margin-left',
                'padding',
                'padding-top',
                'padding-right',
                'padding-bottom',
                'padding-left',
            ],
        },
        'postcss-preset-env': {
            browserslist: 'last 2 versions',
        },
    },
};
