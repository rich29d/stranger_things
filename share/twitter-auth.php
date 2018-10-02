<?php

require_once('twitteroauth-master/autoload.php');
require_once('twitter-config.php');

use Abraham\TwitterOAuth\TwitterOAuth;

$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);

$requestToken = $connection->oauth('oauth/request_token',  ['oauth_callback' => AUTH_REDIR]);

$oauthToken = $requestToken['oauth_token'];
$oauthTokenSecret = $requestToken['oauth_token_secret'];

setcookie('oauth_token', $oauthToken, time() + 60 * 10);
setcookie('oauth_token_secret', $oauthTokenSecret, time() + 60 * 10);

$url = $connection->url("oauth/authorize", ['oauth_token' => $oauthToken]);

header("Location: " . $url);