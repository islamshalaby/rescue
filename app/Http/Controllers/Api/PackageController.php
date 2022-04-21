<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function __construct(Request $request)
    {
        app()->setLocale($request->lang);
        $this->middleware('auth:sanctum')->except('');
    }
    // show packages
    public function index(Request $request) {
        try{
            $packages = Package::orderBy('id', 'desc')->get()->makeHidden(['title', 'description']);
    
            return createResponse(200, "fetched successfully", null, $packages);
        }
        catch(\Exception $e) {
            return createResponse(406, $e->getMessage(), (object)['error' => $e->getMessage()], null);
        }
    }
}
