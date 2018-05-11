    
<?php 
//https://www.youtube.com/watch?v=lAqOZ3nXG7o
require ("vendor/autoload.php");
//Step 1: Enter you google account credentials
$g_client = new Google_Client();
$g_client->setClientId("363466732670-a9corv5ekjp1mq8n8r7bvdf33kp5optq.apps.googleusercontent.com");
$g_client->setClientSecret("xxotFAS4b6Jbh_A6_8Q14YtO");
$g_client->setRedirectUri("http://localhost/demo/google/sign-in/index.php");
$g_client->setScopes("email");

//Step 2 : Create the url
$auth_url = $g_client->createAuthUrl();
echo "<a href='$auth_url'>Login Through Google </a>";

//Step 3 : Get the authorization  code
$code = isset($_GET['code']) ? $_GET['code'] : NULL;

//Step 4: Get access token
if(isset($code)) {
    try {
        $token = $g_client->fetchAccessTokenWithAuthCode($code);
        $g_client->setAccessToken($token);
    }catch (Exception $e){
        echo $e->getMessage();
    }

    try {
        $pay_load = $g_client->verifyIdToken();        
    }catch (Exception $e) {
        echo $e->getMessage();
    }
} else{
    $pay_load = null;
}

if(isset($pay_load)){
    $uname =  $pay_load['email'];
    ?>
    <img src="https://pikmail.herokuapp.com/<?=$uname?>?size=50" alt="Profile Picture">
    <?php
}