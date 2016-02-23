<?php
/**
 * Created by PhpStorm.
 * User: khaled
 * Date: 2/20/16
 * Time: 7:25 PM
*/
require_once($_SERVER['DOCUMENT_ROOT'].'/../vendor/j7mbo/twitter-api-php/TwitterAPIExchange.php');
$keys_ini = parse_ini_file($_SERVER['DOCUMENT_ROOT']."/../keys.ini");

$screenName = (isset($_GET['user']) ? $_GET['user'] : 'kalquaddoomi');

$settings = array(
    'oauth_access_token' => $keys_ini['oauth_access_token'],
    'oauth_access_token_secret' => $keys_ini['oauth_access_token_secret'],
    'consumer_key' => $keys_ini['consumer_key'],
    'consumer_secret' => $keys_ini['consumer_secret']
);

$url = 'https://api.twitter.com/1.1/followers/list.json';
$getfield = '?screen_name='.$screenName;
$requestMethod = 'GET';

$twitter = new TwitterAPIExchange($settings);
$friendsJSON = $twitter->setGetfield($getfield)
    ->buildOauth($url, $requestMethod)
    ->performRequest();
$friendsData = json_decode($friendsJSON);
if(count($friendsData) == 0) {
    echo "No Followers FOUND <br />";
}

$friendsNextCursor = $friendsData->next_cursor;

$friendsDataArray = $friendsData->users;
echo "<p>Followers Count : ".count($friendsDataArray)."</p>";
echo "<p>Next Cursor :".$friendsNextCursor."</p>";
foreach($friendsDataArray as $fData) {
    echo "<ul>";
    echo "<li>User: (" . $fData->id . ") " . $fData->screen_name . "</li>";
    echo "<li>Name: " . $fData->name . "</li>";
    echo "<li>Location: " . $fData->location . "</li>";
    echo "<li>Followers: " . $fData->followers_count."</li>";
    echo "<li>Friends: " . $fData->friends_count."</li>";
    echo "</ul>";
}

?>