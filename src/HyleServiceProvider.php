<?php

namespace AMoschou\Hyle;

use AMoschou\Hyle\Console\InstallCommand;
use AMoschou\Hyle\Components\{
    Button,
    Checkbox,
    CircularProgress,
    Dialog,
    Drawer,
    FloatingActionButton,
    FormField,
    Radio,
    Select,
    SwitchComponent,
    TextField,
    TopAppBar,
};
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class HyleServiceProvider extends ServiceProvider
{
    /**
    * Register any application services.
    *
    * @return void
    */
    public function register()
    {
        //
    }

    /**
    * Bootstrap any application services.
    *
    * @return void
    */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
            ]);

            $this->publishes([
                __DIR__.'/../resources/config/theme-definition.json' => config_path('hyle.json'),
            ], 'config');
        }

        $this->loadViewComponentsAs('hyle', [
            Button::class,
            Checkbox::class,
            CircularProgress::class,
            Dialog::class,
            Drawer::class,
            FormField::class,
            Radio::class,
            Select::class,
            TextField::class,
            TopAppBar::class,
        ]);

        Blade::component('hyle-fab', FloatingActionButton::class);
        Blade::component('hyle-switch', SwitchComponent::class);

        $this->loadViewsFrom(__DIR__.'/resources/views', 'hyle');
    }
}
