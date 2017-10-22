var Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('web/assets/')
    .setPublicPath('/assets')
    .cleanupOutputBeforeBuild()
    .autoProvideVariables({
        jQuery: 'jquery',
    })
    .enableSassLoader()
    .enableVersioning(false)
    .createSharedEntry('js/common', ['jquery'])
    .addEntry('js/app', './app/Resources/js/app.js')
    .addStyleEntry('css/app', ['./app/Resources/scss/app.scss'])
;

module.exports = Encore.getWebpackConfig();
