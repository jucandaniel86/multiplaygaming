const mix = require('laravel-mix');
const path = require('path');

mix.setPublicPath('public_html/');
mix.js('resources/js/app.js', 'js')
  .vue()
  .postCss('resources/css/app.css', 'css');
mix.webpackConfig({
  resolve: {
    extensions: ['.js', '.json', '.vue'],
    alias: {
      '~': path.join(__dirname, './resources/js'),
      '$comp': path.join(__dirname, './resources/js/components')
    }
  },
  stats: {
    warnings: false,
  }
});
mix.disableNotifications();
