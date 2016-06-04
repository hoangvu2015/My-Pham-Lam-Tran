<?php

namespace Antoree\Providers;

use Mcamara\LaravelLocalization\LaravelLocalizationServiceProvider as LaravelLocalizationServiceProvider;
use Antoree\Models\ServiceProviders\CustomLocalization;

class CustomLocalizationServiceProvider extends LaravelLocalizationServiceProvider
{
    /**
     * Register the service provider.
     * Overwrite service Mcamara
     * @return void
     */
    public function register()
    {
    	$packageConfigFile = __DIR__ . '/../../config/laravellocalization.php';

    	$this->mergeConfigFrom(
    		$packageConfigFile, 'laravellocalization'
    		);

    	$this->app[ 'laravellocalization' ] = $this->app->share(
    		function ()
    		{
    			return new CustomLocalization();
    		}
    		);
    }
}
