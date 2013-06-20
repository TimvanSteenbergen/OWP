<? 
// include/aanmelden_opslaan.php
// 1. opslaan gegevens uit aanmeldformulier
// 2. activatiemail maken en versturen
// 
include_once 'functions.php';
$param_data                  = mysql_fetch_array(execQuery($link, "SELECT * FROM param     WHERE id = '1' "));
$brin_data                   = mysql_fetch_array(execQuery($link, "SELECT * FROM z_scholen WHERE nr_administratie = '$brin' LIMIT 1"));
$voornaam                    = hoofdletter($voornaam);
$achternaam                  = hoofdletter($achternaam);
$brin_data[naam_plaats_vest] = hoofdletter_caps($brin_data[naam_plaats_vest]);
// random wachtwoord aanmaken
$ww = generatePassword(8);
// activatielink maken
$act_url = $param_data[url].'/mijnomgeving/?a=aanmelden_afronden&id='.$email.'&ww='.$ww;
//
// aanhef
if ($aanhef == 'De heer')
   $mail_aanhef = 'Geachte heer ';
else 
   $mail_aanhef = 'Geachte mevrouw ';
if ($tussennaam != '')
   $mail_aanhef .= $tussennaam.' '.$achternaam.',';
else
   $mail_aanhef .= $achternaam.',';
//
$opslaan = mysql_fetch_array(execQuery($link, "INSERT INTO accounts (`id`, `naam`, `straat`, `nummer`, `pc`, `plaats`, `tel`, `wachtwoord`, `url`, `c_aanhef`, `c_vnaam`, `c_tnaam`, `c_anaam`, `c_email`, `c_tel`, `status`) VALUES ('NULL', '$brin_data[naam_volledig]', '$brin_data[naam_straat_vest]', '$brin_data[nr_huis_vest]', '$brin_data[postcode_vest]', '$brin_data[naam_plaats_vest]', '$brin_data[nr_telefoon]', '$ww', '$brin_data[internet]', '$aanhef', '$voornaam', '$tussennaam', '$achternaam', '$email', '$tel', '1') "));	

//
// mail versturen met activatielink	
$fromName    = $param[naam]; 
$fromAddress = $param[email]; 
include_once 'mail_basis.php';
$message .= $mail_aanhef."<br /><br />";
$message .= "Uw aanmelding op ".$param[naam]." is bijna gereed en binnen enkele ogenblikken kunt u<br />";
$message .= "beginnen met het aanvragen van tevredenheidsonderzoeken. Met onderstaande link activeert<br />";
$message .= "u uw account en kiest u meteen een geschikt wachtwoord.<br /><br />";
$message .= 'Voor het activeren van uw account klikt u <a href='.$act_url.'>hier</a>.<br /><br />';
$message .= "Mocht de link niet werken dan kunt u ook onderstaande url in uw browser plakken: <br /><br />";
$message .= $act_url;
$message .= "<br /><br />";
$message .= "Met vriendelijke groet,<br /><br />";
$message .= "Het team van ".$param_data[naam];
$message .= "</td></tr>\n";
$message .= "</table>\n";
$message .= "</body>\n";
$message .= "</html>\n";
   if ($tussennaam == '')
   $username = $voornaam.' '.$achternaam;
else
   $username = $voornaam.' '.$tussennaam.' '.$achternaam;
$mail     = $email;
$subject  = "Uw aanmelding op ".$param_data[naam];	
mail($username." <".$mail.">",$subject, $message, $headers);
?>