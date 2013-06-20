<?
//BEVEILIGING
include("../include/login.php");

//parameter voor stijl
$tab_act = "tab_proj";
if (!($a)) { $a = "o"; }

if ($a == "o") { //overzicht
	$menu_item_act = "proj_overzicht"; 
	$titel_main = "Overzicht";
}
if ($a == "a") { //aanvragen
	$menu_item_act = "proj_aanvragen"; 
	$titel_main = "Aanvragen";
}
if ($a == "w") { //wijzigen
	$menu_item_act = "proj_wijzigen"; 
	$titel_main = "Wijzigen";
}

//Includeer de uiteindelijke style
include ("../beheer_style/style.php");
?>

<link type="text/css" href="../css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />	
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
 
    <script type="text/javascript" src="../js/jquery.form.js"></script>
    <script type="text/javascript" src="../js/jquery.validate.js"></script>
    <script type="text/javascript" src="../js/bbq.js"></script>
    <script type="text/javascript" src="../js/jquery.form.wizard.js"></script>

<script type="text/javascript">
$(function(){

		$("#form").formwizard({ 
			formPluginEnabled: true,
			historyEnabled : true,
			validationEnabled: true,
			formOptions :{
				success: function(data){$("#status").html("<b><i>Uw aanvraag is verzonden! Op de pagina overzicht kunt u de status bekijken!</b></i>")},
				beforeSubmit: function(data){$("#main_inhoud").css({"visibility": "hidden"}),$("#status").html("<b><i>Uw aanvraag is verzonden! Op de pagina overzicht kunt u de status bekijken!</b></i>").fadeTo(1500,100)},
				dataType: 'json',	
				resetForm: true
			}					
		 }
		);

		$( "#startdatum" ).datepicker({ 
			dateFormat: 'dd-mm-yy',
			minDate: -0,
			onSelect: function(_date) {
				$("#startdatum_error").html("");
				$("#startdatum").css("border", "1px solid #abadb3");
				$("#herinnering_txt").html("Herinnering");
				$("#einddatum_txt").html("Einddatum");
				var myDate = $(this).datepicker('getDate'); // Retrieve selected date
				myDate.setDate(myDate.getDate() +  <? print $param[herinnering_dagen]; ?>); // Add herinnering days
				$('#herinnering').text($.datepicker.formatDate('dd-mm-yy', myDate)); // Reformat            
				var myDate2 = $(this).datepicker('getDate'); // Retrieve selected date
				myDate2.setDate(myDate2.getDate() +  <? print $param[einddatum_dagen]; ?>); // Add einddatum days
				$('#einddatum').text($.datepicker.formatDate('dd-mm-yy', myDate2)); // Reformat
			}
		});


				// function for appending step visualization
				function tekst_ophalen(id){
					if (id == "tab_2") {
						 $.post("../include/template_data.php", { template:$('#template').val() }, function(data) {
							 $("#tekst_mail").html(data.mail);
							 $("#tekst_kop").html(data.kop);
							 $("#tekst_dank").html(data.dank);
						 }, "json");
					}
				}

				$("#form").bind("step_shown", function(event, data){
					$.each(data.activatedSteps, function(){
						tekst_ophalen(this)
					});

					
				})


	});
</script>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td class="menu" width="150px">
<!-- MENU -->
		<a class="menu_item" id="proj_overzicht" href="?a=o">Overzicht</a>
		<a class="menu_item" id="proj_aanvragen" href="?a=a">Aanvragen</a>

	</td>
	<td class="main"> 
