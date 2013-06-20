<? 
session_start();
// include/project_opslaan.php
// 1. opslaan gegevens uit project formulier
// 
include ("functions.php");
$param_data                  = mysql_fetch_array(execQuery($link, "SELECT * FROM param WHERE id = '1' "));
$db_id = $_SESSION['id'];

$startdatum = convert_date_to_us($startdatum);

$einddatum_dagen = $param_data[einddatum_dagen];
$einddatum_dagen = "+" . $einddatum_dagen . " days";
$einddatum  = date('Y-m-d', strtotime($einddatum_dagen, strtotime($startdatum)));
$herinnering_dagen = $param_data[herinnering_dagen];
$herinnering_dagen = "+" . $herinnering_dagen . " days";
$herinnering = date('Y-m-d', strtotime($herinnering_dagen, strtotime($startdatum)));

if ($pers_vr) { //persoonlijke vragen opslaan
	foreach($pers_vr as $pers_vr_id)
		{
			$pers_vr_data = mysql_fetch_array(execQuery($link, "SELECT * FROM vragen_persoonlijk WHERE id = $pers_vr_id LIMIT 1"));
			$pers_vr_soort_array[] .= $pers_vr_data[soort];
			$pers_vr_vragen_array[] .= $pers_vr_data[vraag];
		}
	$pers_vr_soort_array = serialize($pers_vr_soort_array);
	$pers_vr_vragen_array = serialize($pers_vr_vragen_array);
	$pers_vr[0] = $pers_vr_soort_array;
	$pers_vr[1] = $pers_vr_vragen_array;
	$pers_vr = serialize($pers_vr);
}

$opslaan = mysql_fetch_array(execQuery($link, "INSERT INTO `projecten` (`id`, `account_id`, `template_id`, `adressenlijst_id`, `naam`, `status`, `dd_start`, `dd_eind`, `dd_herin`, `pers_vr`, `tekst_mail`, `tekst_kop`, `tekst_dank`) VALUES ('NULL', '$db_id', '$template', '$adressenlijst', '$naam_project', '1', '$startdatum', '$einddatum', '$herinnering', '$pers_vr', '$tekst_mail', '$tekst_kop', '$tekst_dank')"));	
// 
// welk id is aangemaakt?
$project_id = mysql_insert_id();
// url om project direct te accorderen
$url = 'http://www.onderwijspeiling.nl/projecten/actief_maken.php?db_id='.$project_id;
//
// versturen mail naar info-adres
if ($tussennaam == '')
   $username = $_SESSION['c_vnaam'].' '.$_SESSION['c_anaam'];
else
   $username = $_SESSION['c_vnaam'].' '.$_SESSION['c_tnaam'].' '.$_SESSION['c_anaam'];
$fromName    = $username; 
$fromAddress = $_SESSION['c_email']; 
include_once 'mail_basis.php';
$message .= "Er is een nieuw project ingevoerd<br /><br />";
$message .= "School: ".$_SESSION['naam']."<br />";
$message .= "Naam: ".$naam_project."<br />";
$message .= "Startdatum: ".$startdatum."<br />";
$message .= "Einddatum: ".$einddatum."<br />";
$message .= "Herinnering: ".$herinnering."<br />";
$message .= "Project goedkeuren: <a href=\"$url\">".$url."</a><br />";
$message .= "<br /><br />";
$message .= "Met vriendelijke groet,<br /><br />";
$message .= "Het team van ".$param_data[naam];
$message .= "</td></tr>\n";
$message .= "</table>\n";
$message .= "</body>\n";
$message .= "</html>\n";

print $message;
//
//$mail     = 'mbeukenkamp@gmail.com';
$subject  = "Nieuwe projectaanvraag van ".$_SESSION['naam'];	
//mail($username." <".$mail.">",$subject, $message, $headers);
$mail     = 'info@onderwijspeiling.nl';
mail($username." <".$mail.">",$subject, $message, $headers);
?>