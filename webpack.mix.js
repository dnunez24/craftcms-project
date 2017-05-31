const path = require('path');
const { mix } = require('laravel-mix');
const autoprefixer = require('autoprefixer');
const cssnano = require('cssnano');

const postCssConfig = function postCssConfig() {
  const config = [
    autoprefixer(),
  ];

  if (mix.config.inProduction) {
    config.push(cssnano());
  }

  return config;
};

mix.sass('src/assets/styles/main.scss', 'public/assets/styles')
  .options({
    publicPath: 'public',
    postCss: postCssConfig(),
  });

mix.js('src/assets/scripts/main.js', 'public/assets/scripts')
  .sourceMaps();
  // .extract([
    // 'vue',
  // ]);

if (mix.config.inProduction) {
  mix.version();
}

mix.copyDirectory('src/templates', 'craft/templates');

mix.browserSync('www.testcraft.dev');

// mix.webpackConfig({
//   devServer: {
//     contentBase: 'public'
//   },
//   output: {
//     path: path.resolve(__dirname, 'public'),
//   },
// });
