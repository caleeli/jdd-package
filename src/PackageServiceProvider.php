<?php

namespace JDD\Example;

use App\Menu;
use App\User;
use Illuminate\Support\ServiceProvider;
use JDD\Example\Console\Commands\UpdatePackage;

class PackageServiceProvider extends ServiceProvider
{
    const PluginName = 'jdd/example';

    /**
     * If your plugin will provide any services, you can register them here.
     * See: https://laravel.com/docs/5.6/providers#the-register-method
     */
    public function register()
    {
        // Nothing is registered at this time
    }

    /**
     * After all service provider's register methods have been called, your boot method
     * will be called. You can perform any initialization code that is dependent on
     * other service providers at this time.  We've included some example behavior
     * to get you started.
     *
     * See: https://laravel.com/docs/5.6/providers#the-boot-method
     */
    public function boot()
    {
        // Register artisan commands
        $this->commands([UpdatePackage::class]);
        // Publish vendors
        $this->publishes([
            // Publish assets
            __DIR__ . '/../dist' => public_path('modules/' . self::PluginName),
            // Publish configurations
            //__DIR__ . '/../config/test.php' => config_path('test.php'),
        ], self::PluginName);
        // Register migrations
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        // Register assets
        app('config')->push('plugins.javascript', '/modules/' . self::PluginName . '/jdd-package.umd.min.js');
        // Register models for json api and swagger
        app('config')->push('jsonapi.models', __NAMESPACE__ . '\Models');
        app('config')->push('l5-swagger.paths.annotations', __DIR__ . '/../swagger');
        app('config')->push('l5-swagger.paths.annotations', __DIR__ . '/Models');
        // Regiter menus
        Menu::registerChildren(null, [self::class, 'registerMenus']);
        // Register bpmn processes
        app('config')->push('workflow.processes', __DIR__ . '/../bpmn/*.bpmn');
    }

    /**
     * Register additional menus
     *
     * @param array $menus
     * @param User $user
     *
     * @return array
     */
    public static function registerMenus(array $menus, User $user)
    {
        $menus[] = [
            'id' => 'test-module',
            'parent' => null,
            'icon' => 'fas fa-american-sign-language-interpreting',
            'name' => 'Test Module',
        ];
        $menus[] = [
            'id' => uniqid('test', true),
            'parent' => 'test-module',
            'icon' => 'fab fa-500px',
            'name' => 'Test List',
            'action' => 'this.$router.push("/test")',
        ];
        return $menus;
    }
}
