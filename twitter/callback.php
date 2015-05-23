<?php
session_start();
session_regenerate_id(true);
$_SESSION['login']=1;
require_once('twitteroauth/twitteroauth.php');
 
define('CONSUMER_KEY', 'Consumer key�����');
define('CONSUMER_SECRET', 'Consumer secret�����');
 
// getToken.php �ŃZ�b�g���� oauth_token �ƈ�v���邩�`�F�b�N
if ($_SESSION['oauth_token'] !== $_REQUEST['oauth_token']) {
    unset($_SESSION);
    echo '<a href="getToken.php">token�s��v</a>';
    exit;
}

// access token �擾
$tw = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET,
    $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
$access_token = $tw->getAccessToken($_REQUEST['oauth_verifier']);



//�v���t�B�[���ʐ^�擾
$screen_name = $access_token['screen_name'];    //���[�U�[��
$url = "https://twitter.com/".$screen_name;
$html = file_get_contents($url);
if(!empty($html)){
  //data-resolved-url-large�v�f�ɃI���W�i���A�C�R����URL������
  $pattern = '/data\-resolved\-url\-large=".*?"/';
  $searched = preg_match($pattern, $html, $match, PREG_OFFSET_CAPTURE, 0);
  //�}�b�`���������񂩂�s�v�����i�v�f���A�_�u���N�H�[�e�[�V�����j������
  $res = preg_replace("/(data\-resolved\-url\-large=)|\"/","",$match[0][0]);
}else{
  $res = false;
}

// Twitter �� user_id + screen_name(�\����)�Z�b�V�����ɂ���
$_SESSION['username'] = $access_token['screen_name'];
$_SESSION['picture'] = $res;


header("Location: http://�`�`�`");

?>