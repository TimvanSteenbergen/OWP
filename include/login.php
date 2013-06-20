<?
session_start();
include("../include/functions.php");

// TIJDELIJK SESSIES 
if ($login_a == "ajax") {
	$fingerprint  = $_SERVER['HTTP_USER_AGENT'];
	$fingerprint .= "qwerty";
	$_SESSION['HTTP_USER_AGENT'] = md5($fingerprint);
	$db_id = 6;
	$db_ww = "11111";
	$_SESSION['id'] = $db_id; 
	$_SESSION['wachtwoord'] = $db_ww;
	$row = mysql_fetch_array(execQuery($link, "SELECT * FROM accounts WHERE `id` = '$db_id' AND `wachtwoord` = '$db_ww' LIMIT 1;"));
	if ($row['c_tnaam'] == '') {
	   $_SESSION['gebruiker'] = $row['c_vnaam'].'&nbsp;'.$row['c_anaam'];
	} else {
	   $_SESSION['gebruiker'] = $row['c_vnaam'].'&nbsp;'.$row['c_tnaam'].'&nbsp;'.$row['c_anaam'];
	}
	$_SESSION['naam']       = $row['naam']; 
	$_SESSION['straat']     = $row['straat'];
	$_SESSION['nummer']     = $row['nummer'];
	$_SESSION['toev']       = $row['toev'];
	$_SESSION['pc']         = $row['pc'];
	$_SESSION['plaats']     = $row['plaats'];
	$_SESSION['tel']        = $row['tel'];
	$_SESSION['email']      = $row['email'];
	$_SESSION['kvk']        = $row['kvk'];
	$_SESSION['logo']       = $row['logo'];
	$_SESSION['kleur_1']    = $row['kleur_1'];
	$_SESSION['kleur_2']    = $row['kleur_2'];
	$_SESSION['url']        = $row['url'];
	$_SESSION['c_aanhef']   = $row['c_aanhef'];
	$_SESSION['c_vnaam']    = $row['c_vnaam'];
	$_SESSION['c_tnaam']    = $row['c_tnaam'];
	$_SESSION['c_anaam']    = $row['c_anaam'];
	$_SESSION['c_tel']      = $row['c_tel'];
	$_SESSION['c_email']    = $row['c_email'];
	$_SESSION['status']     = $row['status'];
	print "$login_a uitgevoerd";
	exit();
}

if ($login_a == "show") {
	print "sessie var<br>";
	echo $_SESSION['HTTP_USER_AGENT'];
	print "<br>";
	echo $_SESSION['gebruiker'];
	print "<br>";
	echo	$_SESSION['naam']  ;    	print "<br>";
	echo	$_SESSION['straat'] ;    	print "<br>";
	echo	$_SESSION['nummer']  ;  	print "<br>";
	echo	$_SESSION['toev']     ; 	print "<br>";
	echo	$_SESSION['pc']        ;	print "<br>";
	echo	$_SESSION['plaats']     ;	print "<br>";
	echo	$_SESSION['tel']       ;	print "<br>";
	echo	$_SESSION['email']      ;	print "<br>";
	echo	$_SESSION['kvk']       ;	print "<br>";
	echo	$_SESSION['logo'] ;   	print "<br>";
	echo	$_SESSION['kleur_1'];	print "<br>";
	echo	$_SESSION['kleur_2'];   	print "<br>";
	echo	$_SESSION['url']     ;  	print "<br>";
	echo	$_SESSION['c_aanhef'];  	print "<br>";
	echo	$_SESSION['c_vnaam']  ; 	print "<br>";
	echo	$_SESSION['c_tnaam']   ;	print "<br>";
	echo	$_SESSION['c_anaam']   ;	print "<br>";
	echo	$_SESSION['c_tel']     ;	print "<br>";
	echo	$_SESSION['c_email']   ;	print "<br>";
	echo	$_SESSION['status']    ;	print "<br>";
	print "$login_a uitgevoerd";
	exit();
}

