<?php namespace App\Http\Controllers;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
//	public function __construct()
//	{
//		$this->middleware('auth');
//	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{

        $emil_template='user registration tempalate'; // template name  which need to send
        $mailsubject=""; //if user template default email subject kaeep this empty
        $message= 'this is the way end mail with Email Template Engine .save templates in database and replace some fields and send mail
        frist confige your laravel email config file mail.php';

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

}
