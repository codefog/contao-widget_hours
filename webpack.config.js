const Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('public/')
    .setPublicPath('/bundles/codefogwidgethours')
    .setManifestKeyPrefix('')

    .addStyleEntry('widget', './assets/widget.css')

    .disableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableVersioning()
    .enablePostCssLoader()
;

module.exports = Encore.getWebpackConfig();
