<?php

require '../src/facebook.php';

$facebook = new Facebook(array(
  'appId'  => '212750475414683',
  'secret' => 'd49aa60fd6f15ad3860ff4fc26b3ee5e',
));

// See if there is a user from a cookie
$user = $facebook->getUser();

$newline = "\n";
$file = "contacts.csv";
$fh = fopen($file, 'w') or die("can't open file");

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
    $friends = $facebook->api('/me/friends');

    foreach ($friends as $key=>$value) {
    	echo count($value) . ' Friends';
	echo '<ul id="friends">';
	foreach ($value as $fkey=>$fvalue) {

	//$text = 'http://parikshit.me/fb/images/'. $fvalue[name].','.$newline;
        $name = explode(" ", $fvalue[name]);
        //$text = $fvalue[name].$newline;
        if($name[1] != ''){
        fwrite($fh, $name[0].','.$name[1].','.$newline);
        }
        else
        fwrite($fh, $name[0].','.newline);
        $imgurl = 'https://graph.facebook.com/' . $fvalue[id].'/picture?type=large';
        $img = './images/'.$fvalue[name].'.jpeg';
        file_put_contents($img, file_get_contents($imgurl));
        }
    echo '</ul>';
    }
  } catch (FacebookApiException $e) {
      echo '<pre>'.htmlspecialchars(print_r($e, true)).'</pre>';
    $user = null;
  }
  
  fclose($fh);
}

?>
<!DOCTYPE html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <body>
    <?php if ($user) { ?>
      Your user profile is
      <pre>
        <?php //print htmlspecialchars(print_r($user_profile, true)) ?>
        <?php //print htmlspecialchars(print_r($friends, true)) ?>
        <?php foreach ($friends as $key=>$value) {
    		echo count($value) . ' Friends';
		echo '<hr />';
		echo '<ul id="friends">';
		foreach ($value as $fkey=>$fvalue) {
			echo '<li><img src="https://graph.facebook.com/' . $fvalue[id] . '/picture" title="' . $fvalue[name] . '"/></li>';
		}
		echo '</ul>';
	      }
	?>
      </pre>
    <?php } else { ?>
      <fb:login-button></fb:login-button>
    <?php } ?>
    <div id="fb-root"></div>
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          appId: '<?php echo $facebook->getAppID() ?>',
          cookie: true,
          xfbml: true,
          oauth: true
        });
        FB.Event.subscribe('auth.login', function(response) {
          window.location.reload();
        });
        FB.Event.subscribe('auth.logout', function(response) {
          window.location.reload();
        });
      };
      (function() {
        var e = document.createElement('script'); e.async = true;
        e.src = document.location.protocol +
          '//connect.facebook.net/en_US/all.js';
        document.getElementById('fb-root').appendChild(e);
      }());
    </script>
  </body>
</html>
