var browserSync = require('browser-sync').create();
var argv = require('yargs').argv;

const initialize = function() {
    if (argv.url) {
        browserSync.init({
            proxy: {
                target: argv.url
            },
            reloadDelay: 1000
        });
    }
};

const reload = function(done) {
    browserSync.reload({ reloadDelay: 1000 });
    done();
};

module.exports = { initialize, reload, stream: browserSync.stream };
