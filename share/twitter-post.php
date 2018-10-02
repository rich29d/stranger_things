<?php

if(isset($_GET['denied']))
    header('Location: ../');

require_once('twitteroauth-master/autoload.php');
require_once('twitter-config.php');

use Abraham\TwitterOAuth\TwitterOAuth;

$oauthVerifier = $_REQUEST['oauth_verifier'];
$oauthToken = $_COOKIE['oauth_token'];
$oauthTokenSecret = $_COOKIE['oauth_token_secret'];

$connection = new TwitterOAuth(CONSUMER_KEY, 
                                CONSUMER_SECRET,
                                $oauthToken,
                                $oauthTokenSecret);

$retAccessToken = $connection->oauth('oauth/access_token', 
                                    ['oauth_verifier' => $oauthVerifier]);

$accessToken = $retAccessToken['oauth_token'];
$accessTokenSecret = $retAccessToken['oauth_token_secret'];

$connection = new TwitterOAuth(CONSUMER_KEY,
                                CONSUMER_SECRET,
                                $accessToken,
                                $accessTokenSecret);

$connection->setTimeouts(30, 30);

$mediaURL = (isset($_COOKIE['image']) ? $_COOKIE['image'] : UPLOAD_IMAGE);

$media = $connection->upload('media/upload', ['media' => $mediaURL]);

$params = [
    'status' => (isset($_COOKIE['status']) ? $_COOKIE['status'] : STATUS),
    'media_ids' => $media->media_id_string
];

$result = $connection->post('statuses/update', $params);

setcookie('image', null, time() - 3600);
setcookie('status', null, time() - 3600);
setcookie('oauth_token', null, time() - 3600);
setcookie('oauth_token_secret', null, time() - 3600);

if($connection->getLastHttpCode() == 200) {
    header('Location: https://twitter.com/');
} else {
    header('Location: ../?status=error&code=' . $connection->getLastHttpCode());
}