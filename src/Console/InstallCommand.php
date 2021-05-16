<?php

namespace AMoschou\Hyle\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hyle:install'
                            .'{--quick : Indicates that one primary colour and one secondary colour will be prepared}';
                            // .'{--alpha : Indicates that the alpha stack should be installed}'
                            // .'{--composer=global : Absolute path to the Composer binary which should be used to install packages}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Hyle';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // if ($this->option('alpha')) {
        //     return $this->installAlphaStack();
        // }

        // NPM Packages (None dev)
        $this->updateNodePackages(function ($packages) {
            return [
                'material-components-web' => '^11.0.0',
            ] + $packages;
        }, false);

        // NPM Packages (Dev)
        $this->updateNodePackages(function ($packages) {
            return [
                'sass' => '^1.32.8',
                'sass-loader' => '^10.1.1'
            ] + $packages;
        }, true);

        // Controllers...
        // (new Filesystem)->ensureDirectoryExists(app_path('Http/Controllers/Auth'));
        // (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/default/App/Http/Controllers/Auth', app_path('Http/Controllers/Auth'));

        // Requests...
        // (new Filesystem)->ensureDirectoryExists(app_path('Http/Requests/Auth'));
        // (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/default/App/Http/Requests/Auth', app_path('Http/Requests/Auth'));

        // Views...
        // (new Filesystem)->ensureDirectoryExists(resource_path('views/auth'));
        // (new Filesystem)->ensureDirectoryExists(resource_path('views/layouts'));
        // (new Filesystem)->ensureDirectoryExists(resource_path('views/components'));

        // (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/default/resources/views/auth', resource_path('views/auth'));
        // (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/default/resources/views/layouts', resource_path('views/layouts'));
        // (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/default/resources/views/components', resource_path('views/components'));

        // copy(__DIR__.'/../../stubs/default/resources/views/dashboard.blade.php', resource_path('views/dashboard.blade.php'));

        // Components...
        // (new Filesystem)->ensureDirectoryExists(app_path('View/Components'));
        // (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/default/App/View/Components', app_path('View/Components'));

        // Tests...
        // (new Filesystem)->copyDirectory(__DIR__.'/../../stubs/default/tests/Feature', base_path('tests/Feature'));

        // Routes...
        // copy(__DIR__.'/../../stubs/default/routes/web.php', base_path('routes/web.php'));
        // copy(__DIR__.'/../../stubs/default/routes/auth.php', base_path('routes/auth.php'));

        // "Dashboard" Route...
        // $this->replaceInFile('/home', '/dashboard', resource_path('views/welcome.blade.php'));
        // $this->replaceInFile('Home', 'Dashboard', resource_path('views/welcome.blade.php'));
        // $this->replaceInFile('/home', '/dashboard', app_path('Providers/RouteServiceProvider.php'));

        // Tailwind / Webpack...
        // copy(__DIR__.'/../../stubs/default/tailwind.config.js', base_path('tailwind.config.js'));
        // copy(__DIR__.'/../../stubs/default/webpack.mix.js', base_path('webpack.mix.js'));
        // copy(__DIR__.'/../../stubs/default/resources/css/app.css', resource_path('css/app.css'));
        // copy(__DIR__.'/../../stubs/default/resources/js/app.js', resource_path('js/app.js'));

        $vendor = 'amoschou';
        $package = "{$vendor}/hyle";
        $types = [
            'sass' => 'scss',
            'js' => 'js'
        ];

        (new Filesystem)->ensureDirectoryExists(resource_path($vendor));
        (new Filesystem)->ensureDirectoryExists(resource_path($package));
        foreach($types as $folder => $suffix) {
            (new Filesystem)->ensureDirectoryExists(resource_path("{$package}/{$folder}"));
        }

        $files = [
            'sass' => [
                'hyle',                     // Generates material components CSS with factory settings
                // 'baseline-default-new',     // MDC Web with three chosen colours
                // '_pre',                     // This is where the individual themes are defined.
                // '_post',                    //
                // '_mixins',                  //
                'fix-theme',                //
                // 'fix-top-app-bar',          //
                // 'hyle-mdc-top-app-bar',
                // 'feature-targeting-without-color',
                // 'hylemin'
            ],
            'js' => [
                'hyle'                      // 
            ]
        ];

        foreach ($types as $folder => $suffix) {
            foreach ($files[$folder] as $file) {
                copy(__DIR__."/../../resources/{$folder}/{$file}.{$suffix}", resource_path("{$package}/{$folder}/{$file}.{$suffix}"));
            }
        }

        $resourcePath = resource_path("{$package}/sass/feature-targeting-without-color.scss");
        copy(__DIR__."/../../resources/sass/feature-targeting-without-color.stub", $resourcePath);

        $themeDefinitionArray = json_decode(file_get_contents(config_path('hyle.json')), true);

        // Here, we need to convert the JSON array to a SASS/CSS string
        // 1. Escape-quote each element if it contains a space (literally with two characters \ and ").
        // 2. Implode it, comma separated
        // 3. Escape any single quotes
        // e.g. JSON ["First font", "Second", "Andrew's font"] needs to become in the SASS file something like:
        //      $font: ( font-family: unquote('\"First font\", Second, \"Andrew\'s font\"') );
        //      which is eventually compiled into the CSS something like:
        //      .class-name { font-family: "First font", Second, "Andrew's font"; }
        $fontFamily = [];
        foreach($themeDefinitionArray['fontFamily']['styles'] as $fontLabel => $fontList) {
            $fontFamily[$fontLabel] = [];
            foreach($fontList as $font) {
                $q = str_contains($font, ' ') ? '\"' : '';
                //$q = '';
                $fontFamily[$fontLabel][] = $q.$font.$q;
            }
            $fontFamily[$fontLabel] = implode(', ', $fontFamily[$fontLabel]);
            $fontFamily[$fontLabel] = str_replace('\'', '\\\'', $fontFamily[$fontLabel]);
        }

        $featureTargets = [
            'structure' => [],
            'animation' => [],
            'color' => [
                'primaryColours' => $this->option('quick') ? [$themeDefinitionArray['primaryColours'][0]] : $themeDefinitionArray['primaryColours'],
                'secondaryColours' => $this->option('quick') ? [$themeDefinitionArray['secondaryColours'][0]] : $themeDefinitionArray['secondaryColours'],
            ],
            'typography' => [
                'fontFamily' => $fontFamily
            ],
        ];
        //$this->info(var_dump($fontFamily));

        $this->replaceInFile('{{ fontStyle::headline1 }}', $themeDefinitionArray['fontFamily']['map']['headline1'] ?? 'default', $resourcePath);
        $this->replaceInFile('{{ fontStyle::headline2 }}', $themeDefinitionArray['fontFamily']['map']['headline2'] ?? 'default', $resourcePath);
        $this->replaceInFile('{{ fontStyle::headline3 }}', $themeDefinitionArray['fontFamily']['map']['headline3'] ?? 'default', $resourcePath);
        $this->replaceInFile('{{ fontStyle::headline4 }}', $themeDefinitionArray['fontFamily']['map']['headline4'] ?? 'default', $resourcePath);
        $this->replaceInFile('{{ fontStyle::headline5 }}', $themeDefinitionArray['fontFamily']['map']['headline5'] ?? 'default', $resourcePath);
        $this->replaceInFile('{{ fontStyle::headline6 }}', $themeDefinitionArray['fontFamily']['map']['headline6'] ?? 'default', $resourcePath);
        $this->replaceInFile('{{ fontStyle::subtitle1 }}', $themeDefinitionArray['fontFamily']['map']['subtitle1'] ?? 'default', $resourcePath);
        $this->replaceInFile('{{ fontStyle::subtitle2 }}', $themeDefinitionArray['fontFamily']['map']['subtitle2'] ?? 'default', $resourcePath);
        $this->replaceInFile('{{ fontStyle::body1 }}', $themeDefinitionArray['fontFamily']['map']['body1'] ?? 'default', $resourcePath);
        $this->replaceInFile('{{ fontStyle::body2 }}', $themeDefinitionArray['fontFamily']['map']['body2'] ?? 'default', $resourcePath);
        $this->replaceInFile('{{ fontStyle::caption }}', $themeDefinitionArray['fontFamily']['map']['caption'] ?? 'default', $resourcePath);
        $this->replaceInFile('{{ fontStyle::button }}', $themeDefinitionArray['fontFamily']['map']['button'] ?? 'default', $resourcePath);
        $this->replaceInFile('{{ fontStyle::overline }}', $themeDefinitionArray['fontFamily']['map']['overline'] ?? 'default', $resourcePath);
        unset($resourcePath);

        // CREATE THE CONSTANTS STRING AND THEN INSERT INTO THE CONSTANTS FILE
        $resourcePath = resource_path("{$package}/sass/_constants.scss");
        copy(__DIR__."/../../resources/sass/_constants.stub", $resourcePath);
        $block = [];
        foreach(['primary', 'secondary'] as $primarySecondary) {
            $block[] = '// '.$primarySecondary.' colours';
            foreach($featureTargets['color']["{$primarySecondary}Colours"] as $colour) {
                if(isset($colour['value']) && isset($colour['desaturated'])) {
                    $block[] = '$'.$colour['name'].': '.(substr($colour['value'], 0, 1) === '#' ? '' : 'cp.$') . $colour['value'] . ';';
                    $block[] = '$'.$colour['name'].'-desaturated: '.(substr($colour['desaturated'], 0, 1) === '#' ? '' : 'cp.$') . $colour['desaturated'] . ';';
                }
                if(isset($colour['value']) && !isset($colour['desaturated'])) {
                    $block[] = '$'.$colour['name'].': '.(substr($colour['value'], 0, 1) === '#' ? '' : 'cp.$') . $colour['value'] . ';';
                    $block[] = '$'.$colour['name'].'-desaturated: color.mix($white, $'.$colour['name'].', 40%);';
                }
                if(!isset($colour['value']) && isset($colour['desaturated'])) {
                    $block[] = '$'.$colour['name'].'-desaturated: '.(substr($colour['desaturated'], 0, 1) === '#' ? '' : 'cp.$') . $colour['desaturated'] . ';';
                    $block[] = '$'.$colour['name'].': rgb(math.clamp(0, color.red($'.$colour['name'].'-desaturated)*5/3-170, 255), math.clamp(0, color.green($'.$colour['name'].'-desaturated)*5/3-170, 255), math.clamp(0, color.blue($'.$colour['name'].'-desaturated)*5/3-170, 255));' ;
                }
                if(!isset($colour['value']) && !isset($colour['desaturated'])) {
                    throw new \Exception('Undefined theme colour.');                    
                }
                $block[] = '$'.$colour['name'].'-dark: color.mix($'.$colour['name'].'-desaturated, $dark, 8%);';
            }
        }
        $this->replaceInFile('{{ themeColours }}', implode("\n", $block), $resourcePath);

        $s = '';
        foreach($featureTargets['typography']['fontFamily'] as $fontLabel => $fontList) {
            $s .= '$font-' . $fontLabel . ': (' . "\n";
            $s .= '    font-family: unquote(\'{{ themeFontFamily::' . $fontLabel . ' }}\')' . "\n";
            $s .= ');' . "\n";
        }
        $this->replaceInFile('{{ themeFonts }}', $s, $resourcePath);
        foreach($featureTargets['typography']['fontFamily'] as $fontLabel => $fontList) {
            $this->replaceInFile('{{ themeFontFamily::' . $fontLabel . ' }}', $featureTargets['typography']['fontFamily'][$fontLabel], $resourcePath);
        }

        // $this->replaceInFile('{{ themeFontFamily }}', $featureTargets['typography']['fontFamily'], $resourcePath);
        unset($resourcePath);

        // CREATE THE THEME DEFINITIONS AND THEN INSERT INTO THE _PRE.SCSS FILE
        $resourcePath = resource_path("{$package}/sass/_pre.scss");
        copy(__DIR__."/../../resources/sass/_pre.stub", $resourcePath);
        $i_max = count(['light', 'dark']);
        $j_max = count($featureTargets['color']['primaryColours']);
        $k_max = count($featureTargets['color']['secondaryColours']);
        $a = [];
        $indent = '';
        $a[] = $indent . '(';
        for($i = 0 ; $i < $i_max ; $i++) {
            $indent = '    ';
            $lightDark = match ($i) {0 => 'light', 1 => 'dark'};
            $a[] = $indent . "'{$lightDark}': (";
            for($j = 0 ; $j < $j_max ; $j++) {
                $indent = '        ';
                $primaryColour = $featureTargets['color']['primaryColours'][$j];
                $a[] = $indent . "'{$primaryColour['name']}': (";
                for($k = 0 ; $k < $k_max ; $k++) {
                    $indent = '            ';
                    $secondaryColour = $featureTargets['color']['secondaryColours'][$k];
                    $a[] = $indent . "'{$secondaryColour['name']}': (";
                    $indent = '                ';
                    $a[] = $indent .    '\'primary\': c.$' .   $primaryColour['name'] . match ($lightDark) {'light' => '',      'dark' => '-desaturated'}    . ',';
                    $a[] = $indent .  '\'secondary\': c.$' . $secondaryColour['name'] . match ($lightDark) {'light' => '',      'dark' => '-desaturated'}    . ',';
                    $a[] = $indent . '\'background\': c.$'                            . match ($lightDark) {'light' => 'white', 'dark' => 'background-dark'} . ',';
                    $a[] = $indent .    '\'surface\': c.$'                            . match ($lightDark) {'light' => 'white', 'dark' => 'surface-dark'}    . ',';
                    $a[] = $indent .      '\'error\': c.$' . 'error'                  . match ($lightDark) {'light' => '',      'dark' => '-desaturated'};
                    $indent = '            ';
                    $a[] = $indent . ')' . ($k === $k_max - 1 ? '' : ',');
                }
                $indent = '        ';
                $a[] = $indent . ')' . ($j === $j_max - 1 ? '' : ',');
            }
            $indent = '    ';
            $a[] = $indent . ')' . ($i === $i_max - 1 ? '' : ',');
        }
        $indent = '';
        $a[] = $indent . ');';
        $this->replaceInFile('{{ themeDefinitions }}', implode("\n", $a), $resourcePath);

        // foreach (['light', 'dark'] as $lightDark) {
        //     // $indent = '    ';
        //     // $a[] = $indent . "'{$lightDark}': (";
        //     foreach ($featureTargets['color']['primaryColours'] as $primaryColour) {
        //         $indent = '        ';
        //         $a[] = $indent . "'{$primaryColour['name']}': (";
        //         foreach ($featureTargets['color']['secondaryColours'] as $secondaryColour) {
        //             $indent = '            ';
        //             $a[] = $indent . "'{$secondaryColour['name']}': (";
        //             $indent = '                ';
        //             $a[] = $indent . '\'primary\': c.$' . $primaryColour['name'] . ($lightDark === 'dark' ? '-desaturated' : '') . ',';
        //             $a[] = $indent . '\'secondary\': c.$' . $secondaryColour['name'] . ($lightDark === 'dark' ? '-desaturated' : '') . ',';
        //             $a[] = $indent . '\'background\': c.$'. ($lightDark === 'dark' ? 'background-dark' : 'white') . ',';
        //             $a[] = $indent . '\'surface\': c.$' . ($lightDark === 'dark' ? 'surface-dark' : 'white') . ',';
        //             $a[] = $indent . '\'error\': c.$' . ($lightDark === 'dark' ? '-desaturated' : '');
        //             // $indent = '            ';
        //             // $a[] = $indent . ')';
        //         }
        //         // $indent = '        ';
        //         // $a[] = $indent . ')';
        //     }
        //     // $indent = '    ';
        //     // $a[] = $indent . ')';
        // }
        // // $indent = '';
        // // $a[] = ')';

        // CREATE EACH THEME FILE
        foreach ($featureTargets as $featureTargetQuery => $featureTargetArray) {
            if ($featureTargetArray) {
                if ($featureTargetQuery === 'color') {
                    foreach (['light', 'dark'] as $lightDark) {
                        foreach ($featureTargetArray['primaryColours'] as $primaryColour) {
                            foreach ($featureTargetArray['secondaryColours'] as $secondaryColour) {
                                $resourcePath = resource_path("{$package}/sass/theme-{$lightDark}-{$primaryColour['name']}-{$secondaryColour['name']}.scss");

                                copy(__DIR__."/../../resources/sass/feature-targeting-color.stub", $resourcePath);

                                $nestingLevel = $themeDefinitionArray['nestingLevel'];
                                $themeSpecificers = [];
                                $pre = '';
                                for ($i = 1; $i <= $nestingLevel; $i++) {
                                    $themeSpecificers[] = "{$pre}.theme-{{ lightDark }}-{{ primaryColourLabel }}-{{ secondaryColourLabel }}.theme-level-{$i}";
                                    $pre = "{$pre}.theme-level-{$i} ";
                                }
                                unset($pre);
                                $this->replaceInFile('{{ themeSpecificers }}', implode(",\n", $themeSpecificers), $resourcePath);
                                $this->replaceInFile('{{ lightDark }}', $lightDark, $resourcePath);
                                $this->replaceInFile('{{ primaryColourLabel }}', $primaryColour['name'], $resourcePath);
                                $this->replaceInFile('{{ secondaryColourLabel }}', $secondaryColour['name'], $resourcePath);

                                $this->replaceInFile('{{ fontStyle::headline1 }}', $themeDefinitionArray['fontFamily']['map']['headline1'] ?? 'default', $resourcePath);
                                $this->replaceInFile('{{ fontStyle::headline2 }}', $themeDefinitionArray['fontFamily']['map']['headline2'] ?? 'default', $resourcePath);
                                $this->replaceInFile('{{ fontStyle::headline3 }}', $themeDefinitionArray['fontFamily']['map']['headline3'] ?? 'default', $resourcePath);
                                $this->replaceInFile('{{ fontStyle::headline4 }}', $themeDefinitionArray['fontFamily']['map']['headline4'] ?? 'default', $resourcePath);
                                $this->replaceInFile('{{ fontStyle::headline5 }}', $themeDefinitionArray['fontFamily']['map']['headline5'] ?? 'default', $resourcePath);
                                $this->replaceInFile('{{ fontStyle::headline6 }}', $themeDefinitionArray['fontFamily']['map']['headline6'] ?? 'default', $resourcePath);
                                $this->replaceInFile('{{ fontStyle::subtitle1 }}', $themeDefinitionArray['fontFamily']['map']['subtitle1'] ?? 'default', $resourcePath);
                                $this->replaceInFile('{{ fontStyle::subtitle2 }}', $themeDefinitionArray['fontFamily']['map']['subtitle2'] ?? 'default', $resourcePath);
                                $this->replaceInFile('{{ fontStyle::body1 }}', $themeDefinitionArray['fontFamily']['map']['body1'] ?? 'default', $resourcePath);
                                $this->replaceInFile('{{ fontStyle::body2 }}', $themeDefinitionArray['fontFamily']['map']['body2'] ?? 'default', $resourcePath);
                                $this->replaceInFile('{{ fontStyle::caption }}', $themeDefinitionArray['fontFamily']['map']['caption'] ?? 'default', $resourcePath);
                                $this->replaceInFile('{{ fontStyle::button }}', $themeDefinitionArray['fontFamily']['map']['button'] ?? 'default', $resourcePath);
                                $this->replaceInFile('{{ fontStyle::overline }}', $themeDefinitionArray['fontFamily']['map']['overline'] ?? 'default', $resourcePath);
                            }
                        }
                    }
                    
                }
            }
        }

        // .theme-{{ lightDark }}-{{ primaryColourLabel }}-{{ secondaryColourLabel }}.theme-level-1,
        // .theme-level-1 .theme-{{ lightDark }}-{{ primaryColourLabel }}-{{ secondaryColourLabel }}.theme-level-2,
        // .theme-level-1 .theme-level-2 .theme-{{ lightDark }}-{{ primaryColourLabel }}-{{ secondaryColourLabel }}.theme-level-3

        copy(__DIR__.'/../../webpack.mix.js', base_path('webpack.mix.js'));

        $this->info('Hyle installed.');
        $this->comment('Please execute the "npm install && npm run dev" command to build your assets.');
    }

    /**
     * Install the Alpha stack.
     *
     * @return void
     */
    // protected function installAlphaStack()
    // {
    //     // Install Inertia...
    //     //$this->requireComposerPackages('inertiajs/inertia-laravel:^0.3.5', 'laravel/sanctum:^2.6', 'tightenco/ziggy:^1.0');

    //     // NPM Packages (None dev)
    //     $this->updateNodePackages(function ($packages) {
    //         return [
    //             'material-components-web' => '^10.0.0',
    //         ] + $packages;
    //     }, false);

    //     // NPM Packages (Dev)
    //     $this->updateNodePackages(function ($packages) {
    //         return [
    //             'sass' => '^1.32.8',
    //             'sass-loader' => '^10.1.1'
    //         ] + $packages;
    //     }, true);

    //     // Controllers...
    //     //(new Filesystem)->ensureDirectoryExists(app_path('Http/Controllers/Auth'));
    //     //(new Filesystem)->copyDirectory(__DIR__.'/../../stubs/inertia/app/Http/Controllers/Auth', app_path('Http/Controllers/Auth'));

    //     // Requests...
    //     //(new Filesystem)->ensureDirectoryExists(app_path('Http/Requests/Auth'));
    //     //(new Filesystem)->copyDirectory(__DIR__.'/../../stubs/default/App/Http/Requests/Auth', app_path('Http/Requests/Auth'));

    //     // Middleware...
    //     //$this->installMiddlewareAfter('SubstituteBindings::class', '\App\Http\Middleware\HandleInertiaRequests::class');

    //     //copy(__DIR__.'/../../stubs/inertia/app/Http/Middleware/HandleInertiaRequests.php', app_path('Http/Middleware/HandleInertiaRequests.php'));

    //     // Views...
    //     //copy(__DIR__.'/../../stubs/inertia/resources/views/app.blade.php', resource_path('views/app.blade.php'));

    //     // Components + Pages...
    //     //(new Filesystem)->ensureDirectoryExists(resource_path('js/Components'));
    //     //(new Filesystem)->ensureDirectoryExists(resource_path('js/Layouts'));
    //     //(new Filesystem)->ensureDirectoryExists(resource_path('js/Pages'));

    //     //(new Filesystem)->copyDirectory(__DIR__.'/../../stubs/inertia/resources/js/Components', resource_path('js/Components'));
    //     //(new Filesystem)->copyDirectory(__DIR__.'/../../stubs/inertia/resources/js/Layouts', resource_path('js/Layouts'));
    //     //(new Filesystem)->copyDirectory(__DIR__.'/../../stubs/inertia/resources/js/Pages', resource_path('js/Pages'));

    //     // Tests...
    //     //(new Filesystem)->copyDirectory(__DIR__.'/../../stubs/default/tests/Feature', base_path('tests/Feature'));

    //     // Routes...
    //     //copy(__DIR__.'/../../stubs/inertia/routes/web.php', base_path('routes/web.php'));
    //     //copy(__DIR__.'/../../stubs/inertia/routes/auth.php', base_path('routes/auth.php'));

    //     // "Dashboard" Route...
    //     //$this->replaceInFile('/home', '/dashboard', resource_path('js/Pages/Welcome.vue'));
    //     //$this->replaceInFile('Home', 'Dashboard', resource_path('js/Pages/Welcome.vue'));
    //     //$this->replaceInFile('/home', '/dashboard', app_path('Providers/RouteServiceProvider.php'));

    //     // Tailwind / Webpack...
    //     //copy(__DIR__.'/../../stubs/inertia/tailwind.config.js', base_path('tailwind.config.js'));
    //     //copy(__DIR__.'/../../stubs/inertia/webpack.mix.js', base_path('webpack.mix.js'));
    //     //copy(__DIR__.'/../../stubs/inertia/webpack.config.js', base_path('webpack.config.js'));
    //     //copy(__DIR__.'/../../stubs/inertia/resources/css/app.css', resource_path('css/app.css'));
    //     //copy(__DIR__.'/../../stubs/inertia/resources/js/app.js', resource_path('js/app.js'));

    //     //$this->info('Breeze scaffolding installed successfully.');
    //     //$this->comment('Please execute the "npm install && npm run dev" command to build your assets.');
    // }

    /**
     * Install the middleware to a group in the application Http Kernel.
     *
     * @param  string  $after
     * @param  string  $name
     * @param  string  $group
     * @return void
     */
    // protected function installMiddlewareAfter($after, $name, $group = 'web')
    // {
    //     $httpKernel = file_get_contents(app_path('Http/Kernel.php'));

    //     $middlewareGroups = Str::before(Str::after($httpKernel, '$middlewareGroups = ['), '];');
    //     $middlewareGroup = Str::before(Str::after($middlewareGroups, "'$group' => ["), '],');

    //     if (! Str::contains($middlewareGroup, $name)) {
    //         $modifiedMiddlewareGroup = str_replace(
    //             $after.',',
    //             $after.','.PHP_EOL.'            '.$name.',',
    //             $middlewareGroup,
    //         );

    //         file_put_contents(app_path('Http/Kernel.php'), str_replace(
    //             $middlewareGroups,
    //             str_replace($middlewareGroup, $modifiedMiddlewareGroup, $middlewareGroups),
    //             $httpKernel
    //         ));
    //     }
    // }

    /**
     * Installs the given Composer Packages into the application.
     *
     * @param  mixed  $packages
     * @return void
     */
    // protected function requireComposerPackages($packages)
    // {
    //     $composer = $this->option('composer');

    //     if ($composer !== 'global') {
    //         $command = ['php', $composer, 'require'];
    //     }

    //     $command = array_merge(
    //         $command ?? ['composer', 'require'],
    //         is_array($packages) ? $packages : func_get_args()
    //     );

    //     (new Process($command, base_path(), ['COMPOSER_MEMORY_LIMIT' => '-1']))
    //         ->setTimeout(null)
    //         ->run(function ($type, $output) {
    //             $this->output->write($output);
    //         });
    // }

    /**
     * Update the "package.json" file.
     *
     * @param  callable  $callback
     * @param  bool  $dev
     * @return void
     */
    protected static function updateNodePackages(callable $callback, $dev = true)
    {
        if (! file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages[$configurationKey] = $callback(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }

    /**
     * Delete the "node_modules" directory and remove the associated lock files.
     *
     * @return void
     */
    // protected static function flushNodeModules()
    // {
    //     tap(new Filesystem, function ($files) {
    //         $files->deleteDirectory(base_path('node_modules'));

    //         $files->delete(base_path('yarn.lock'));
    //         $files->delete(base_path('package-lock.json'));
    //     });
    // }

    /**
     * Replace a given string within a given file.
     *
     * @param  string  $search
     * @param  string  $replace
     * @param  string  $path
     * @return void
     */
    protected function replaceInFile($search, $replace, $path)
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }
}
