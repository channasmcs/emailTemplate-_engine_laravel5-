# emailTemplate-_engine_laravel5-
[![about me](http://1.bp.blogspot.com/-uCbV5XHcLO4/VAbzG1il9LI/AAAAAAAAAUQ/yMPccsaNa3o/s1600/wonder-logo.png)](http://channasmcs.blogspot.com/)<br/>
[![Build Status](https://travis-ci.org/laravel/framework.svg)](https://travis-ci.org/laravel/framework)
[![Total Downloads](https://poser.pugx.org/laravel/framework/downloads.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/framework/v/stable.svg)](https://packagist.org/packages/laravel/framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/framework/v/unstable.svg)](https://packagist.org/packages/laravel/framework)
[![License](https://poser.pugx.org/laravel/framework/license.svg)](https://packagist.org/packages/laravel/framework)

<br/>
this is the way end mail with Email Template Engine .save templates in database and replace some fields and send mail

frist confige your laravel email config file
mail.php


<pre class="php">
return [

	'driver' => env('MAIL_DRIVER', 'smtp'),
	'host' => env('MAIL_HOST', 'smtp.gmail.com'),
	'port' => env('MAIL_PORT', 587),
	'from' => ['address' => 'youremail@gmail.com', 'name' => 'name'],
	'encryption' => 'tls',
	'username' => env('MAIL_USERNAME'),
	'password' => env('MAIL_PASSWORD'),
	'sendmail' => '/usr/sbin/sendmail -bs',
	'pretend' => false,

];
<pre class="php">



.env file
<pre>
MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=MyUsername@gmail.com
MAIL_PASSWORD=MyPassword
</pre>

create data base & create email tempalte migration php artisan <b>make:migration create_users_table</b>  upload migration file 
<pre class="php">
class CreateEmailtemplateTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('emailtemplate', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->string('variables',255);
            $table->string('subject', 255);
            $table->longText('description');
            $table->timestamp('created_at');
            $table->enum('status', array('1', '0'));
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}

</pre>
OR you can upload sql file which on have in file 
in <i><b>app\Http\Controllers.php</b></i> add fuloowing function to accesss email sendig system throughout of you application

<b>IN CONTROLL.PHP</b>

<pre class="php">
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

</pre>

this is add your controller fuction which you create for send email

<pre class="php">
public function index()
	{

        $emil_template='user registration tempalate'; // template name  which need to send
        $mailsubject=""; //if user template default email subject kaeep this empty
        $message= 'this is the way end mail with Email Template Engine .save templates in database and replace some fields and send mail
        frist confige your laravel email config file mail.php';
//
        $email_variable=array(
            '{to_fname}'=>'channa',// receiver frist name
            '{to_lname}'=>'bandaara',//receiver last name
            '{to_email}'=>'channasmcs@gmail.com', //receiver email
            '{link}'=>'https://www.channasmcs.blogspot.com',// link if you send
            '{message}'=>$message, // message
        );
//        get this on sendemail function
        self::sendemail($emil_template,$mailsubject,$email_variable);


	}
</pre>

<b>$email_variable</b> mean  i define commen variable for repalce sender & reciever detail this method will easy becouse when we create template body like this (see sql file)

<pre class="php">
<p> hello {to_fname} {to_lname} </p>

<p> you have message</p>
<p>{message}</p>

<p>click this link {link}</p>

<p><b>thnank you</b><p>
</pre>

create folder <i>resources\views</i> email_template & create template layout file i make user.php this bring email body 

<pre>
<html>
  <body style="background-color: #d5d5d5;padding: 10px">
    <center>
        <b>HELLO GUYS channa make your work easy please comment</b> <br>
               <a href="http://channasmcs.blogspot.com/">see my blog for more </a>
    </center>
      {!! $mail_content !!}
  </body>
</html>
</pre>

mail ot put 

<pre class="php">
HELLO GUYS channa make your work easy please comment 
see my blog for more


hello channa bandaara

you have message

this is the way end mail with Email Template Engine .save templates in database and replace some fields and send mail frist confige your laravel email config file mail.php

click this link https://www.channasmcs.blogspot.com

thnank you
</pre>


i hope this will help for advance develiopment 

thank you
