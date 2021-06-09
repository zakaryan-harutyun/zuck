<?php

namespace App\Http\Controllers;

use App\Data;

class ApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index()
    {
        return response()->json('work', 200);
    }

    public function getData()
    {
        $data = Data::get();
        return response()->json([
            'data' => $data
        ], 200);
    }

    public function send()
    {
      /*  $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users'
        ]);*/
    }
}
