<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Mail;
use DB;
use Exception;

abstract class Controller extends BaseController {

	use DispatchesCommands, ValidatesRequests;



    public function sendemail($emil_template='',$mailsubject='',$email_variable='')
    {

//get data record using tempalte name

        $gettemplate=  $this->mailtemplate($emil_template);

//      deploy deta stringobject array
        $all_detail = [] ;
        foreach ($gettemplate[0] as $kay=>$tempalte_detail)
        {
            $all_detail[]=$tempalte_detail;
        }

//        get template description in to variable by channa
                  $description=$all_detail[4];

  //   send $description $description to VariableReplaceArray by channa
       $variable_replace_message= $this->VariableReplaceArray($email_variable,$description);

//     if controller subject is    get subject of email from default template
        if(empty($mailsubject))
            {
               $mailsubject=$all_detail[3];
            }

//get reciver name & email
        $receiver_name=$email_variable['{to_fname}'].' '.$email_variable['{to_lname}'];
        $receiver_email=$email_variable['{to_email}'];
//        echo '<pre>'.print_r($receiver_email,1).'</pre>';
//        die();

        Mail::send('email_tempate.user_template', ['mail_content' => $variable_replace_message], function($sendmail)use ($mailsubject,$receiver_name,$receiver_email)
        {
            $sendmail->to($receiver_email, $receiver_name);
            $sendmail->cc('noreply@gmail.com');
            $sendmail->subject($mailsubject);
        });

          return ;

    }

//    get email template from data table
    public  function mailtemplate($getname)
    {

//        get email template
        $gettemplate = DB::table('emailtemplate')->where('name',$getname)->get();
//trigger exception in a "try" block for email template
        try {
            if(empty($gettemplate))
            {
                //If the exception is thrown, this text will not be shown
                echo 'this title not available in email template table ';
            }

        }
//catch exception
        catch(Exception $e) {
            echo 'Message: ' .$e->getMessage();
        }

        return $gettemplate;

    }


//VariableReplaceArray by channa
    public function VariableReplaceArray($email_variable,$description)
    {
        $getvariableArray=array_keys($email_variable);
        $replacevariableArray=array_values($email_variable);
        $variable_repalsement= str_replace($getvariableArray,$replacevariableArray,$description);
        return $variable_repalsement;

    }





}
