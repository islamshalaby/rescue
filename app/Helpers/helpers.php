<?php

use Illuminate\Support\Facades\App as FacadesApp;
use Illuminate\Support\Facades\File;

/**
 * Write code on Method
 *
 * @return response()
 */
if (! function_exists('createResponse')) {
    function createResponse($status,$message="", $errors=null, $data=null)
    {
        if ($errors == null) {
            $errors = (object)[];
        }
        if ($data == null) {
            $data = (object)[];
        }
        
        return response()->json([
            'status' => $status,
            'message' => $message,
            'errors' => $errors,
            'data' => $data
        ], $status);
    }
}

if (! function_exists('translate')) {
    function translate($key, $section)
    {
        $local = session()->has('local') ? session('local') : \app()->getLocale();
        FacadesApp::setLocale($local);
        $file = base_path('resources/lang/' . $local . '/' . $section .'.php');
        if(! file_exists($file)){
            File::put($file,'<?php return [];');
        }
        $lang_array = include(base_path('resources/lang/' . $local . '/' . $section .'.php'));
        $processed_key = ucfirst(str_replace('_', ' ', $key));
        if (!array_key_exists($key, $lang_array)) {
            $lang_array[$key] = $processed_key;
            $str = "<?php return " . var_export($lang_array, true) . ";";
            file_put_contents(base_path('resources/lang/' . $local . '/' . $section . '.php'), $str);
            $result = $processed_key;
        } else {
            $result = __($section . '.' . $key);
        }
        return $result;
    }
}

if (! function_exists('my_fatoorah')) {
    function my_fatoorah($customer_name, $price, $call_back_url, $error_url, $customer_email)
    {
        $path='https://apitest.myfatoorah.com/v2/SendPayment';
        $token="bearer " . env('MY_FATOORAH_TOKEN');
        if (env('APP_ENV') == 'production') {
            $path = "https://api.myfatoorah.com/v2/SendPayment";
        }

        $headers = array(
            'Authorization:' .$token,
            'Content-Type:application/json'
        );

        $fields =array(
            "CustomerName" => $customer_name,
            "NotificationOption" => "LNK",
            "InvoiceValue" => $price,
            "CallBackUrl" => $call_back_url,
            "ErrorUrl" => $error_url,
            "Language" => "AR",
            "CustomerEmail" => $customer_email
        );
        
        $payload =json_encode($fields);
        $curl_session =curl_init();
        curl_setopt($curl_session,CURLOPT_URL, $path);
        curl_setopt($curl_session,CURLOPT_POST, true);
        curl_setopt($curl_session,CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl_session,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl_session,CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_session,CURLOPT_IPRESOLVE, CURLOPT_IPRESOLVE);
        curl_setopt($curl_session,CURLOPT_POSTFIELDS, $payload);
        $result=curl_exec($curl_session);
        curl_close($curl_session);
        $result = json_decode($result);

        return $result;
    }
}