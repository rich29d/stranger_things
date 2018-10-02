<?php

define('CONSUMER_KEY', 'D4Zk0xug25jVsMS1LMl2grUSw');
define('CONSUMER_SECRET', '6c0Ut0VPjdx0bDrmioilWGhmHnH1LPZTP5nNyHyCCWedRLRzXD');
define('AUTH_REDIR', 'http://strangergif.com/share/twitter-post.php');

if(isset($_GET['image'])) {
    define('UPLOAD_IMAGE', $_GET['image']);
    setcookie('image', $_GET['image'], time() + 60 * 10);
} else {
    define('UPLOAD_IMAGE', '');
}

if(isset($_GET['status'])) {
    define('STATUS', $_GET['status']);
    setcookie('status', $_GET['status'], time() + 60 * 10);
} else {
    define('STATUS', "Stranger Things");
}