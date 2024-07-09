const path = require('path');
const TerserPlugin = require('terser-webpack-plugin');

module.exports = {
  mode: 'production',  // Mode production pour activer la minification
  entry: '../js/fraldev.js',
  output: {
    filename: 'fraldev-bundle.min.js',
    path: path.resolve(__dirname, '../js')
  },
  optimization: {
    minimize: true,
    minimizer: [new TerserPlugin({
      extractComments: false,
    })],
  },
  plugins: [],
};