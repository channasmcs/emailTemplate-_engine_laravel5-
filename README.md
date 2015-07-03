# emailTemplate-_engine_laravel5-
this is the way end mail with Email Template Engine .save templates in database and replace some fields and send mail

frist confige your laravel email config file
mail.php


<pre>
<?php
'driver' => env('MAIL_DRIVER',' smtp'),
'host' => env('MAIL_HOST', 'smtp.gmail.com'),
'port' => env('MAIL_PORT', 587),
'from' => ['address' =>"MyUsername@gmail.com" , 'name' => "example"],
'encryption' => 'tls',
'username' => env('MyUsername@gmail.com'),
'password' => env('MyPassword'),
'sendmail' => '/usr/sbin/sendmail -bs',
'pretend' => false,
?>
</pre>



.env file
<pre>
MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=MyUsername@gmail.com
MAIL_PASSWORD=MyPassword
</pre>

create data base & create email tempalte migration php artisan <b>make:migration create_users_table</b>  upload migration file 
<pre>
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


