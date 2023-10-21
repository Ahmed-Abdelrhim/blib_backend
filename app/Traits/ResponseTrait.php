<?php

namespace App\Traits;

trait ResponseTrait
{

    /**
     * 200 - OK.
     *
     * @return array of json
     */
    public function success200($data = null, $message = 'Success')
    {
        return response()->json([
            'data' => $data,
            'status' => 200,
            'message' => $message,
        ], 200);
    }



    /**
     * 201 - Data Created Successfully.
     *
     * @return array of json
     */
    public function success201($data = null, $message = 'Created')
    {
        return response()->json([
            'data' => $data,
            'status' => 201,
            'message' => $message,
        ], 201);
    }



    /**
     * 202 -The request has been accepted for processing.
     *
     * @return array of json
     */
    public function success202($data = null)
    {
        return response()->json([
            'data' => $data,
            'status' => 202,
            'message' => 'The request has been accepted for processing',
        ], 202);
    }



    /**
     * 400  Bad Request.
     *
     * @return array of json
     */
    public function error400($errors = null, $message = 'Bad Request')
    {
        return response()->json([
            'errors' => $errors,
            'status' => 400,
            'message' => $message,
        ], 400);
    }



    /**
     * 401  Unauthorized.
     *
     * @return array of json
     */
    public function error401($errors = 'Unauthorized', $message = 'Unauthorized')
    {
        return response()->json([
            'status' => 401,
            'errors' => $errors,
            'message' => $message,
        ], 401);
    }


    /**
     * 403  Forbidden.
     *
     * @return array of json
     */
    public function error403($errors =  'Forbidden')
    {
        return response()->json([
            'errors' =>   $errors,
            'status' => 403,
            'message' => 'Forbidden',
        ], 403);
    }



    /**
     * 404  Not Found.
     *
     * @return array of json
     */
    public function error404()
    {
        return response()->json([
            'status' => 404,
            'message' => 'Not Found',
            'errors' => 'Not Found',
        ], 404);
    }




    /**
     * 422  Unprocessable Content.
     *
     * @return array of json
     */
    public function error422($errors, $message = 'Unprocessable Content')
    {
        return response()->json([
            'message' => $message,
            'status' => 422,
            'errors' => $errors,

        ], 422);
    }



    /**
     * 500  Unprocessable Content.
     *
     * @return array of json
     */
    public function error500($errors = null)
    {
        return response()->json([
            'errors' => $errors,
            'status' => 500,
            'message' => 'Internal Server Error',
        ], 500);
    }


   
}
