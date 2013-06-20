<? 
// include/wachtwoord_wijzigen.php
// 1. genereren van een nieuw wachtwoord en opslaan
// 2. wachtwoordmail maken en versturen
// 
include_once 'functions.php';
$param_data                  = mysql_fetch_array(execQuery($link, "SELECT * FROM param     WHERE id = '1' "));
$brin_data                   = mysql_fetch_array(execQuery($link, "SELECT * FROM z_scholen WHERE nr_administratie = '$brin' LIMIT 1"));
$voornaam                    = hoofdletter($voornaam);
$achternaam                  = hoofdletter($achternaam);
$brin_data[naam_plaats_vest] = hoofdletter_caps($brin_data[naam_plaats_vest]);
// random wachtwoord aanmaken
$ww = generatePassword(8);
// link maken voor het opnieuw wijzigen van het gewijzigde wachtwoord
$act_url = $param_data[url].'/mijnomgeving/?a=wachtwoord_wijzigen&id='.$email.'&ww='.$ww;
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
$opslaan = mysql_fetch_array(execQuery($link, "UPDATE accounts SET (`wachtwoord`) VALUES ('$ww') "));	

//
// mail versturen met het gewijzigde wachtwoord
$fromName    = $param[naam]; 
$fromAddress = $param[email]; 
include_once 'mail_basis.php';
$message .= $mail_aanhef."<br /><br />";
$message .= "Uw wachtwoord is gewijzigd naar een nieuw wachtwoord. Met onderstaande link activeert<br />";
$message .= "kunt u dat nieuwe wachtwoord meteen wijzigen naar een voor u een geschikt wachtwoord.<br /><br />";
$message .= '<a href='.$act_url.'>Wijzig mijn nieuwe wachtwoord</a>.<br /><br />';
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