<?php
/**
 * Created by PhpStorm.
 * User: khaled
 * Date: 2/22/16
 * Time: 9:23 AM
 */
include "../redisshared.php";
session_start();

require $_SERVER['DOCUMENT_ROOT']."/../vendor/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

$keys_ini = parse_ini_file($_SERVER['DOCUMENT_ROOT']."/../keys.ini");

$consumer_key = $keys_ini['consumer_key'];
$consumer_secret = $keys_ini['consumer_secret'];
$oauth_callback = "http://www.tweetforbernie.dev/app/index.php";

$connection = new TwitterOAuth($consumer_key, $consumer_secret);

$request_token = $connection->oauth('oauth/request_token', array('oauth_callback'=>$oauth_callback));


$_SESSION['oauth_token'] = $request_token['oauth_token'];
$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

$url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));

echo "<a href='$url'><button type='button'>Login To Twitter</button></a>";

