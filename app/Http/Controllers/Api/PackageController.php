<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    // show packages
    public function index(Request $request) {
        try{
            app()->setLocale($request->lang);
            $packages = Package::orderBy('id', 'desc')->get();
    
            return createResponse(200, "fetched successfully", null, $packages);
        }
        catch(\Exception $e) {
            return createResponse(406, $e->getMessage(), (object)['error' => $e->getMessage()], null);
        }
    }
}
