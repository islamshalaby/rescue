<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\AddEmergencyMessagesRequest;
use App\Http\Requests\Api\User\BuyPackageRequest;
use App\Http\Requests\Api\User\ExcutePayRequest;
use App\Http\Requests\Api\User\TechnicalSupportRequest;
use App\Models\EmergencyMessage;
use App\Models\Package;
use App\Models\TechnicalSupport;
use App\Models\Transation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(Request $request)
    {
        app()->setLocale($request->lang);
    }
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
    public function excute_pay(ExcutePayRequest $request) {
        $request->headers->set('Accept', 'application/json');
        
        try{
            $user = User::where('id', $request->user_id)->select('id', 'package_id')->first();
            $package = Package::where('id', $request->package_id)->select('id', 'period')->first();
            $today = Carbon::now();

            $user->update(['package_id' => $request->package_id, 'package_expire' => $today->addDays($package->period)]);
            Transation::create([
                    'user_id' => $request->user_id,
                    'package_id' => $request->package_id,
                    'price' => $request->price
                ]);

            return redirect()->route('pay.success');
        }
        catch(\Exception $e) {
            return createResponse(406, $e->getMessage(), (object)['error' => $e->getMessage()], null);
        }
    }

    public function pay_sucess(Request $request){
        return "Please wait ...";
    }

    public function pay_error(Request $request){
        return "Please wait ...";
    }

    // transactions
    public function transactions(Request $request) {
        try{
            $user = auth()->user();
            $data = Transation::where('user_id', $user->id)->with('package')->select('id', 'package_id', 'price', 'created_at')->orderBy('id', 'desc')->get();

            return createResponse(200, "fetched successfully", null, $data);
        }
        catch(\Exception $e) {
            return createResponse(406, $e->getMessage(), (object)['error' => $e->getMessage()], null);
        }
    }

    // add emergency messages
    public function add_emergency_messages(AddEmergencyMessagesRequest $request) {
        try{
            $user = auth()->user();
            $post = $request->except('image');
            $post['user_id'] = $user->id;
            $data = EmergencyMessage::create($post);
            if ($request->image && !empty($request->image)) {
                $data->attachMedia($request->image);
            }
            
            return createResponse(200, "fetched successfully", null, $data);
        }
        catch(\Exception $e) {
            return createResponse(406, $e->getMessage(), (object)['error' => $e->getMessage()], null);
        }
    }

    // user data
    public function user_data() {
        try{
            $user_id = auth()->user()->id;
            $user = User::where('id', $user_id)->select('id', 'name', 'phone', 'image', 'package_id')->with('package')->first();

            return createResponse(200, "fetched successfully", null, $user);
        }
        catch(\Exception $e) {
            return createResponse(406, $e->getMessage(), (object)['error' => $e->getMessage()], null);
        }
    }

    // technical support
    public function technical_support(TechnicalSupportRequest $request) {
        try{
            $user_id = auth()->user()->id;
            $post = $request->all();
            $post['user_id'] = $user_id;
            
            $data = TechnicalSupport::create($post);

            return createResponse(200, "fetched successfully", null, $data);
        }
        catch(\Exception $e) {
            return createResponse(406, $e->getMessage(), (object)['error' => $e->getMessage()], null);
        }
    }
}
