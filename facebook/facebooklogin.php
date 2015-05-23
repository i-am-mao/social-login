<?php
header("Content-Type: text/html; charset=Shift_JIS");
ob_start();
?>
<?php
//facebool.phpを読み込む
require_once('src/facebook.php');

//Facebookアプリ情報
$config = array(
	'appId' => 'facebook App ID入力部分',
	'secret' => 'facebook App Secret入力部分',
);
$facebook = new Facebook($config);
$user_id = $facebook->getUser();

if($user_id) {
	//ユーザーIDが空っぽじゃない場合
	try {
		//ユーザー情報を取得
		$user_profile = $facebook->api('/me','GET');
		
		//セッション開始
		session_start();
		session_regenerate_id(true);
		$_SESSION['login']=1;
		$_SESSION['username']=$user_profile['username'];
		$_SESSION['picture'] = "https://graph.facebook.com/". $user_profile['id'] ."/picture";

	//会員ページにリダイレクト
    header("Location: リダイレクト先のURL");

		
	} catch(FacebookApiException $e) {
		//エラー時の処理
		$login_url = $facebook->getLoginUrl(); 
		echo '<a href="' . $login_url . '">facebookログイン</a>';
		//エラーログ出力
		error_log($e->getType());
		error_log($e->getMessage());
	}
} else {
	//ユーザーIDが取得できない場合＆非会員時に表示される
	$login_url = $facebook->getLoginUrl();
	echo '<a href="' . $login_url . '">facebookログイン</a>';
}
?>
<?php
$out = ob_get_clean();
$out = mb_convert_kana($out, "rak", "UTF-8");
$out = mb_convert_encoding($out, "SJIS", "UTF-8");
echo $out;
?>