<!-- MAIN -->
<?
//Aanvragen
if ($a == "a") { 
?>
<B>Het aanvragen van een nieuw project</B><br><br>
Via dit programma voert u de gegevens van een nieuw te starten onderzoek in en kunt u de<br />
boodschappen die aan de deelnemers gestuurd worden desgewenst aanpassen.<br /><br />
Alvorens een onderzoek op te starten dient u de volgende stappen doorlopen te hebben: <br />
<ul>
<li>Onder het tabje "Eigen vragen" heeft u schoolspecifieke vragen ingevoerd.</li>
<li>Onder het tabje "Mailinglijsten" heeft u de bestanden met namen en e-mailadressen opgeladen.</li>
</ul>
Na het invoeren van de projectgegevens wordt de aanvraag verzonden naar onderwijspeiling.nl. <br />Het team van onderwijspeiling.nl
controleert uw aanvraag. Indien alles akkoord is wordt het project gestart op <br />de gewenste startdatum. U krijgt bericht zodra uw aanvraag is goedgekeurd. 
Indien er vragen of opmerkingen zijn over de aanvraag neemt een adviseur<br /> van onderwijspeiling.nl telefonisch contact met u op.<br><br>
<div id="step_visualization"></div>
<div id="status"></div>
		<div id="main_inhoud">
			<form id="form" method="post" action="../include/project_opslaan.php" class="bbq">
				<div id="fieldWrapper">

<span class="step" id="tab_1">
<div class="labels">Naam van het onderzoek</div>
	<input class="required" type="text" name="naam_project" id="naam_project" size="40">
<div class="tussenregel"></div>

<div class="labels">Vragenlijst</div>
	<select class="required" name="template" id="template">
	<option value=""></option>
<div class="tussenregel"></div>
<?
	//ophalen standaard templates
	$result = execQuery($link, "SELECT * FROM templates WHERE status = '1' AND account_id = '99' ORDER BY id ASC");
	while ($row = mysql_fetch_array($result)) {
		print "		<option value=\"$row[id]\">$row[naam]</option>\n";
	}
			//ophalen klant speciefieke adressenlijst HOEFT NU NOG NIET
//			$db_id = $_SESSION['id'];
//			$result = execQuery($link, "SELECT * FROM templates WHERE status = '1' AND account_id = '$db_id' ORDER BY id ASC");
//			while ($row = mysql_fetch_array($result)) {
//				print "		<option value=\"$row[id]\">$row[naam]</option>\n";
//			}
?>
</select>
<div class="tussenregel"></div>
<!-- <label for="adressenlijst">Eigen vragen toevoegen?</label><br>
	<select class="required" name="pers_vr" id="pers_vr">
	<option value=""></option>
	<option value="1">ja</option>
	<option value="2">nee</option>
</select><br> -->

<div class="labels">E-mail adressen</div>
	<select class="required" name="adressenlijst" id="adressenlijst">
	<option value=""></option>
<div class="tussenregel"></div>
<?
	//ophalen klant speciefieke adressenlijsten
	$db_id = $_SESSION['id'];
	$result = execQuery($link, "SELECT * FROM adressenlijst WHERE status = '1' AND account_id = '$db_id' ORDER BY id ASC");
	while ($row = mysql_fetch_array($result)) {
		print "		<option value=\"$row[id]\">$row[naam]</option>\n";
	}
?>
</select>
<div class="tussenregel"></div>
<div class="labels">Startdatum</div>
<input class="required" type="text" name="startdatum" id="startdatum" size="7"><label for="startdatum" style="display: none;" name="startdatum_error" id="startdatum_error" class="error">Verplicht</label><br>
<div class="tussenregel"></div>
<div class="labels"><label for="herinnering" name="herinnering_txt" id="herinnering_txt"></label></div>
<div name="herinnering" id="herinnering"><br></div>
<div class="tussenregel"></div>
<div class="labels"><label for="einddatum" name="einddatum_txt" id="einddatum_txt"></label></div>
<div name="einddatum" id="einddatum"><br></div>
</span>

<span class="step" id="tab_2">
  <label for="email_tekst">Tekst voor de e-mail uitnodiging</label><br>
  <textarea class="required" name="tekst_mail" id="tekst_mail" cols="50" rows="12"></textarea><br>
</span>

<span class="step" id="tab_3">
  <label for="email_tekst">Tekst begin vragenlijst</label><br>
  <textarea class="required" name="tekst_kop" id="tekst_kop" cols="50" rows="6"></textarea><br>
  <label for="email_tekst">Tekst bedankt na invullen vragenlijst</label><br>
  <textarea class="required" name="tekst_dank" id="tekst_dank" cols="50" rows="4"></textarea><br>
</span>

<span class="step" id="tab_4">
  <label for="email_tekst">Selecteer uw extra vragen</label><br>
		<select id="pers_vr[]" name="pers_vr[]" multiple="multiple">
<?
		$pers_vr_result = execQuery($link, "SELECT * FROM vragen_persoonlijk WHERE account_id = $db_id ORDER BY volg_nr ASC");			
		while ($vragen_data = mysql_fetch_array($pers_vr_result)) {			
			print "<option value=\"$vragen_data[id]\">$vragen_data[vraag]</option>\n";
		}
?>
		</select>
<i>Met de CRT toets kunt u meerdere vragen tegelijk selecteren. Als u geen vraag selecteert komen er geen extra vragen in het project</i>
		<br>
</span>



				</div>
				<div id="project_aanvr_but">
					<BR>
					<input class="navigation_button" id="back" value="Terug" type="reset" />
					<input class="navigation_button" id="next" value="Verder" type="submit" />
				</div>
			</form>
		</div>
	</form>
</div>

<?
}


