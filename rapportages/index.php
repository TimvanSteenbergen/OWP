<?
//BEVEILIGING
include("../include/login.php");

//parameter voor stijl
$tab_act = "tab_rap";
if (!($a)) { $a = "o"; }

if ($a == "o") { //Overzicht rapportages
	$menu_item_act = "rapp_overzicht"; 
}


//Includeer de uiteindelijke style
include ("../beheer_style/style.php");
?>
<link class="include" rel="stylesheet" type="text/css" href="../dist/jquery.jqplot.css" />

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td class="menu" width="150px">
<!-- MENU -->
		<a class="menu_item" id="rapp_overzicht" href="?a=o">Overzicht</a>
	</td>
	<td class="main"> 
<!-- MAIN -->
<?

//Overzicht
if ($a == "o") { 
?>
<B>Het overzicht van alle afgesloten projecten</B><br><br>
<TABLE cellspacing="5" cellpadding="2">
<TR>
	<TD><B>Project naam</TD>
    <TD align="right"><B>Aantal</TD>
    <TD align="right"><B>Beantwoord</TD>
	<TD align="right"><B>Startdatum</TD>
	<TD align="right"><B>Einddatum</TD>
	<TD align="right"><B>Herinnering</TD>
	<TD align="right"><B>Extra vragen</TD>
</TR>
<?
	$db_id = $_SESSION['id'];
	$result = execQuery($link, "SELECT * FROM projecten WHERE  account_id = '$db_id' AND status = 4 ORDER BY id ASC");
	while ($row = mysql_fetch_array($result)) {
		print"<TR>\n"; 
		print"	<TD><a href=\"?a=p&p=$row[id]\">$row[naam]</a></TD>\n"; 
		print "	<TD align=\"right\">$row[qty_verz]</TD>\n";
		print "	<TD align=\"right\">$row[qty_ontv]</TD>\n";
		$startdatum = convert_date($row[dd_start]); 
		print "	<TD align=\"right\">$startdatum</TD>\n"; 
		$einddatum = convert_date($row[dd_eind]);
		print "	<TD align=\"right\">$einddatum</TD>\n"; 
		$herinnering = convert_date($row[dd_herin]);
		print "	<TD align=\"right\">$herinnering</TD>\n"; 
		if ($row[pers_vr] == 1) { $pers_vr = "ja"; } else { $pers_vr = "nee"; }
		print "	<TD align=\"center\">$pers_vr</TD>\n"; 
		print "</TR>\n";
	}
print"</TABLE>\n";


}


