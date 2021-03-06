<?php
session_start();
require_once('twitteroauth/twitteroauth.php');
 
// api 登録して取得した文字列を入れます
define('CONSUMER_KEY', 'Consumer keyを入力');
define('CONSUMER_SECRET', 'Consumer secretを入力');
define('CALLBACK_URL', 'Callback URLを入力'); 
 
// request token取得
$tw = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
 
$token = $tw->getRequestToken(CALLBACK_URL);
if(! isset($token['oauth_token'])){
    echo "error: getRequestToken\n";
    exit;
}
 
// callback.php で使うのでsessionに入れておく
$_SESSION['oauth_token']        = $token['oauth_token'];
$_SESSION['oauth_token_secret'] = $token['oauth_token_secret'];
 
// 認証用URL取得してredirect
$authURL = $tw->getAuthorizeURL($_SESSION['oauth_token']);
header("Location: " . $authURL);
?>