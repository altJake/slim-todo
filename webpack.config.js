var webpack = require('webpack');
var path = require('path');

var BUILD_DIR = path.resolve(__dirname, 'public/assets');
var APP_DIR = path.resolve(__dirname, 'src/client');

var config = {
  entry: APP_DIR + '/app.jsx',
  output: {
    path: BUILD_DIR,
    filename: 'slim-todo.js'
  },
  module : {
    rules : [
      {
        test: /\.jsx?/,
        include: APP_DIR,
        use: {
          loader: 'babel-loader',
          // options: {
          //   presets: ['env']
          // }
        }
      }
    ]
  }
};

module.exports = config;
