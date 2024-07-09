const path = require('path');

module.exports = {
  mode: 'development',  // Mode développement pour avoir un code lisible
  entry: '../js/fraldev.js',
  output: {
    filename: 'fraldev-bundle.js',
    path: path.resolve(__dirname, '../js')
  },
  devtool: 'source-map',  // Génère des source maps pour faciliter le débogage
  optimization: {
    minimize: false,  // Désactive la minification pour avoir un code lisible
  },
};