<?
//BEVEILIGING

//als eerste keer aanmelden
if ($a == "aanmelden_afronden") {
	include("../include/functions.php");
	include ("../include/beheer_aanmelden_afronden.php");
	exit();
}

include("../include/login.php");

// hieronder komen we vanuit wijziging wachtwoord en gaan meteen naar beheerfunctie
if ($a == "meteenbeheer") {
   // alle gegevens nieuw aangemeldde gebruiker ophalen
   $row     = mysql_fetch_array(execQuery($link, "SELECT * FROM accounts WHERE id = '$idafronding' LIMIT 1"));
   // vervolgens door alsof link instellingen is geklikt
   $a       = "instellingen";
}


// gewone inlog
if ($ingevulde_passw) {
   $row     = mysql_fetch_array(execQuery($link, "SELECT * FROM accounts WHERE c_email = '$ingevulde_user' AND wachtwoord = '$ingevulde_passw' ")); 
   if (!$row) {
	  $melding = 'Deze gebruiker is onbekend';   
   }
   else {
	  if ($row['status'] == 3)
	     $melding = 'Er bestaat een betalingsachterstand';
	  if ($row['status'] == 4)
	     $melding = 'Deze account is niet meer actief';	     
   }
}

//parameter voor stijl tabblad
$tab_act = "tab_inl";

//Includeer de uiteindelijke style
include ("../beheer_style/style.php");
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td class="menu" width="150px">
<!-- MENU -->


	</td>
	<td class="main"> 
<!-- MAIN -->
<?
$spaties = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
echo 'Welkom in uw eigen omgeving, '.$row['c_vnaam'].' '.$row['c_tnaam'].' '.$row['c_anaam'].'!<br /><br />';
echo 'Via dit menu kunt u de voorbereidingen treffen voor uw eigen onderwijspeiling. Deze<br />voorbereidingen omvatten de volgende stappen:<br /><br />';
echo '<strong>Stap 1. Standaard onderzoeken bekijken via de tab "Onderzoeken".</strong><br />';
echo $spaties.'Hier kunt u de bestaande standaard onderzoeken (ouders, leerkrachten en kinderen) bekijken<br /><br />';
echo '<strong>Stap 2. Eigen vragen definieren via de tab "Eigen vragen".</strong><br />';
echo $spaties.'Hier kunt u desgewenst uw schoolspecifieke vragen specificeren als toevoeging aan de bestaande standaard vragenlijst<br /><br />';
echo '<strong>Stap 3. Mailinglijsten uploaden via de tab "Mailinglijsten".</strong><br />';
echo $spaties.'Hier kunt u de Excel files uploaden met de namen van de deelnemers aan de verschillende onderzoeken.<br />';
echo $spaties.'Een voorbeeld van een Excel bestand kunt u hier bekijken.<br /><br />'; 
echo '<strong>Stap 4. Projecten aanvragen via de tab "Projecten".</strong><br />';
echo $spaties.'Hier geeft u de startdatum van uw onderzoek in en kunt u de standaard teksten bij de uitnodigingen desgewenst wijzigen.<br />';
echo $spaties.'Het team van onderwijspeiling.nl checkt uw project en activeert het project. Hiervan krijgt u bericht. Via de tab "Projecten"<br />';
echo $spaties.'kunt u volgen hoeveel mensen de vragenlijst hebben ingevuld. Standaard is de looptijd van een onderzoek 2 weken waarbij<br />';
echo $spaties.'na 1 week een herinneringsmail wordt uitgestuurd.<br /><br />';
echo '<strong>Stap 5. Rapportages bekijken en downloaden via de tab "Rapportages".</strong><br />';
echo $spaties.'Hier kunt u de resultaten van afgesloten onderzoeken bekijken en downloaden.<br /><br />';
echo '<strong>Stap 6. De resultaten verwerken in het schoolplan.</strong><br />';
echo $spaties.'Met de onderwijspeiling.nl rapportage kunt u eenvoudig de verbeterpunten van uw school opsporen en deze onderbrengen in <br />';
echo $spaties.'uw schoolontwikkelplan. U kunt tevens de redenen onderzoeken waarom nieuwe ouders voor uw school kiezen en uw marketing hierop afstemmen.<br />';
echo $spaties.'Onderwijspeiling.nl kan u van dienst zijn met een workshop waarin de resultaten van de onderzoeken gestructureerd besproken worden.<br /><br />';
echo 'Veel succes !!';

print "</div>\n";
?>

<?
include ("../beheer_style/style_bottom.php");
?>