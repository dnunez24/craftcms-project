const { mix } = require('laravel-mix');
// const autoprefixer = require('autoprefixer');

mix.sass('src/assets/styles/main.scss', 'public/assets/styles')
.options({
  // postCss: [
  //   autoprefixer(),
  // ],
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
