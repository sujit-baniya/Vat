<?php
namespace TPWeb\Vat;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

/**
 *
 * PHP Vat Library
 *
 * @version    1.0.0
 * @package    tpweb/vat
 * @copyright  Copyright (c) 2016 Made I.T. (http://www.madeit.be) - TPWeb.org (http://www.tpweb.org)
 * @author     Made I.T. <info@madeit.be>
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 */
class VatServiceProvider extends ServiceProvider
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
		AliasLoader::getInstance()->alias('Vat', 'TPWeb\Vat\Vat');
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
		$this->app->bind('Vat', 'TPWeb\Vat\Vat');
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
		$translation = $this->app['translator']->get('vat::validation');

		$this->app['validator']->extend($rule, 'TPWeb\Vat\Validation\ValidatorExtensions@' . $method, $translation[$rule]);
	}
}
