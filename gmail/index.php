<?php session_start(); ?>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>Sync and Merge</title>
    <style type="text/css"><![CDATA[
#form {
  background-color: rgb(204, 255, 255);
  border-top-width: thin;
  border-right-width: thin;
  border-bottom-width: thin;
  border-left-width: thin;
  -webkit-border-radius: 0ch 0ch 0ch 0ch / 0px 0px 0px 0px;
  border-radius: 0ch 0ch 0ch 0ch / 0px 0px 0px 0px;
  border-top-style: double;
  border-right-style: double;
  border-bottom-style: double;
  border-left-style: double;
  float: none;
  visibility: visible;
  display: list-item;
}
#body {
  font-weight: lighter;
  background-color: rgb(255, 255, 204);
}
]]></style></head>



<?php
include_once 'GmailOath.php';
include_once 'config.php';

$oauth =new GmailOath($consumer_key, $consumer_secret, $argarray, $debug, $callback);
$getcontact=new GmailGetContacts();
$access_token=$getcontact->get_request_token($oauth, false, true, true);
$_SESSION['oauth_token']=$access_token['oauth_token'];
$_SESSION['oauth_token_secret']=$access_token['oauth_token_secret'];
?>

<a href="https://www.google.com/accounts/OAuthAuthorizeToken?oauth_token=<?php echo $oauth->rfc3986_decode($access_token['oauth_token']) ?>">
<img src='Googleconnect.png'/>
</a>









  <body id="body">
    <h1> Sync and Merge </h1>
    <br />
    <form name="sync_merge" action="" method="POST" id="form"> <br />
         Gmail Username          <input type="email" name="gmail_username" /><br />
      <br />
         Gmail Password           <input type="password" name="gmail_password"
        checked="true" /><br />
      <br />
         Facebook Username    <input type="email" name="facebook_username" /><br />
      <br />
         Facebook Password     <input type="password" name="facebook_password" /><br />
      <br />
      <br />
             <button name="submit" formmethod="post">Submit</button><br />
      <br />
    </form>
    <br />
  </body>
</html>
