<?php
  include_once 'GmailOath.php';
  include_once 'config.php';
  session_start();
  $oauth =new GmailOath($consumer_key, $consumer_secret, $argarray, $debug, $callback);
  $getcontact_access=new GmailGetContacts();
  $request_token=$oauth->rfc3986_decode($_GET['oauth_token']);
  $request_token_secret=$oauth->rfc3986_decode($_SESSION['oauth_token_secret']);
  $oauth_verifier= $oauth->rfc3986_decode($_GET['oauth_verifier']);
  $contact_access = $getcontact_access->get_access_token($oauth,$request_token, $request_token_secret,$oauth_verifier, false, true, true);
  $access_token=$oauth->rfc3986_decode($contact_access['oauth_token']);
  $access_token_secret=$oauth->rfc3986_decode($contact_access['oauth_token_secret']);
  $contacts= $getcontact_access->callcontact($oauth, $access_token, $access_token_secret, false, true);

  $file = "gmailcontact.txt";
  $fh = fopen($file, 'w') or die("Cannot open the file");
  $newline = "\n";

  //Email Contacts
  foreach($contacts as $k => $a)
  {
    /*echo "Key: $k<br />";
    echo "Value: $a<br />";

    foreach($a as $p=>$q)
    {
      echo "Second Level Key: $p<br />";
      echo "Second Level Value: $q<br />";
      foreach ($q as $r=>$s)
      {
        echo "Third Level Key: $r<br />";
        echo "Third Level Value: $s<br />";
        foreach($s as $y=>$z)
        {
          echo "Fourth Level Key: $y<br />";
          echo "Fourth Level Value: $z<br />";
        }
      }
    }*/
    $final = end($contacts[$k]);
    $fullname = end($contacts[$k]["title"]); 
    foreach($final as $email)
    {
      echo $fullname."<br />";
      $name = explode(" ", $fullname);
      echo $email["address"] ."<br />";
      if($name[1]!='')
      fwrite($fh, $name[0].','.$name[1].','.$email["address"].$newline);
      else
      fwrite($fh, $name[0].','.$email["address"].$newline);
    }
  }
  fclose($fh);
?>
