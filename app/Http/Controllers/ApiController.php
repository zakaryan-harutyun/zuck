<?php

namespace App\Http\Controllers;



use App\Brief;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

        ini_set('max_execution_time', 300);

      try{

          /*  $validator = $this->validate($request, [
            '__type__' => 'required',
            'email' => 'required|email|unique:users'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false],'500');
        }*/

          $data = $request->all();

          $type = $data['__type__'];
          $email = $data['E-mail *']['value'];
          $files = $data['Additional Information']['value']['files'];

          $check_unique = Brief::where('email',$email)->where('brief_name', $type)->first();

          if($check_unique){
              return response()->json(['result' => false, 'message' => 'This email with brief type already used in the system']);
          }

          $db_files = [];
          $db_data = [];

          $brief = New Brief();
          $brief->brief_name = $type;
          $brief->email = $email;


          if(count($files) > 0){
              foreach ($files as $file){
                  $image_64 = $file; //your base64 encoded data

                  $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];
                  $replace = substr($image_64, 0, strpos($image_64, ',')+1);
                  $image = str_replace($replace, '', $image_64);
                  $image = str_replace(' ', '+', $image);
                  $imageName = Str::random(10).'.'.$extension;
                  file_put_contents('files/'.$imageName, base64_decode($image));
                  array_push($db_files, $imageName);
              }
              $brief->files = serialize($db_files);
          }


          foreach ($data as $key => $item){
              if(isset($data[$key]['value']) && $data[$key]['name'] != "Additional Information"){
                  $name = $data[$key]['name'];
                  $value = '';
                  if(gettype($data[$key]['value']) == "array"){
                      foreach ($data[$key]['value'] as $key => $val){
                          $value .= ', '. $key;
                      }
                  }else{
                      $value = $data[$key]['value'];
                  }

                  array_push($db_data, ['key' => $name, 'value' => $value]);
              }
          }
          $brief->data = serialize($db_data);


          $pdf = PDF::loadView('pdf',['data' => $db_data]);

          $output = $pdf->stream();
          $pdf_path = 'pdf/'.time().'.pdf';
          $brief->pdf = $pdf_path;
          $brief->save();
          file_put_contents($pdf_path, $output);

          $email_data = [];
          Mail::send('mail', $email_data, function($message) use ($pdf_path, $email,$type){
              $message->to($email)->subject($type);
              $message->from('zuckagency@gmail.com');
              $message->attach($pdf_path);
          });
      }catch (\Exception $exception){
          // dd($exception->getMessage());
          return response()->json(['result' => false, 'message' => $exception->getMessage()],'500');
      }

        return response()->json(['result' => true],'200');
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


}