//Overzicht
if ($a == "p") { 

?>

  <script class="include" type="text/javascript" src="../dist/jquery.min.js"></script>
  <script class="include" type="text/javascript" src="../dist/jquery.jqplot.min.js"></script>
  <script class="include" language="javascript" type="text/javascript" src="../dist/plugins/jqplot.canvasTextRenderer.min.js"></script>
  <script class="include" language="javascript" type="text/javascript" src="../dist/plugins/jqplot.canvasAxisTickRenderer.js"></script>
  <script class="include" language="javascript" type="text/javascript" src="../dist/plugins/jqplot.categoryAxisRenderer.min.js"></script>
  <script class="include" language="javascript" type="text/javascript" src="../dist/plugins/jqplot.barRenderer.js"></script>
  <script class="include" type="text/javascript" src="../dist/plugins/jqplot.pieRenderer.min.js"></script>


<?
	//ophallen alle antwoorden en in array's stoppen
	$antwoorden_aantal = 0;
	$result = execQuery($link, "SELECT * FROM antwoorden WHERE project_id = $p ORDER BY id ASC");
	while ($row = mysql_fetch_array($result)) {
		//print"$row[timestamp]<br>\n"; 
		$antwoorden_data[$antwoorden_aantal] = unserialize($row[data]);
		//print "<br>";
		$antwoorden_aantal += 1;
	}
//	print_r ($antwoorden_data[1]);
//	print "<br>";
//	print_r ($antwoorden_data[2]);

	$row_projecten = mysql_fetch_array(execQuery($link, "SELECT * FROM projecten WHERE id = $p ORDER BY id ASC"));
	$row_template = mysql_fetch_array(execQuery($link, "SELECT * FROM templates WHERE id = $row_projecten[template_id] ORDER BY id ASC")); 
	$row_accounts = mysql_fetch_array(execQuery($link, "SELECT * FROM accounts WHERE id = $row_projecten[account_id] ORDER BY id ASC"));

	print "School: $row_accounts[naam] ($row_accounts[bic])<br>\n";
	print "Adres: $row_accounts[straat] $row_accounts[nummer]<br>\n";
	print "Plaats: $row_accounts[pc] $row_accounts[plaats]<br>\n";
	print "Tel: $row_accounts[tel]<br>\n";
	print "E-mail: $row_accounts[email]<br><br>\n";

	print "Projectnaam : $row_projecten[naam]<br>\n";
	print "Vragenlijst: $row_template[naam]<br>\n";
	$row_projecten[dd_start] = convert_date($row_projecten[dd_start]);
	print "Startdatum: $row_projecten[dd_start]<br>\n";
	$row_projecten[dd_eind] = convert_date($row_projecten[dd_eind]);
	print "Einddatum:  $row_projecten[dd_eind]<br>\n";
	$row_projecten[dd_herin] = convert_date($row_projecten[dd_herin]);
	print "Herinnering:  $row_projecten[dd_herin]<br>\n";
	if ($row_projecten[pers_vr] == "0") { $row_projecten[pers_vr] = "nee"; }
	if ($row_projecten[pers_vr] == "1") { $row_projecten[pers_vr] = "ja"; }
	print "Eigen vragen:  $row_projecten[pers_vr]<br><br>\n";

$vragen_reeks=unserialize($row_template[gegevens]);

if ($row[pers_vr] == 1) { $vragen_reeks[] .= "pers"; }
foreach($vragen_reeks as $vragen_reeks_id)
{
	if ($vragen_reeks_id == "pers") { 
		$pers_vr_result = execQuery($link, "SELECT * FROM vragen_persoonlijk WHERE account_id = $row[account_id] ORDER BY volg_nr ASC");			
		unset ($vragen);
		while ($vragen_data = mysql_fetch_array($pers_vr_result)) {			
			$vragen[] = $vragen_data[id];
		}
		print "<span class=\"step\" id=\"tab_pers\">\n";
		print "<span class=\"titel\">Persoonlijke vragen</span><br><br>\n"; //hier moet nog een kop
		print_r($vragen);
	} else {	
		$vraag_reeks_data = mysql_fetch_array(execQuery($link, "SELECT * FROM vragen_reeks WHERE id = $vragen_reeks_id LIMIT 1"));		
		$vragen=unserialize($vraag_reeks_data[gegevens]);
		print "<span class=\"step\" id=\"tab_$vraag_reeks_data[id]\">\n";
		print "<span class=\"titel\">$vraag_reeks_data[naam]</span><br><br>\n";
	}

		foreach($vragen as $vraag_nr)
		{
				$hash = strpos($vraag_nr, '#'); // kijken of er een # in de vraag_reeks zit 
				if ($hash === FALSE) { 
					if ($vragen_reeks_id == "pers") { 
						$vraag_data = mysql_fetch_array(execQuery($link, "SELECT * FROM vragen_persoonlijk WHERE id = $vraag_nr LIMIT 1"));		
					} else {
						$vraag_data = mysql_fetch_array(execQuery($link, "SELECT * FROM vragen WHERE id = $vraag_nr LIMIT 1"));		
					}
				} else {
					//als rapport 10 de kop

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
//					if ($vraag_nr == "#rapport_eind") { print "</TABLE><br>\n"; }
					unset ($vraag_data);
				}

		//Vraag soort Ja Nee
				if ($vraag_data[soort] == "janee")
				   {
						print "<label for=\"v_$vraag_data[id]\">$vraag_data[vraag]</label><br>\n"; 
						print "Ja<input name=\"v_$vraag_data[id]\" class=\"required\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"Ja\">\n";
						print "Nee<input name=\"v_$vraag_data[id]\" class=\"required\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"Nee\">\n";
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
							print "$reeks[$label]<input name=\"v_$vraag_data[id]\" class=\"required\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"$value\">\n";
						}
						print "<label for=\"v_$vraag_data[id]\" class=\"error\" style=\"display:none\">Verplicht veld</label><br>\n";
					}
		//Vraag soort select
				if ($vraag_data[soort] == "select")
				   {
						//print "<label for=\"v_$vraag_data[id]\">$vraag_data[id]</label><br>\n"; 
						$vraag_id = $vraag_data[id];
						$reeks = unserialize($vraag_data[reeks]);
						$numElementen = count($reeks);
						for ($label = 0; $label < $numElementen; $label++ ) { 
							$value = str_replace(" ", "_", $reeks[$label]);
							$antwoorden_array["$value"] = 0;
						}
						//print_r($antwoorden_array);
						//print "<br>\n\n";
						for ($label = 0; $label < $antwoorden_aantal; $label++ ) { 
							$antwoord_vraag = $antwoorden_data[$label]; 
							//print "$antwoord_vraag<br>";
							$antwoord_vraag = $antwoord_vraag[$vraag_id]; //dit is het antwoord
							//$antwoorden_array[$antwoord_vraag] += 1;
							$antwoorden_array[$antwoord_vraag] += intval((100 / $antwoorden_aantal)); // percentage uitrekenen
						}
					?>

					<div id="chart<? print $vraag_id; ?>" style="height:200px; width:500px;"></div><br>
					  
					<script type="text/javascript">
					$(document).ready(function(){


					  var line1 = [
					<?
						foreach($antwoorden_array as $grafiek_waarde){ 

						$grafiek_key = key($antwoorden_array);
						$grafiek_key = str_replace("_", " ", $grafiek_key);
						$grafiek_line1 .= "['".$grafiek_key."', $grafiek_waarde],";
						next($antwoorden_array); 
					}
						$grafiek_line1 = substr_replace($grafiek_line1 ,"",-1);
						print "$grafiek_line1";
						unset ($grafiek_line1);
						//['1', 7],['2', 2],['3', 14],['4', 19],['5', 3],['6', 10],['7', 5], ['8', 15]
					?>
					  ];

					  var plot1 = $.jqplot('chart<? print $vraag_id;?>', [line1], {
						title: '<? print "$vraag_data[id] $vraag_data[vraag]";?>',
						series:[{renderer:$.jqplot.BarRenderer}],
						axesDefaults: {
							tickRenderer: $.jqplot.CanvasAxisTickRenderer ,
							tickOptions: {
							  angle: 20
							}
						},
						axes: {
						  xaxis: {
							renderer: $.jqplot.CategoryAxisRenderer
						  },
						  yaxis: {
							min: 0,
							max: 100,
							ticks: [0, 25, 50, 75, 100],
							tickOptions:{ formatString:'%d\%' }, 
						  },
						}
					  });
					});
					</script>
					<?
						//print_r($antwoorden_array);
						//print "<br>\n\n";
						unset ($antwoorden_array);

					}

		//Vraag soort rapport10
				if ($vraag_data[soort] == "rapport10")
				   {
						
						$vraag_id = $vraag_data[id];
						$reeks = unserialize($vraag_data[reeks]);
						for ($label = 1; $label < 11; $label++ ) { 
							$antwoorden_array["$label"] = 0;
						}
						for ($label = 0; $label < $antwoorden_aantal; $label++ ) { 
							$antwoord_vraag = $antwoorden_data[$label]; 
							$antwoord_vraag = $antwoord_vraag[$vraag_id]; //dit is het antwoord
							//$antwoorden_array[$antwoord_vraag] += 1;
							$antwoorden_array[$antwoord_vraag] += (100 / $antwoorden_aantal); // percentage uitrekenen
						}
?>
					<div id="chart<? print $vraag_id;?>" style="height:200px; width:500px;"></div><br><br>
					  
					<script type="text/javascript">
					$(document).ready(function(){
					  var line1 = [
					<?
						foreach($antwoorden_array as $grafiek_waarde){ 

						$grafiek_key = key($antwoorden_array);
						$grafiek_key = str_replace("_", " ", $grafiek_key);
						$grafiek_line1 .= "['".$grafiek_key."', $grafiek_waarde],";
						next($antwoorden_array); 
					}
						$grafiek_line1 = substr_replace($grafiek_line1 ,"",-1);
						print "$grafiek_line1";
						unset ($grafiek_line1);
					?>
					  ];

					  var plot1 = $.jqplot('chart<? print $vraag_id;?>', [line1], {
						title: '<? print "$vraag_data[id] $vraag_data[vraag]";?>',
						series:[{renderer:$.jqplot.BarRenderer}],
						axesDefaults: {
							tickRenderer: $.jqplot.CanvasAxisTickRenderer ,
							tickOptions: {
							  angle: 20
							}
						},
						axes: {
						  xaxis: {
							renderer: $.jqplot.CategoryAxisRenderer
						  },
						  yaxis: {
							min: 0,
							max: 100,
							ticks: [0, 25, 50, 75, 100],
							tickOptions:{ formatString:'%d\%' }, 
						  },
						}
					  });
					});
					</script>
					<?
						unset ($antwoorden_array);										
						
		/*				
						$reeks = unserialize($vraag_data[reeks]);
						$numElementen = count($reeks);
						for ($label = 0; $label < $numElementen; $label++ ) { 
							$label_naam = $label + 1;
							print "<TR><TD><B>$vraag_data[vraag]</B></TD>\n";
							for ($label2 = 1; $label2 < 11; $label2++ ) { 
								print "<TD><input name=\"v_$vraag_data[id]\" class=\"required\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"$label2\"></TD>\n";
							}
							print "<TD class=\"rapport_error\"><label for=\"v_$vraag_data[id]\" class=\"error\" style=\"display:none\">Verplicht veld</label></TD></TR>\n";
						}
		*/
					}
		//Vraag soort rapport_graad
				if ($vraag_data[soort] == "rapport_graad")
				   {
						$reeks = unserialize($vraag_data[reeks]);
						$numElementen = count($reeks);
						for ($label = 0; $label < $numElementen; $label++ ) { 
							$label_naam = $label + 1;
							print "<TR><TD><B>$vraag_data[vraag]</B></TD>\n";
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" class=\"required\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"heel_makkelijk\"></TD>\n";
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" class=\"required\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"makkelijk\"></TD>\n";
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" class=\"required\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"normaal\"></TD>\n";
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" class=\"required\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"moeilijk\"></TD>\n";
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" class=\"required\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"heel_moeilijk\"></TD>\n";
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
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" class=\"required\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"helemaal_niet_leuk\"></TD>\n";
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" class=\"required\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"niet_leuk\"></TD>\n";
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" class=\"required\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"normaal\"></TD>\n";
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" class=\"required\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"leuk\"></TD>\n";
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" class=\"required\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"heel_leuk\"></TD>\n";
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" class=\"required\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"heb ik niet\"></TD>\n";
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
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" class=\"required\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"Ja\"></TD>\n";
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" class=\"required\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"Soms\"></TD>\n";
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" class=\"required\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"Nee\"></TD>\n";
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
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" class=\"required\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"Ja\"></TD>\n";
						print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" class=\"required\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"Gaat wel\"></TD>\n";
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" class=\"required\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"Nee\"></TD>\n";
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
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" class=\"required\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"Jongen\"></TD>\n";
						print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" class=\"required\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"Meisje\"></TD>\n";
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
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" class=\"required\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"Groep 5\"></TD>\n";
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" class=\"required\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"Groep 6\"></TD>\n";
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" class=\"required\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"Groep 7\"></TD>\n";
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" class=\"required\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"Groep 8\"></TD>\n";
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
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" class=\"required\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"Nederlands\"></TD>\n";
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" class=\"required\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"Andere taal\"></TD>\n";
							print "<TD align=\"center\"><input name=\"v_$vraag_data[id]\" class=\"required\" type=\"radio\" id=\"v_$vraag_data[id]\" value=\"2 of meer talen\"></TD>\n";
							print "<TD class=\"rapport_error\"><label for=\"v_$vraag_data[id]\" class=\"error\" style=\"display:none\">Verplicht veld</label></TD></TR>\n";
						}
					}
		//Vraag soort open
				if ($vraag_data[soort] == "open")
				   {
						print "<label for=\"v_$vraag_data[id]\">$vraag_data[vraag]</label><br>\n"; 
						print "<textarea class=\"required\" name=\"v_$vraag_data[id]\" id=\"v_$vraag_data[id]\" cols=\"50\" rows=\"5\"></textarea><br>\n";
				   }

				$volgorde_nummer = $volgorde_nummer + 1;
		}


	
	print "<br><br></span>\n";
}

}

print "</div>\n";
?>

<?
include ("../beheer_style/style_bottom.php");
?>