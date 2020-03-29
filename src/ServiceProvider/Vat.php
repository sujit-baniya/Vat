<?php
namespace MadeITBelgium\Vat\ServiceProvider;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use MadeITBelgium\Vat\Vat as V;
use Illuminate\Support\Facades\Validator;

/**
 *
 * PHP Vat Library
 *
 * @version    1.0.0
 * @package    madeitbelgium/vat
 * @copyright  Copyright (c) 2016 Made I.T. (http://www.madeit.be) - TPWeb.org (http://www.tpweb.org)
 * @author     Made I.T. <info@madeit.be>
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 */
class Vat extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    protected $rules = [
        'vat'
    ];

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/lang', 'vat');
        $this->addNewRules();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('vat', function ($app) {
            return new V(null);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['vat'];
    }

    protected function addNewRules()
    {
        foreach ($this->rules as $rule)
        {
            $this->extendValidator($rule);
        }
    }

    protected function extendValidator($rule)
    {
        $method = 'validate' . Str::studly($rule);
        Validator::extend($rule, 'MadeITBelgium\Vat\Validation\ValidatorExtensions@' . $method);
    }
}
