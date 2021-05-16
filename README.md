# Hyle

Material Components for the web as a Laravel package.

© Andrew Gilbert Moschou 2021

This package has two purposes:

1. Exposes Material Design UI components to the Laravel developer as view components.
2. Implements a theming system

## Installation

1. `composer require amoschou/hyle`

2. `php artisan vendor:publish` and select `AMoschou\Hyle\HyleServiceProvider`.
   This publishes `config/hyle.json`, which can be configured before installation.

3. `php artisan hyle:install`
   This command installs Hyle and configures the themes. This must be done after step 2, it assumes `config/hyle.json` is present.

4. `npm install && npm run dev`
   Install dependencies and run `mix` to compile assets according to `webpack.mix.js`.

## Usage

### Themes

This package helps the user to define multiple themes, and generates the Sass and CSS files to manage them. One aspect of Material themes is colour, and the primary and secondary colours are principal to this. `config/hyle.json` defines a list of primary colours and a list of secondary colours. When Hyle is installed into a Laravel application, all combinations of primary and secondary colours are managed. For example, if there are four primary colours and two secondary colours defined, then eight combinations of primary and secondary colours will be generated. Furthermore, a light theme and a dark theme is generated for each combination, reaching a total of sixteen CSS themes.

Each element of the array `primaryColours` and `secondaryColours` has a `name`, a `value` and a `desaturated` property. `name` is a string to label the colour, `value` is the colour as used in light themes and `desaturated` is the colour as used in dark themes. These can be a string that matches one of the colours of Material colour pallette from 2014 (e.g. `deep-purple-500`), or a hexadecimal string of the form `#123456` representing the literal RGB colour. In the future, this may be expanded to include other colour pallettes in an easy way. If one of `value` and `desaturated` are omitted, then values will be generated automatically, which may be suitable.

### Components


