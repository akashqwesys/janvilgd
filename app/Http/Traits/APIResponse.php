<?php

namespace App\Http\Traits;

/*use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;*/

trait APIResponse
{
    /**
     *
     * @return \Illuminate\Http\Response
     */
    /*
    * 200 => OK
    * 400 => Bad Request
    * 401 => Unauthorized
    * 403 => Forbidden
    * 404 => Not Found
    * 405 => Method Not Allowed
    * 409 => Conflict
    * 429 => Too Many Requests
    * 503 => Service Unavailable
    */
    protected static function successResponse($message, $result = [], $code = 0, $status_code = 200)
    {
        // code => 1 indicates redirect to Dashboard screen
        // code => 2 indicates redirect to Sign up screen
        // code => 11 indicates user's account deleted
        // code => 3 indicates success response
        $response = [
            'flag' => true,
            'code' => $code,
            'message' => $message,
            'data' => $result
        ];

        return response()->json($response, $status_code);
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    protected static function errorResponse($error, $status_code = 403, $code = 0, $errorMessages = [])
    {
        // code => 9 indicates token expired
        $response = [
            'flag' => false,
            'code' => $code,
            'message' => $error,
            'data' => $errorMessages
        ];

        return response()->json($response, $status_code);
    }

    // Function to check array is multi-dimensional or not
    function is_multi($result)
    {

        $rv = array_filter($result, 'is_array');

        if (count($rv) > 0) return true;

        return false;
    }
}
