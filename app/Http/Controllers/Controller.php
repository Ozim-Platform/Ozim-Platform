<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Route;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $controller_name = false;

    public function __construct()
    {

        $this->controller_name = $this->controllerName();
        view()->share('controller_name', $this->controller_name);
    }

    protected function controllerName()
    {
        if ( !app()->runningInConsole() ){
            if ($this->controller_name === false) {
                $str = Route::current()->getName();
//            $this->controller_name = explode('.', $str)[0];
                $this->controller_name = $str;
            }
            return $this->controller_name;
        }
    }
}
