const devPort = 8081;
const WebpackShellPlugin = require('webpack-shell-plugin');
process.env.VUE_APP_VERSION = require('./package.json').version;
const productionDir = "./dist";
const outPath = `${productionDir}/powerful-wp-ajax-search`;
const zipName = `powerful-wp-ajax-search-${process.env.VUE_APP_VERSION}.zip`;
let production = [];
const isProduction = process.env.NODE_ENV === 'production';

if (isProduction) {
  production.push(
    new WebpackShellPlugin({
      safe: true,
      onBuildStart:[
        'rm -rf ' + productionDir + ' && mkdir -p ' + productionDir,
      ],
      onBuildEnd:[
        "npx cpy --parents '.' '!./public' '!./dist/favicon.ico' '!./dist/index.html' !./src !./src/**/scss '!./config' '!./tests' '!./cypress' '!./**/node_modules' '!./**/__debugger1.php' '!./vue.config.js' '!./babel.config.js' '!./_dev_config.php' '!./webpack.config.js' '!./postcss.config.js' '!./package.json' '!./package-lock.json' '!./composer.json' '!./composer.lock' " + outPath
        + " && cd " + productionDir
        + " && zip --recurse-paths " + zipName + " ./powerful-wp-ajax-search"
      ]
    })
  )
}

module.exports = {
  devServer: {
    hot: true,
    writeToDisk: true,
    liveReload: false,
    sockPort: devPort,
    port: devPort,
    headers: { 'Access-Control-Allow-Origin': '*' },
  },
  publicPath:
    process.env.NODE_ENV === 'production'
      ? process.env.ASSET_PATH || '/'
      : `http://localhost:${devPort}/`,
  configureWebpack: {
    output: {
      filename: `js/pwas-${process.env.VUE_APP_VERSION}.js`,
      hotUpdateChunkFilename: 'hot/hot-update.js',
      hotUpdateMainFilename: 'hot/hot-update.json',
    },
    optimization: {
      splitChunks: false,
    },
    plugins:production
  },
  filenameHashing: true,
  css: {
    extract: {
      filename: `css/pwas-${process.env.VUE_APP_VERSION}.css`,
    },
  },
  productionSourceMap:false
};