//Overzicht
if ($a == "o") { 
?>
<B>Het aanvragen van een nieuw project</B><br><br>
Via dit programma voert u de gegevens van een nieuw te starten onderzoek in en kunt u de<br />
boodschappen die aan de deelnemers gestuurd worden desgewenst aanpassen.<br /><br />
Alvorens een onderzoek op te starten dient u de volgende stappen doorlopen te hebben: <br />
<ul>
<li>Onder het tabje "Eigen vragen" heeft u schoolspecifieke vragen ingevoerd.</li>
<li>Onder het tabje "Mailinglijsten" heeft u de bestanden met namen en e-mailadressen opgeladen.</li>
</ul>
Na het invoeren van de projectgegevens wordt de aanvraag verzonden naar onderwijspeiling.nl. <br />Het team van onderwijspeiling.nl
controleert uw aanvraag. Indien alles akkoord is wordt het project gestart op <br />de gewenste startdatum. U krijgt bericht zodra uw aanvraag is goedgekeurd. 
Indien er vragen of opmerkingen zijn over de aanvraag neemt een adviseur<br /> van onderwijspeiling.nl telefonisch contact met u op.<br><br>
<B>Het overzicht van de projecten van uw school</B><br><br>
<TABLE cellspacing="5" cellpadding="2">
<TR>
	<TD><B>Project naam</TD>
	<TD><B>Status</TD>
    <TD align="right"><B>Verzonden</TD>
    <TD align="right"><B>Ingevuld</TD>
    <TD align="right"><B>Respons %</TD>
	<TD align="right"><B>Startdatum</TD>
	<TD align="right"><B>Einddatum</TD>
	<TD align="right"><B>Herinnering</TD>
	<TD align="right"><B>Extra vragen</TD>
	<TD align="right"></TD>	
</TR>
<?
	$db_id = $_SESSION['id'];
	$result = execQuery($link, "SELECT * FROM projecten WHERE  account_id = '$db_id' ORDER BY id ASC");
	while ($row = mysql_fetch_array($result)) {
		print"<TR>\n"; 
		print"	<TD>$row[naam]</TD>\n"; 
		if ($row[status] == 1) { $status = "nieuw"; }
		if ($row[status] == 2) { $status = "akkoord"; }
		if ($row[status] == 3) { $status = "lopend"; }
		if ($row[status] == 4) { $status = "gesloten"; }
		print "	<TD>$status</TD>\n"; 
		print "	<TD align=\"right\">$row[qty_verz]</TD>\n";
		print "	<TD align=\"right\">$row[qty_ontv]</TD>\n";
		// bereken % respons
		$respons  = 0;
		if ($row[qty_verz] > 0) {
		   $respons = floatval($row[qty_ontv] / $row[qty_verz]) * 100;
		   $respons = number_format($respons, 2, '.', ',');
		}
		$respons_perc = $respons.'%';
		//
		print "	<TD align=\"right\">$respons_perc</TD>\n";
		$startdatum = convert_date($row[dd_start]); 
		print "	<TD align=\"right\">$startdatum</TD>\n"; 
		$einddatum = convert_date($row[dd_eind]);
		print "	<TD align=\"right\">$einddatum</TD>\n"; 
		$herinnering = convert_date($row[dd_herin]);
		print "	<TD align=\"right\">$herinnering</TD>\n"; 
		if ($row[pers_vr]) { $pers_vr = "ja"; } else { $pers_vr = "nee"; }
		print "	<TD align=\"center\">$pers_vr</TD>\n"; 
		//print "	<TD align=\"center\"><a href=\"voorbeeld.php?p=$row[id]\" target=\"_blank\">voorbeeld</a></TD>\n"; 	
		print "</TR>\n";
	}
print"</TABLE>\n";
}


//Wijzigen
if ($a == "w") { 
?>
<B>Het wijzigen van projecten</B><br><br>

<?
}

include ("../beheer_style/style_bottom.php");
?>