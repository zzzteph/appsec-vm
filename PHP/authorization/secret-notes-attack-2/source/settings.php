<?php
session_start();



require 'vendor/autoload.php';
$client = new MongoDB\Client("mongodb://localhost:27017");


if (!file_exists("init")) {


//reinit DB on startup
$client->secrets->users->drop();
$client->secrets->posts->drop();
	



$client->secrets->posts->insertOne(['title' => "We updated DB",	'user_id' => 0,	'created_at' => time(),
			'content' => "We made an update to our service! Now everything is secure!"
		]);

$client->secrets->posts->insertOne(['title' => "Code paste",	'user_id' => 0,	'created_at' => time(),
			'content' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum."
		]);



$client->secrets->posts->insertOne(['title' => "Stay safe",	'user_id' => 0,	'created_at' => time(),
			'content' => "Our service increase it's performance!!1"
		]);


$admin=$client->secrets->users->insertOne(['login' => "admin",	'password' => '30bdad3b2f064123f40da204e6172db6']);

$client->secrets->posts->insertOne(['title' => "Secret Post",	'user_id' => $admin->getInsertedId(),	'created_at' => time(),
			'content' => "My password is <b>4j9X3hxG3w9feSk9</b>"
		]);


file_put_contents("init", "1");


}




?>