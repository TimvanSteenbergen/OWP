<?
include("../include/functions.php");
$row = mysql_fetch_array(execQuery($link, "SELECT template_id,pers_vr FROM projecten WHERE id = $p LIMIT 1"));
$row2 = mysql_fetch_array(execQuery($link, "SELECT * FROM templates WHERE id = $row[template_id] LIMIT 1"));
$vragen_reeks = unserialize($row2[gegevens]);
foreach($vragen_reeks as $vragen_reeks_id)
{
	$vraag_reeks_data = mysql_fetch_array(execQuery($link, "SELECT * FROM vragen_reeks WHERE id = $vragen_reeks_id LIMIT 1"));	
	$vragen=unserialize($vraag_reeks_data[gegevens]);
	foreach($vragen as $vraag_nr)
	{
			$hash = strpos($vraag_nr, '#'); // kijken of er een # in de vraag_reeks zit 
			if ($hash === FALSE) { 
				$vraag_variabele = "v_$vraag_nr";
				$rij[$vraag_nr] .= $$vraag_variabele;
			}
	}
}
$data = serialize($rij);


if ($row[pers_vr]) {
	$pers_vr = unserialize($row[pers_vr]);
	$pers_vr_vragen_array = $pers_vr[1];
	$pers_vr_vragen_array = unserialize($pers_vr_vragen_array);
	$aantal_array = count($pers_vr_vragen_array);
	$aantal_array -= 1;
	for ($pers_vr_nr = 0; $pers_vr_nr <= $aantal_array; $pers_vr_nr++) {
		$vragen[$pers_vr_nr] = $pers_vr_nr;
		$pers_antw_var = "v_pers_" . $pers_vr_nr;
		$pers_vr_antwoord_array[] .= $$pers_antw_var;
	}
	$pers_vr_vragen_array = serialize($pers_vr_vragen_array);
	$pers_vr_antwoord_array = serialize($pers_vr_antwoord_array);
	$pers_vr_data[0] = $pers_vr_vragen_array;
	$pers_vr_data[1] = $pers_vr_antwoord_array;
	$pers_vr_data = serialize($pers_vr_data);
}	


$row2 = mysql_fetch_array(execQuery($link, "INSERT INTO `antwoorden` (`id`, `project_id`, `data`, `data_pers_vr`, `email`, `pasw`) VALUES ('NULL', '$p', '$data',  '$$pers_vr_data', '$e', '$pasw');"));


// aantal beantwoord verhogen
$row3 = mysql_fetch_array(execQuery($link, "UPDATE projecten SET `qty_ontv` = `qty_ontv` + 1 WHERE id = $p "));	

?>