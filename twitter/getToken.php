<?php
session_start();
require_once('twitteroauth/twitteroauth.php');
 
// api �o�^���Ď擾��������������܂�
define('CONSUMER_KEY', 'Consumer key�����');
define('CONSUMER_SECRET', 'Consumer secret�����');
define('CALLBACK_URL', 'Callback URL�����'); 
 
// request token�擾
$tw = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
 
$token = $tw->getRequestToken(CALLBACK_URL);
if(! isset($token['oauth_token'])){
    echo "error: getRequestToken\n";
    exit;
}
 
// callback.php �Ŏg���̂�session�ɓ���Ă���
$_SESSION['oauth_token']        = $token['oauth_token'];
$_SESSION['oauth_token_secret'] = $token['oauth_token_secret'];
 
// �F�ؗpURL�擾����redirect
$authURL = $tw->getAuthorizeURL($_SESSION['oauth_token']);
header("Location: " . $authURL);
?>