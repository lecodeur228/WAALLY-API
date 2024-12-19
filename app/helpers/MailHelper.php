<?php

namespace App\Helpers;

use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;

class MailHelper
{
    public static function sendMailWithAttachment($otp) 
    { 
        // Laravel 8
         // $data[ "email" ] = "test@gmail.com" ; 
        // $data[ "title" ] = "Techsolutionstuff" ; 
        // $data[ "body" ] = "Ceci est un mail de test avec pièce jointe" ; 
 
        // $files = [ 
        //      public_path( 'attachments/test_image.jpeg' ), 
        //      public_path( 'attachments/test_pdf.pdf' ), 
        // ]; 
  
        // Mail:: send ( 'mail.test_mail' , $data, function($message) use ($data, $files) { 
        //      $message->to($data[ "email" ]) 
        // ->subject($data[ "title" ]); 
 
        //      foreach ($files as $file){ 
        //          $message->attach($file); 
        //      }             
        // }); 
        $mailData = [ 
            'title' => 'SCHOOLVI' ,
            'body' => 'Votre code de confirmation est '.$otp ,
        ]; 
           
        Mail::to( 'to@gmail.com' )-> send (new SendMail($mailData)); 
             
        echo "Mail envoyé avec succès !!" ; 
    } 
}