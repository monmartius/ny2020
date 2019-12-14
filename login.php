<?php

define('BR', "<br>");

function deb($obj){
    echo BR . '<pre>' . print_r($obj, true) . '</pre>' . BR;
}

function __header($url){

	$dirname = dirname($_SERVER['PHP_SELF']);
	// $dirname = str_replace(dirname($_SERVER['PHP_SELF']), "/", "\\" );
	
	if($dirname != ""){
	
		if ($dirname[strlen($dirname) - 1] == '\\') {
			
			$dirname = substr($dirname, 0, -1);
		}
	}
	
	if($dirname != ""){
		if ($dirname[strlen($dirname) - 1] == '/') {
			
			$dirname = substr($dirname, 0, -1);
		}
	}

    $url = "Location: http://" . $_SERVER['HTTP_HOST'] . $dirname . "/" . $url;



    return($url);
}






if( !empty($_REQUEST['paswd']) ){

	$pass = "123654";

	if( $_REQUEST['paswd'] == $pass ){


		session_start();

		$_SESSION['access'] = true;

		// header("Location: moderator.php");


		// deb (print_r($_REQUEST, true));
		// deb (print_r($_SESSION, true));
		// deb (print_r($_SERVER, true));
		// deb ( str_replace(dirname($_SERVER['PHP_SELF']), "/", "\\" ));

		// die(print_r($_SESSION, true));
		// die(__header("moderator.php"));

		header(__header("moderator.php"));
	}
	else {

		// header("Location: login.php") ;

		header(__header("login.php"));

	}
}
else
{
	?>
	<form method="POST" action="login.php">

		Введите пароль: <input type="text" name="paswd">

		<input type="submit" value="Отправить">

	</form>

	<?php

}

?>



