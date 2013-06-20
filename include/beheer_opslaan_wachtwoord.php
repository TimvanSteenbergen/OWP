<?
session_start();
include("../include/functions.php");
if ($idopslaan) {

	$password_enc = md5($password);
	$result = execQuery($link, "UPDATE accounts SET `wachtwoord` = '$password_enc', `status` = '2' WHERE `id` = $idopslaan LIMIT 1;");
	$fingerprint  = $_SERVER['HTTP_USER_AGENT'];
	$fingerprint .= "qwerty";
	$_SESSION['HTTP_USER_AGENT'] = md5($fingerprint);
	$_SESSION['id'] = $idopslaan;
	$_SESSION['wachtwoord'] = $password;
	//
	// e-mail sturen nieuwe account
	$account = mysql_fetch_array(execQuery($link, "SELECT * FROM accounts WHERE `id` = $idopslaan LIMIT 1"));
	$fromName    = $param[naam]; 
    $fromAddress = $param[email]; 
    include_once 'mail_basis.php';
    $message .= "De onderstaande instelling heeft een account aangemaakt:<br /><br />";
    $message .= "Naam: ".$account[naam]."<br />";
	$message .= "Straat: ".$account[straat]."&nbsp;".$account[nummer]."<br />";
	$message .= "Plaats: ".$account[pc]."&nbsp;&nbsp;".$account[plaats]."<br />";
	$message .= "Tel: ".$account[tel]."<br />";
	$message .= "E-mail: ".$account[email]."<br /><br />";
	$message .= "Contactpersoon: ".$account[c_aanhef]."&nbsp;".$account[vnaam]."&nbsp;".$account[c_tnaam]."&nbsp;".$account[c_anaam]."<br />";
	$message .= "Tel: ".$account[c_tel]."<br />";
	$message .= "E-mail: ".$account[c_email]."<br />";
    $message .= "<br /><br />";
    $message .= "Met vriendelijke groet,<br /><br />";
    $message .= "Het team van ".$param[naam];
    $message .= "</td></tr>\n";
    $message .= "</table>\n";
    $message .= "</body>\n";
    $message .= "</html>\n";
    $username = $param[naam];
    $mail     = $param[email];
    $subject  = "Er is een nieuwe account aangemaakt op ".$param[naam];	
    mail($username." <".$mail.">",$subject, $message, $headers);
	$mail     = 'mbeukenkamp@gmail.com';
	//mail($username." <".$mail.">",$subject, $message, $headers);
	//
} 
?>