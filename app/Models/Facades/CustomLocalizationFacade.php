<?php 
namespace Antoree\Models\Facades;

use Illuminate\Support\Facades\Facade;

class CustomLocalizationFacade extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravellocalization';
    }
}
