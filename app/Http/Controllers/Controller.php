<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        return view('getting-started', [
        ]);
    }
    public function analyticsDashboard()
    {
        return view('analytics-dashboard', [
        ]);
    }
    public function account()
    {
        return view('account', [
        ]);
    }
}