//controle op bestaan sessie en zo ja de juiste
if (!($login_a)) {
	if (isset($_SESSION['HTTP_USER_AGENT'])) {
		$fingerprint  = $_SERVER['HTTP_USER_AGENT'];
		$fingerprint .= "qwerty";
		if ($_SESSION['HTTP_USER_AGENT'] != md5($fingerprint))
		{
			$login_a = "login";
		}
	} else {
		$login_a = "login";
	}

	//login scherm
	if ($login_a == "login") {
		print "Login gedeelte";
		exit;
	}
}

//check voor controle tijdens inloggen
if ($login_a == "check_user") {
	$db_c_email = $_POST['user_name'];
	$db_ww = $_POST['password'];
	$db_ww = md5($db_ww);
	$row = mysql_fetch_array(execQuery($link, "SELECT c_email, wachtwoord FROM accounts WHERE `c_email` = '$db_c_email' LIMIT 1;"));
	//if username exists
	if($row[0])
	{
		//compare the password
		if(strcmp($row['wachtwoord'],$db_ww)==0)
		{
			echo "yes";
			$fingerprint  = $_SERVER['HTTP_USER_AGENT'];
			$fingerprint .= "qwerty";
			$_SESSION['HTTP_USER_AGENT'] = md5($fingerprint);
			$_SESSION['wachtwoord'] = $db_ww;
			$_SESSION['c_email']    = $db_c_email;
			exit();
		}
		else
			echo "no"; 
			exit();	
	}
	else
		echo "no"; //Invalid Login
	exit();
}

//wat te doen na eerste aanmelding en wijzigen wachtwoord
if ($login_b == "na_eerste_aanmelding") {
	$db_id = $_SESSION['id'];
	$db_ww = $_SESSION['wachtwoord'];
	$db_ww = md5($db_ww);
	$row = mysql_fetch_array(execQuery($link, "SELECT * FROM accounts WHERE `id` = '$db_id' AND `wachtwoord` = '$db_ww' LIMIT 1;"));
	$vul_sessie = 1;
}

//als login gedaan is
if ($l == "d") {
	$db_c_email = $_SESSION['c_email'];
	$db_ww = $_SESSION['wachtwoord'];
	$row = mysql_fetch_array(execQuery($link, "SELECT * FROM accounts WHERE `c_email` = '$db_c_email' AND `wachtwoord` = '$db_ww' LIMIT 1;"));
	$vul_sessie = 1;
	unset ($l);
}

//sessie vullen
if ($vul_sessie == 1) {
	if ($row['c_tnaam'] == '') {
	   $_SESSION['gebruiker'] = $row['c_vnaam'].'&nbsp;'.$row['c_anaam'];
	} else {
	   $_SESSION['gebruiker'] = $row['c_vnaam'].'&nbsp;'.$row['c_tnaam'].'&nbsp;'.$row['c_anaam'];
	}
	$_SESSION['id']       = $row['id'];	
	$_SESSION['naam']       = $row['naam'];
	$_SESSION['straat']     = $row['straat'];
	$_SESSION['nummer']     = $row['nummer'];
	$_SESSION['toev']       = $row['toev'];
	$_SESSION['pc']         = $row['pc'];
	$_SESSION['plaats']     = $row['plaats'];
	$_SESSION['tel']        = $row['tel'];
	$_SESSION['email']      = $row['email'];
	$_SESSION['kvk']        = $row['kvk'];
	$_SESSION['logo']       = $row['logo'];
	$_SESSION['kleur_1']    = $row['kleur_1'];
	$_SESSION['kleur_2']    = $row['kleur_2'];
	$_SESSION['url']        = $row['url'];
	$_SESSION['c_aanhef']   = $row['c_aanhef'];
	$_SESSION['c_vnaam']    = $row['c_vnaam'];
	$_SESSION['c_tnaam']    = $row['c_tnaam'];
	$_SESSION['c_anaam']    = $row['c_anaam'];
	$_SESSION['c_tel']      = $row['c_tel'];
	$_SESSION['c_email']    = $row['c_email'];
	$_SESSION['status']     = $row['status'];
}




?>