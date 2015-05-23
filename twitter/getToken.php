<?php
session_start();
require_once('twitteroauth/twitteroauth.php');
 
// api “o˜^‚µ‚ÄŽæ“¾‚µ‚½•¶Žš—ñ‚ð“ü‚ê‚Ü‚·
define('CONSUMER_KEY', 'Consumer key‚ð“ü—Í');
define('CONSUMER_SECRET', 'Consumer secret‚ð“ü—Í');
define('CALLBACK_URL', 'Callback URL‚ð“ü—Í'); 
 
// request tokenŽæ“¾
$tw = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
 
$token = $tw->getRequestToken(CALLBACK_URL);
if(! isset($token['oauth_token'])){
    echo "error: getRequestToken\n";
    exit;
}
 
// callback.php ‚ÅŽg‚¤‚Ì‚Åsession‚É“ü‚ê‚Ä‚¨‚­
$_SESSION['oauth_token']        = $token['oauth_token'];
$_SESSION['oauth_token_secret'] = $token['oauth_token_secret'];
 
// ”FØ—pURLŽæ“¾‚µ‚Äredirect
$authURL = $tw->getAuthorizeURL($_SESSION['oauth_token']);
header("Location: " . $authURL);
?>