<?php
/**
 * Created by PhpStorm.
 * User: khaled
 * Date: 2/22/16
 * Time: 11:17 AM
 *
 * Makes Connection Requests to Twitter and puts responses into the DB as needed.
 *
 * This should be run with messaging to the User that this is a "Sync" process which updates their
 * data.
 *
 */
session_start();
error_reporting(E_ALL);

require $_SERVER['DOCUMENT_ROOT']."/../vendor/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;
$keys_ini = parse_ini_file($_SERVER['DOCUMENT_ROOT']."/../keys.ini");
$consumer_key = $keys_ini['consumer_key'];
$consumer_secret = $keys_ini['consumer_secret'];

if(!isset($_SESSION['access_token'])) {
    $oauth_callback = "http://www.tweetforbernie.dev/app/index.php";

    $request_token = [];
    $request_token['oauth_token'] = $_SESSION['oauth_token'];
    $request_token['oauth_token_secret'] = $_SESSION['oauth_token_secret'];

    if (isset($_REQUEST['oauth_token']) && $request_token['oauth_token'] !== $_REQUEST['oauth_token']) {
        echo "Failure to Properly Authenticate!!! Dying...";
        die();
    }
    $connection = new TwitterOAuth($consumer_key, $consumer_secret, $request_token['oauth_token'], $request_token['oauth_token_secret']);
    $access_token = $connection->oauth("oauth/access_token", ["oauth_verifier" => $_REQUEST['oauth_verifier']]);
    $_SESSION['access_token'] = $access_token;
}

$access_token = $_SESSION['access_token'];
$connection = new TwitterOAuth($consumer_key, $consumer_secret, $access_token['oauth_token'], $access_token['oauth_token_secret']);
$callAct = $_GET['callaction'];
$db = new MysqliDb('localhost', 'a', 'a', 'tweetforbernie');

$userIdentity = $connection->get('account/verify_credentials');
$db->where('tw_user_id', $userIdentity->id);
$captain = $db->getOne ("captains");

if(is_null($captain)) {
    echo "\nGenerating new Record\n";
    $data = Array(
        "tw_user_id" => $userIdentity->id,
        "tw_screen_name" => $userIdentity->screen_name,
        "tw_name" => $userIdentity->name,
        "tw_location" => $userIdentity->location,
        "tw_friend_count" => $userIdentity->friends_count,
        "tw_follower_count" => $userIdentity->followers_count
    );
    $idCaptain = $db->insert ( 'captains',  $data );

    if($idCaptain) {
        echo "Successfully created new Captain with Id: ".$idCaptain;
    } else {
        echo $db->getLastError();
    }
}


function makeCall($callIdentity, $connection, $response = null) {
    $base = $connection->get($callIdentity);
    $responseObj = $base->users;
    foreach($responseObj as $obj) {
        $response[] = array(
            "tw_name"=> $obj->name,
            "tw_screen_name"=>$obj->screen_name,
            "tw_user_id"=>$obj->id,
            "tw_location"=>$obj->location,
            "tw_follower_count"=>$obj->followers_count,
            "tw_friend_count"=>$obj->friends_count,
            "tw_last_active"=>date("Y-m-d H:i:s", strtotime($obj->status->created_at))
        );
    }
    if($base->next_cursor > 0) {
        makeCall($callIdentity."?cursor", $connection, $response);
    }
    return $response;
}

switch($callAct) {
    case "followers" :
        $response = makeCall("followers/list", $connection);

        foreach($response as $follower) {
            $db->where('tw_user_id', $follower['tw_user_id']);
            $citizen = $db->getOne ("citizens");

            if(is_null($citizen)) {
                $idCitizen = $db->insert("citizens", $follower);
                if ($idCitizen) {
                    echo "Successfully created new Citizen with Id: " . $idCitizen;
                } else {
                    echo $db->getLastError();
                }
            }
        }
        break;
    case "friends" :
        $response = $connection->get("friends/list");
        break;
}

echo "Done";