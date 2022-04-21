<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;

use App\Mail\sendMail;

class PostController extends Controller
{

    public function guardarFormulario(Request $request){
        $email = Post::where(['email'=>$request->email])->first();

        $status = '';
        if(empty($email)){
            Post::create([
            'nombre'=> $request->name,
            'email' => $request->email,
            'telefono' => $request->phone,
            'mensaje' => $request->message
            ]);
            $status = 'GUARDADO';
               
        }
        else{
            $status = 'YA EXISTE';
            // dd('El email ya exite');
        }

        $details = [
            'title' => 'Post title: ' . $request->name,
            'body' => $request->mensaje
        ];
        return response()->json(['status'=>$status,'response'=>200,'detail'=>$details]);
        Mail::to('postmaster@sandbox62defc8c5de74245be39941ac1fc1a54.mailgun.org')->send(new \App\Mail\sendMail($details));
        
    }

    public function nuevoFormulario(){
        return view('formulario');
    }

}
