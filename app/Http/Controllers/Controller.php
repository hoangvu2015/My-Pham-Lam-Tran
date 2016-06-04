<?php

namespace Antoree\Http\Controllers;

use Antoree\Models\UserSession;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;

abstract class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * @var boolean
     */
    public $is_auth;

    /**
     * @var \Antoree\Models\User
     */
    public $auth_user;

    /**
     * @var string
     */
    public $locale;

    public function __construct(Request $request)
    {
        $this->locale = currentLocale();
        $this->is_auth = isAuth();
        $this->auth_user = authUser();

        if(!$request->ajax()) {
            if ($this->is_auth) {
                $own_directory = $this->auth_user->ownDirectory;
                config(['filesystems.disks.' . $own_directory => [
                    'driver' => 'local',
                    'root' => storage_path('app/file_manager/' . $own_directory),
                ]]);
            }
        }
    }
}
