<?php
  
use Carbon\Carbon;
  
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