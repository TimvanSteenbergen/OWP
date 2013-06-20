<?
	include("../include/functions.php");
	$aantal = 0;
	$result = execQuery($link, "SELECT * FROM batch ORDER BY id ASC LIMIT $param[batch_aantal]");
	while ($row = mysql_fetch_array($result)) {
			$project_data = mysql_fetch_array(execQuery($link, "SELECT * FROM projecten WHERE id = $row[project_id] LIMIT 1"));
			$account_data = mysql_fetch_array(execQuery($link, "SELECT naam,c_email FROM accounts WHERE id = $project_data[account_id] LIMIT 1"));
			$project_data[dd_start] = convert_date($project_data[dd_start]);
			$project_data[dd_eind] = convert_date($project_data[dd_eind]);
			$url = "http://www.onderwijspeiling.nl/vragenlijst/index.php?p=$row[project_id]&e=$row[email]&pasw=$row[pasw]";

			//replace zaken uit de tekst
			$tekst_mail = $project_data[tekst_mail];
			$tekst_mail = str_replace("\n", "<br>", $tekst_mail);
			$tekst_mail = str_replace("[school]", "$account_data[naam]", $tekst_mail);
			$tekst_mail = str_replace("[start]", "$project_data[dd_start]", $tekst_mail);
			$tekst_mail = str_replace("[einde]", "$project_data[dd_eind]", $tekst_mail);
			$test_link = strstr($tekst_mail,"[link]");  //test of [link] aanwezig is 
			if($test_link) { 
				$tekst_mail = str_replace("[link]", "<a href=\"$url\">$url</a>", $tekst_mail);
			} else {
				$tekst_mail .= "<br><br>Link naar onderzoek: <a href=\"$url\">$url</a>"; 
			}

			$fromName    = $account_data[naam]; 
			$fromAddress = $account_data[c_email]; 
			include '../include/mail_basis.php';
			$message .= $tekst_mail;
			$message .= "</td></tr>\n";
			$message .= "</table>\n";
			$message .= "</body>\n";
			$message .= "</html>\n";
			$mail     = $row[email];
			$username = $row[naam];
			$subject  = "Onderwijspeiling $account_data[naam]";	
			mail($username." <".$mail.">",$subject, $message, $headers);		
			//print "$mail ,$subject,<br> $message<br> $headers<hr>"; // dit is alleen voor de test
			$aantal += 1;
			$result_delete = execQuery($link, "DELETE FROM `batch` WHERE email = '$row[email]' LIMIT 1;");		
	}

print "Er zijn $aantal e-mail berichten verzonden";
?>