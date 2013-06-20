<?
include("../include/functions.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
 <head>
  	<title>Onderwijspeiling</title>
	<link rel="stylesheet" type="text/css" href="../css/vragenlijst_style.css" />
    <script type="text/javascript" src="../js/vragenlijst_site.js"></script>		
</head>
 <body>
<?
$row = mysql_fetch_array(execQuery($link, "SELECT template_id,pers_vr,account_id,status,tekst_kop,tekst_dank FROM projecten WHERE id = $p LIMIT 1"));
?>
		<div id="main">
<?
print "		<div class=\"logo\"><IMG SRC=\"$home_url/images/logo.png\" HEIGHT=\"90\" BORDER=\"0\" ALT=\"\"></div>\n";

?>
		<div id="status"><br><label class="error">Let op: dit is een voorbeeldvragenlijst</label></div>
		<div id="main_inhoud">
			<form id="form" method="post" action="voorbeeld_opslaan.php" class="bbq">
				<div id="fieldWrapper">
<?
$row2 = mysql_fetch_array(execQuery($link, "SELECT * FROM templates WHERE id = $row[template_id] LIMIT 1"));
$vragen_reeks=unserialize($row2[gegevens]);

if ($row[pers_vr]) { $vragen_reeks[] .= "pers"; }

foreach($vragen_reeks as $vragen_reeks_id)
{
	if ($vragen_reeks_id == "pers") { 
		unset($vragen);
		$pers_vr = unserialize($row[pers_vr]);
		$pers_vr_soort_array = $pers_vr[0];
		$pers_vr_vragen_array = $pers_vr[1];
		$pers_vr_soort_array = unserialize($pers_vr_soort_array);
		$pers_vr_vragen_array = unserialize($pers_vr_vragen_array);
		$aantal_array = count($pers_vr_soort_array);
		for ($pers_vr_nr = 0; $pers_vr_nr <= $aantal_array; $pers_vr_nr++) {
			$vragen[$pers_vr_nr] = $pers_vr_nr;
    	}
		print "<span class=\"step\" id=\"tab_pers\">\n";
		print "<span class=\"titel\">Persoonlijke vragen</span><br><br>\n"; //hier moet nog een kop

	} else {	
		$vraag_reeks_data = mysql_fetch_array(execQuery($link, "SELECT * FROM vragen_reeks WHERE id = $vragen_reeks_id LIMIT 1"));		
		$vragen=unserialize($vraag_reeks_data[gegevens]);
		print "<span class=\"step\" id=\"tab_$vraag_reeks_data[id]\">\n";
		print "<span class=\"titel\">$vraag_reeks_data[naam]</span><br><br>\n";
	}
	
	if ($start_txt == 0) {
		print "$row[tekst_kop]";
		echo '<br />';
		$start_txt = 1;
	}


	// uitlegtekst bovenaan scherm
	if (($vraag_reeks_data[tekst] != "") AND ($vragen_reeks_id != "pers")) {
		print "<br>$vraag_reeks_data[tekst]<br>\n<br>\n";
	}

		foreach($vragen as $vraag_nr)
		{
				$hash = strpos($vraag_nr, '#'); // kijken of er een # in de vraag_reeks zit 
				if ($hash === FALSE) { 
					if ($vragen_reeks_id == "pers") { 
//						$vraag_data = mysql_fetch_array(execQuery($link, "SELECT * FROM vragen_persoonlijk WHERE id = $vraag_nr LIMIT 1"));
						$vraag_data[soort] = $pers_vr_soort_array[$vraag_nr];
						$vraag_data[vraag] = $pers_vr_vragen_array[$vraag_nr];
						$vraag_data[id] = "pers_$vraag_nr";

						
								
					} else {
						$vraag_data = mysql_fetch_array(execQuery($link, "SELECT * FROM vragen WHERE id = $vraag_nr LIMIT 1"));		
					}
				} else {
					//als rapport 10 de kop
					if ($vraag_nr == "#rapport10_start") {
						print "<TABLE id=\"rapport_tabel\" cellspacing=\"0\" cellpadding=\"0\"><TR><TD></TD>\n";
						for ($label2 = 1; $label2 < 11; $label2++ ) { 
							print "<TD align=\"center\">$label2</TD>\n";
						}
						print "<TD class=\"rapport_error\"></TD></TR>\n";
					}
					//als rapport graad de kop
					if ($vraag_nr == "#rapport_graad_start") {
						print "<TABLE id=\"rapport_tabel\" cellspacing=\"0\" cellpadding=\"0\"><TR><TD></TD>\n";
						print "<TD align=\"center\">heel makkelijk</TD>\n";
						print "<TD align=\"center\">makkelijk</TD>\n";
						print "<TD align=\"center\">normaal</TD>\n";
						print "<TD align=\"center\">moeilijk</TD>\n";
						print "<TD align=\"center\">heel moeilijk</TD>\n";
						print "<TD class=\"rapport_error\"></TD></TR>\n";
					}
					//als rapport graad de kop
					if ($vraag_nr == "#rapport_leuk_start") {
						print "<TABLE id=\"rapport_tabel\" cellspacing=\"0\" cellpadding=\"0\"><TR><TD></TD>\n";
						print "<TD align=\"center\">helemaal niet leuk</TD>\n";
						print "<TD align=\"center\">niet leuk</TD>\n";
						print "<TD align=\"center\">normaal</TD>\n";
						print "<TD align=\"center\">leuk</TD>\n";
						print "<TD align=\"center\">heel leuk</TD>\n";
						print "<TD align=\"center\">heb ik niet</TD>\n";
						print "<TD class=\"rapport_error\"></TD></TR>\n";
					}
					//als rapport soms de kop
					if ($vraag_nr == "#rapport_soms_start") {
						print "<TABLE id=\"rapport_tabel\" cellspacing=\"0\" cellpadding=\"0\"><TR><TD></TD>\n";
						print "<TD align=\"center\">Ja</TD>\n";
						print "<TD align=\"center\">Soms</TD>\n";
						print "<TD align=\"center\">Nee</TD>\n";
					}
					//als rapport graad de kop
					if ($vraag_nr == "#rapport_gaat_start") {
						print "<TABLE id=\"rapport_tabel\" cellspacing=\"0\" cellpadding=\"0\"><TR><TD></TD>\n";
						print "<TD align=\"center\">Ja</TD>\n";
						print "<TD align=\"center\">Gaat wel</TD>\n";
						print "<TD align=\"center\">Nee</TD>\n";
					}
					//als rapport sexe de kop
					if ($vraag_nr == "#rapport_sexe_start") {
						print "<TABLE id=\"rapport_tabel\" cellspacing=\"0\" cellpadding=\"0\"><TR><TD></TD>\n";
						print "<TD align=\"center\">Jongen</TD>\n";
						print "<TD align=\"center\">Meisje</TD>\n";
					}
					//als rapport groep de kop
					if ($vraag_nr == "#rapport_groep_start") {
						print "<TABLE id=\"rapport_tabel\" cellspacing=\"0\" cellpadding=\"0\"><TR><TD></TD>\n";
						print "<TD align=\"center\">Groep 5</TD>\n";
						print "<TD align=\"center\">Groep 6</TD>\n";
						print "<TD align=\"center\">Groep 7</TD>\n";
						print "<TD align=\"center\">groep 8</TD>\n";
						print "<TD class=\"rapport_error\"></TD></TR>\n";
					}
					//als rapport taal de kop
					if ($vraag_nr == "#rapport_taal_start") {
						print "<TABLE id=\"rapport_tabel\" cellspacing=\"0\" cellpadding=\"0\"><TR><TD></TD>\n";
						print "<TD align=\"center\">Nederlands</TD>\n";
						print "<TD align=\"center\">Andere taal</TD>\n";
						print "<TD align=\"center\">2 of meer talen</TD>\n";
						print "<TD class=\"rapport_error\"></TD></TR>\n";
					}
					//einde tabel printen
					if ($vraag_nr == "#rapport_eind") { print "</TABLE><br>\n"; }
					unset ($vraag_data);
				}

		//Vraag soort Ja Nee
				if ($vraag_data[soort] == "janee")
				   {
						print "<label for=\"v_$vraag_data[id]\">$vraag_data[vraag]</label><br>\n"; 
						print "Ja<input name=\"v_$vraag_data[id]\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"Ja\">\n";
						print "Nee<input name=\"v_$vraag_data[id]\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"Nee\">\n";
						print "<label for=\"v_$vraag_data[id]\" class=\"error\" style=\"display:none\">Verplicht veld</label><br>\n";
				   } 
		//Vraag soort radio
				if ($vraag_data[soort] == "radio")
				   {
						print "<label for=\"v_$vraag_data[id]\">$vraag_data[vraag]</label><br>\n"; 
						$reeks = unserialize($vraag_data[reeks]);
						$numElementen = count($reeks);
						for ($label = 0; $label < $numElementen; $label++ ) { 
							$label_naam = $label + 1;
							$value = str_replace(" ", "_", $reeks[$label]);
							print "$reeks[$label]<input name=\"v_$vraag_data[id]\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"$value\">\n";
						}
						print "<label for=\"v_$vraag_data[id]\" class=\"error\" style=\"display:none\">Verplicht veld</label><br>\n";
					}
		//Vraag soort select
				if ($vraag_data[soort] == "select")
				   {
						print "<label for=\"v_$vraag_data[id]\">$vraag_data[vraag]</label><br>\n"; 
						print "<select name=\"v_$vraag_data[id]\" id=\"v_$vraag_data[id]\">\n";
						print "<option value=\"\"></option>\n"; 
						$reeks = unserialize($vraag_data[reeks]);
						$numElementen = count($reeks);
						for ($label = 0; $label < $numElementen; $label++ ) { 
							$value = str_replace(" ", "_", $reeks[$label]);
							print "<option value=\"$value\">$reeks[$label]</option>\n";
						}
						print "</select><br>\n\n";
					}
		//Vraag soort rapport10
				if ($vraag_data[soort] == "rapport10")
				   {
						$reeks = unserialize($vraag_data[reeks]);
						$numElementen = count($reeks);
						for ($label = 0; $label < $numElementen; $label++ ) { 
							$label_naam = $label + 1;
							print "<TR><TD><B>$vraag_data[vraag]</B></TD>\n";
							for ($label2 = 1; $label2 < 11; $label2++ ) { 
								print "<TD><input name=\"v_$vraag_data[id]\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"$label2\"></TD>\n";
							}
							print "<TD class=\"rapport_error\"><label for=\"v_$vraag_data[id]\" class=\"error\" style=\"display:none\">Verplicht veld</label></TD></TR>\n";
						}
					}
		//Vraag soort rapport_graad
				if ($vraag_data[soort] == "rapport_graad")
				   {
						$reeks = unserialize($vraag_data[reeks]);
						$numElementen = count($reeks);
						for ($label = 0; $label < $numElementen; $label++ ) { 
							$label_naam = $label + 1;
							print "<TR><TD><B>$vraag_data[vraag]</B></TD>\n";
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"heel_makkelijk\"></TD>\n";
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"makkelijk\"></TD>\n";
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"normaal\"></TD>\n";
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"moeilijk\"></TD>\n";
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"heel_moeilijk\"></TD>\n";
							print "<TD class=\"rapport_error\"><label for=\"v_$vraag_data[id]\" class=\"error\" style=\"display:none\">Verplicht veld</label></TD></TR>\n";
						}
					}
		//Vraag soort rapport_leuk
				if ($vraag_data[soort] == "rapport_leuk"){
						$reeks = unserialize($vraag_data[reeks]);
						$numElementen = count($reeks);
						for ($label = 0; $label < $numElementen; $label++ ) { 
							$label_naam = $label + 1;
							print "<TR><TD><B>$vraag_data[vraag]</B></TD>\n";
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"helemaal_niet_leuk\"></TD>\n";
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"niet_leuk\"></TD>\n";
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"normaal\"></TD>\n";
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"leuk\"></TD>\n";
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"heel_leuk\"></TD>\n";
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"heb ik niet\"></TD>\n";
							print "<TD class=\"rapport_error\"><label for=\"v_$vraag_data[id]\" class=\"error\" style=\"display:none\">Verplicht veld</label></TD></TR>\n";
						}
					}
		//Vraag soort rapport_soms
				if ($vraag_data[soort] == "rapport_soms"){
						$reeks = unserialize($vraag_data[reeks]);
						$numElementen = count($reeks);
						for ($label = 0; $label < $numElementen; $label++ ) { 
							$label_naam = $label + 1;
							print "<TR><TD><B>$vraag_data[vraag]</B></TD>\n";
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"Ja\"></TD>\n";
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"Soms\"></TD>\n";
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"Nee\"></TD>\n";
							print "<TD class=\"rapport_error\"><label for=\"v_$vraag_data[id]\" class=\"error\" style=\"display:none\">Verplicht veld</label></TD></TR>\n";
						}
					}
		//Vraag soort rapport_gaat
				if ($vraag_data[soort] == "rapport_gaat"){
						$reeks = unserialize($vraag_data[reeks]);
						$numElementen = count($reeks);
						for ($label = 0; $label < $numElementen; $label++ ) { 
							$label_naam = $label + 1;
							print "<TR><TD><B>$vraag_data[vraag]</B></TD>\n";
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"Ja\"></TD>\n";
						print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"Gaat wel\"></TD>\n";
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"Nee\"></TD>\n";
							print "<TD class=\"rapport_error\"><label for=\"v_$vraag_data[id]\" class=\"error\" style=\"display:none\">Verplicht veld</label></TD></TR>\n";
						}
					}
		//Vraag soort rapport_sexe
				if ($vraag_data[soort] == "rapport_sexe"){
						$reeks = unserialize($vraag_data[reeks]);
						$numElementen = count($reeks);
						for ($label = 0; $label < $numElementen; $label++ ) { 
							$label_naam = $label + 1;
							print "<TR><TD><B>$vraag_data[vraag]</B></TD>\n";
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"Jongen\"></TD>\n";
						print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"Meisje\"></TD>\n";
							print "<TD class=\"rapport_error\"><label for=\"v_$vraag_data[id]\" class=\"error\" style=\"display:none\">Verplicht veld</label></TD></TR>\n";
						}
					}
		//Vraag soort rapport_groep
				if ($vraag_data[soort] == "rapport_groep"){
						$reeks = unserialize($vraag_data[reeks]);
						$numElementen = count($reeks);
						for ($label = 0; $label < $numElementen; $label++ ) { 
							$label_naam = $label + 1;
							print "<TR><TD><B>$vraag_data[vraag]</B></TD>\n";
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"Groep 5\"></TD>\n";
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"Groep 6\"></TD>\n";
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"Groep 7\"></TD>\n";
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"Groep 8\"></TD>\n";
							print "<TD class=\"rapport_error\"><label for=\"v_$vraag_data[id]\" class=\"error\" style=\"display:none\">Verplicht veld</label></TD></TR>\n";
						}
					}
		//Vraag soort rapport_taal
				if ($vraag_data[soort] == "rapport_taal"){
						$reeks = unserialize($vraag_data[reeks]);
						$numElementen = count($reeks);
						for ($label = 0; $label < $numElementen; $label++ ) { 
							$label_naam = $label + 1;
							print "<TR><TD><B>$vraag_data[vraag]</B></TD>\n";
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"Nederlands\"></TD>\n";
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"Andere taal\"></TD>\n";
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"2 of meer talen\"></TD>\n";
							print "<TD class=\"rapport_error\"><label for=\"v_$vraag_data[id]\" class=\"error\" style=\"display:none\">Verplicht veld</label></TD></TR>\n";
						}
					}
		//Vraag soort open
				if ($vraag_data[soort] == "open")
				   {
						print "<label for=\"v_$vraag_data[id]\">$vraag_data[vraag]</label><br>\n"; 
						print "<textarea name=\"v_$vraag_data[id]\" id=\"v_$vraag_data[id]\" cols=\"50\" rows=\"5\"></textarea><br>\n";
				   }

				$volgorde_nummer = $volgorde_nummer + 1;
		}
        // indien uitlegtekst onderaan moet
		//if (($vraag_reeks_data[tekst] != "") AND ($vragen_reeks_id != "pers")) {
		//	print "<br>$vraag_reeks_data[tekst]<br>\n";
		//}
	
	print "</span>\n";


	//dank tekst ophalen en opmaken
	$account_data = mysql_fetch_array(execQuery($link, "SELECT naam FROM accounts WHERE id = $row[account_id] LIMIT 1"));
	$tekst_dank = str_replace("[school]", "$account_data[naam]", $row[tekst_dank]);
	$tekst_dank = str_replace("\n", "<br>", $tekst_dank);
	$tekst_dank = '<br /><br /><br />'.$tekst_dank;
}
?>
				</div>
				<div id="demoNavigation"> 							
					<input class="navigation_button" id="back" value="Terug" type="reset" />
					<input class="navigation_button" id="next" value="Verder" type="submit" />
				</div>
			</form>
		</div>
		</div>

    <script type="text/javascript" src="../js/jquery-1.4.2.min.js"></script>		
    <script type="text/javascript" src="../js/jquery.form.js"></script>
    <script type="text/javascript" src="../js/jquery.validate.js"></script>
    <script type="text/javascript" src="../js/bbq.js"></script>
    <script type="text/javascript" src="../js/jquery-ui-1.8.5.custom.min.js"></script>
    <script type="text/javascript" src="../js/jquery.form.wizard.js"></script>
    
    <script type="text/javascript">
			$(function(){
				$("#form").formwizard({ 
				 	formPluginEnabled: true,
				 	historyEnabled : true,
				 	validationEnabled: true,
				 	formOptions :{
						success: function(data){$("#status").html("<?print $tekst_dank;?>").fadeTo(500, 1)},
						beforeSubmit: function(data){$("#main_inhoud").css({"visibility": "hidden"})},
						dataType: 'json',	
						resetForm: true
				 	}						
				 }
				);
  		});
    </script>
	</body>
</html>


</TABLE>	
