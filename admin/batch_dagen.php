<?
	include("../include/functions.php");
	$aantal_batch = 0;
	$aantal_adressen = 0;
	$datum = date("Y-m-d");
	$result = execQuery($link, "SELECT id,adressenlijst_id,qty_verz FROM projecten WHERE (dd_start = '$datum' OR dd_herin = '$datum') AND (status = 2 OR status = 3) ORDER BY id ASC");
	while ($project_data = mysql_fetch_array($result)) {
		$aantal  = 0; // aantal vragenlijsten te versturen 
		$result2 = execQuery($link, "SELECT * FROM adressen WHERE adressenlijst_id = $project_data[adressenlijst_id]");
		while ($adressen_data = mysql_fetch_array($result2)) {			
			$random_pasw = getRandomString(5);
			$opslaan = mysql_fetch_array(execQuery($link, "INSERT INTO `batch` (`id`, `naam`, `email`, `pasw`, `project_id`) VALUES ('NULL', '$adressen_data[naam]', '$adressen_data[email]', '$random_pasw', '$project_data[id]') "));	
			$aantal_adressen += 1;
			$aantal += 1;
		}

		// opslaan aantal in project
		$aantal	= $aantal + $project_data[qty_verz];
		$result_aantal = execQuery($link, "UPDATE projecten SET qty_verz = '$aantal' ,
		                                                        status   = 3 WHERE id = '$project_data[id]' ");
		//
		$aantal_batch += 1;
	}
	// 
	// nu ook nog lopende projecten met een einddatum van vandaag sluiten
	// moet nog wel worden ingebouwd mails naar scholen dat project is afgesloten en dat rapportage kan worden bekeken
	$result = execQuery($link, "UPDATE projecten SET status = '4' WHERE dd_eind = '$datum' ");
	// 

print "Er zijn $aantal_batch projecten in de batch geplaatst en met in totaal $aantal_adressen adressen";
?>