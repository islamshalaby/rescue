<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\BuyPackageRequest;
use App\Models\Package;

class UserController extends Controller
{
    // buy package
    public function buy_package(BuyPackageRequest $request) {
        try{
            $user = auth()->user();
            $package = Package::where('id', $request->package_id)->select('price')->first();
            $root_url = $request->root();
            $success_url = $root_url."/api/excute_pay?user_id=" . $user->id . "&package_id=" . $request->package_id . "&price=" . $package->price;
            $error_url = $root_url."/api/pay/error";
            $payment = my_fatoorah($user->name, $package->price, $success_url, $error_url, $user->email);
            
            $data['url'] = $payment->Data->InvoiceURL;
    
            return createResponse(200, "fetched successfully", null, $data);
        }
        catch(\Exception $e) {
            return createResponse(406, $e->getMessage(), (object)['error' => $e->getMessage()], null);
        }
    }

    // execute pay
    public function excute_pay() {
        
    }
}
