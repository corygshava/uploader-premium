<?php
	// session verification for new sessions

	$text = "working on it";
	$suffix = "danger";

	if(isset($_GET['mykey'])){
		$thekey = $_GET['mykey'];
		$text = "key present";

		if($thekey == "" | $thekey == null){
			$text = "no key passed";
		} else {
			$text = "comparing key : $thekey";
			$suffix = "warning";
			$realkey = file_get_contents('dslkfhhgdrgkshreguerhiguh_sitekey.txt');

			// check if the key matches the site password
			if($thekey != $realkey){
				$text = "invalid key entered";
			} else {
				$text = "valid key entered, reloading";
				$suffix = "success";

				// create a cookie valid for 3 hours active only on this subdomain
				setcookie("accesstoken", 'accessAvailable', time() + (1000 * 60 * 240));
			}
		}
	} else {
		$text = "invalid request";
	}

	echo "$text|$suffix";
?>