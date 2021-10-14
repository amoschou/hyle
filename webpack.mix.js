const mix = require('laravel-mix');

const themeDefinition = require('./config/hyle.json');

const mdcOptions = {
    // Prefer Dart Sass
    implementation: require('sass'),

    // See https://github.com/webpack-contrib/sass-loader/issues/804
    webpackImporter: false,

    sassOptions: {
        includePaths: ['./node_modules']
    }
};

files = {
    sass: [
        'hyle',
        // 'hylemin',
        // 'mdc',
        // 'theme/base-with-colour',
        // 'theme/base-without-colour',
        // 'theme/baseline-dark',
        // 'theme/baseline-default'
        // 'baseline-default-new',
        'feature-targeting-without-color'
    ],
    js: [
        'hyle'
    ]
};

if(themeDefinition.quick) {
    mix.sass('resources/amoschou/hyle/sass/theme-light-' + themeDefinition.primaryColours[0].name + '-' + themeDefinition.secondaryColours[0].name + '.scss', 'public/css', mdcOptions);
    mix.sass('resources/amoschou/hyle/sass/theme-dark-' + themeDefinition.primaryColours[0].name + '-' + themeDefinition.secondaryColours[0].name + '.scss', 'public/css', mdcOptions);
} else {
    themeDefinition.primaryColours.forEach(primaryColour => {
        themeDefinition.secondaryColours.forEach(secondaryColour => {
            mix.sass('resources/amoschou/hyle/sass/theme-light-' + primaryColour.name + '-' + secondaryColour.name + '.scss', 'public/css', mdcOptions);
            mix.sass('resources/amoschou/hyle/sass/theme-dark-' + primaryColour.name + '-' + secondaryColour.name + '.scss', 'public/css', mdcOptions);
        });
    });    
}

files.sass.forEach(file => {
    mix.sass('resources/amoschou/hyle/sass/' + file + '.scss', 'public/css', mdcOptions);
});

files.js.forEach(file => {
    mix.js('resources/amoschou/hyle/js/' + file + '.js', 'public/js');
});

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .postCss('resources/css/app.css', 'public/css', [
        require('postcss-import'),
        require('tailwindcss'),
]);

if (mix.inProduction()) {
    mix.version();
}
