<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;

abstract class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    protected $user;

    public function __construct()
    {
    	$this->user = Auth::user();

    	view()->share('signedIn', Auth::check());
    	view()->share('user', $this->user);
    }
}
