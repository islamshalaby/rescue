<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(Request $request)
    {
        app()->setLocale($request->lang);
    }

    // slider
    public function slider() {
        try{
            $data = Slider::orderBy('id', 'DESC')->get();

            return createResponse(200, "fetched successfully", null, $data);
        }
        catch(\Exception $e) {
            return createResponse(406, $e->getMessage(), (object)['error' => $e->getMessage()], null);
        }
        
    }
}
