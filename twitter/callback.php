<?php
session_start();
session_regenerate_id(true);
$_SESSION['login']=1;
require_once('twitteroauth/twitteroauth.php');
 
define('CONSUMER_KEY', 'Consumer keyを入力');
define('CONSUMER_SECRET', 'Consumer secretを入力');
 
// getToken.php でセットした oauth_token と一致するかチェック
if ($_SESSION['oauth_token'] !== $_REQUEST['oauth_token']) {
    unset($_SESSION);
    echo '<a href="getToken.php">token不一致</a>';
    exit;
}

// access token 取得
$tw = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET,
    $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
$access_token = $tw->getAccessToken($_REQUEST['oauth_verifier']);



//プロフィール写真取得
$screen_name = $access_token['screen_name'];    //ユーザー名
$url = "https://twitter.com/".$screen_name;
$html = file_get_contents($url);
if(!empty($html)){
  //data-resolved-url-large要素にオリジナルアイコンのURLがある
  $pattern = '/data\-resolved\-url\-large=".*?"/';
  $searched = preg_match($pattern, $html, $match, PREG_OFFSET_CAPTURE, 0);
  //マッチした文字列から不要部分（要素名、ダブルクォーテーション）を除く
  $res = preg_replace("/(data\-resolved\-url\-large=)|\"/","",$match[0][0]);
}else{
  $res = false;
}

// Twitter の user_id + screen_name(表示名)セッションにする
$_SESSION['username'] = $access_token['screen_name'];
$_SESSION['picture'] = $res;


header("Location: http://～～～");

?>