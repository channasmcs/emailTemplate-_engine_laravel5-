# emailTemplate-_engine_laravel5-
this is the way end mail with Email Template Engine .save templates in database and replace some fields and send mail

frist confige your laravel email config file
mail.php
<?php
return [
'driver' => env('MAIL_DRIVER',' smtp'),
'host' => env('MAIL_HOST', 'smtp.gmail.com'),
'port' => env('MAIL_PORT', 587),
'from' => ['address' =>"MyUsername@gmail.com" , 'name' => "example"],
'encryption' => 'tls',
'username' => env('MyUsername@gmail.com'),
'password' => env('MyPassword'),
'sendmail' => '/usr/sbin/sendmail -bs',
'pretend' => false,
];
?>



.env

MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=MyUsername@gmail.com
MAIL_PASSWORD=MyPassword

