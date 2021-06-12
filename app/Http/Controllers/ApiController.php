<?php

namespace App\Http\Controllers;



use App\Brief;
use http\Env\Request;
use Illuminate\Support\Facades\App;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Mail;

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

    public function welcome()
    {
        return response()->json('Zuck&Berg API v1', 200);
    }

    public function index()
    {
        return response()->json('Zuck&Berg API v1', 200);
    }


    public function store(Request $request)
    {
        $validator = $this->validate($request, [
        /*    'name' => 'required',
            'email' => 'required|email|unique:users'*/
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false],'500');
        }

        $data = serialize($request->data);

        $brief = Brief::create([
            'data' => $data
        ]);

        $pdf_data = ['a','b','c','d','e','f'];
        $pdf = PDF::loadView('pdf',['data' => $pdf_data]);
        $output = $pdf->output();
        $pdf_path = 'pdf/'.time().'.pdf';
        $brief->pdf = $pdf_path;
        $brief->save();
        file_put_contents($pdf_path, $output);

        $email_data = array('name'=>'Arunumar');
        Mail::send('mail', $email_data, function($message) use ($pdf_path){
            $message->to('easyselva@gmail.com', 'Arunkumar')->subject('Test Mail from Selva');
            $message->from('selva@snamservices.com','Selvakumar');
            $message->attach($pdf_path);
        });

        return response()->json(['status' => true],'200');
    }

    public function pdf(){

        $data = ['a','b','c','d','e','f'];
        $pdf = PDF::loadView('PDF',['data' => $data]);

    //  return $pdf->download('invoice.pdf');

    /*
        SAVE PDF
        $output = $pdf->output();
        file_put_contents('pdf/Brochure.pdf', $output);
    */

        return $pdf->stream();
    }

    public function mail(){
        $data = array('name'=>'Arunumar');
        Mail::send('mail', $data, function($message) {
        $message->to('easyselva@gmail.com', 'Arunkumar')->subject('Test Mail from Selva');
        $message->from('selva@snamservices.com','Selvakumar');
        });
    }

}
