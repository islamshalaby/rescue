<?php
  
use File;
use Illuminate\Support\Facades\App as FacadesApp;

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
