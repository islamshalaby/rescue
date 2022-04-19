<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\AddEmergencyMessagesRequest;
use App\Http\Requests\Api\User\BuyPackageRequest;
use App\Http\Requests\Api\User\CheckPhoneExistenceRequest;
use App\Http\Requests\Api\User\ExcutePayRequest;
use App\Http\Requests\Api\User\ResetForgottenPasswordRequest;
use App\Http\Requests\Api\User\ResetPasswordRequest;
use App\Http\Requests\Api\User\TechnicalSupportRequest;
use App\Http\Requests\Api\User\UpdateImageRequest;
use App\Http\Requests\Api\User\UpdateProfileRequest;
use App\Models\EmergencyMessage;
use App\Models\Package;
use App\Models\TechnicalSupport;
use App\Models\Transation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(Request $request)
    {
        app()->setLocale($request->lang);
        $this->middleware('auth:sanctum')->except(['checkphoneexistance', 'resetforgettenpassword']);
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
            $user = User::where('id', $user_id)->select('id', 'name', 'phone', 'package_id')->with('package')->first();
            $user->image = "";
            if ($user->fetchFirstMedia()) {
                $user->image = $user->fetchFirstMedia()->file_url;
            }

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

    // check if phone exists before or not
    public function checkphoneexistance(CheckPhoneExistenceRequest $request)
    {
        try{
            $user = User::where('phone' , $request->phone)->where('active', 1)->where('verified', 1)->first();
            $response['phone'] = false;
            if($user){
                $response['phone'] = true;
            }

            return createResponse(200, "fetched successfully", null, $response);
        }
        catch(\Exception $e) {
            return createResponse(406, $e->getMessage(), (object)['error' => $e->getMessage()], null);
        }
    }

    public function resetforgettenpassword(ResetForgottenPasswordRequest $request){
        try{
            $user = User::where('phone', $request->phone)->first();

            User::where('phone' , $user->phone)->update(['password' => bcrypt($request->password)]);
            $newuser = User::where('phone' , $user->phone)->first();
            $newuser->token = $newuser->createToken('auth-token')->plainTextToken;

            return createResponse(200, "fetched successfully", null, $newuser);
        }
        catch(\Exception $e) {
            return createResponse(406, $e->getMessage(), (object)['error' => $e->getMessage()], null);
        }
    }

    public function resetpassword(ResetPasswordRequest $request){
        try{
            $user = auth()->user();
            if(!Hash::check($request->old_password, $user->password)){
                return createResponse(406, "Wrong old password", (object)['error' => ["Wrong old password"]], null);
            }
            if($request->old_password == $request->password){
                return createResponse(406, "You cannot set the same previous password", (object)['error' => ["You cannot set the same previous password"]], null);
            }
            User::where('id' , $user->id)->update(['password' => bcrypt($request->password)]);
            $newuser = User::find($user->id);

            return createResponse(200, "fetched successfully", null, $newuser);
        }
        catch(\Exception $e) {
            return createResponse(406, $e->getMessage(), (object)['error' => $e->getMessage()], null);
        }
    }

    public function updateProfile(UpdateProfileRequest $request) {
        try{
            $post = $request->all();

            $user = user::where('id', auth()->user()->id)->first();
            $user->update($post);

            return createResponse(200, "fetched successfully", null, $user);
        }
        catch(\Exception $e) {
            return createResponse(406, $e->getMessage(), (object)['error' => $e->getMessage()], null);
        }
    }

    public function update_image(UpdateImageRequest $request) {
        try{
            $user = user::where('id', auth()->user()->id)->first();
            $user->updateMedia($request->image);

            return createResponse(200, "fetched successfully", null, $user);
        }
        catch(\Exception $e) {
            return createResponse(406, $e->getMessage(), (object)['error' => $e->getMessage()], null);
        }
    }
}
