<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use DB;
use Mail;
use PDF;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
     public function send_mail2($to,$subject,$msg){            
             $data = array(
                 'to' => $to,
                 'subject' => $subject,
                 'msg' => $msg
                 );
              Mail::send('mail.template', ['data'=>$data], function ($message)  use ($data){
                  $subject = $data['subject'];
                  $message->to($data['to'])->subject($subject)->setBody($data['msg'], 'text/html');
              });
                             
               if( count(Mail::failures()) > 0 ) {
                      foreach(Mail::failures as $email_address) {
                                    //echo "$email_address <br />";
                      }
                 }
         }
     //------------------------------- SMS API ----------------------------------------//
     public function sms($message="",$numbers="966532201767") {                        
        $userSender = 'Balsam';        
        $userName="mohammed";
        $userPassword="123456mm";
        
        $msg  = iconv("UTF-8","Windows-1256"  , $message);
        $msg = urlencode($msg);
        $url = "http://sms.rasaelna.com//gw/?userName=$userName&userPassword=$userPassword&numbers=$numbers&userSender=$userSender&msg=$msg&By=API";
        
        file_get_contents($url);        
    }
       
    function toPdf($html) {       
	$pdf = PDF::loadHTML($html);
	return $pdf->stream('document.pdf');
    }

}
