<?
// test of hij hier komt
//mail('mbeukenkamp@gmail.com', 'Test', 'Tekst', '');
// home url zetten, moet later wellicht in bestand param
$home_url = 'http://www.onderwijspeiling.nl/';
//
function connectToDatabase() {
    $link = mysql_connect ("127.0.0.1", "owp_access", "frankrijk1")
    or die ("Could not connect");
  mysql_select_db("owp")
    or die ("Could not find database");
  return $link;
}

function execQuery($link, $query) {
  if (!($result = mysql_query($query))) {
    print "<font class=\"error\">Query error<br>Query: $query</font>";
    exit;
  }

  return $result;
}

// linken DB
$link = connectToDatabase();
// ophalen parameters
$param     = mysql_fetch_array(execQuery($link, "SELECT * FROM param WHERE id = '1' LIMIT 1"));

function hoofdletter($naam){
	$str = strtoupper ($naam{0});
	$str .= substr ($naam, 1); 
	$naam = $str;
	return ($naam);
}

function hoofdletter_caps($naam){
	$naam = strtolower($naam);
	$naam{0} = strtoupper($naam{0});
	return ($naam);
}

function input_veld($name,$size,$var,$max,$value){
	if ($max) { $maxlength = "maxlength=\"$max\""; }
	if (($value) AND (!($var))) { $var = $value; }
	if ($var) {
		print "<input name=\"$name\" type=\"text\" id=\"$name\" size=\"$size\" $maxlength value=\"$var\">";
	} else {
		print "<input name=\"$name\" type=\"text\" id=\"$name\" size=\"$size\" $maxlength>";
	}
}

function input_vakje($name,$invulveld,$var,$kolommen){
	array_splice($invulveld, 0, 0, ""); //is om het eerste vakje leeg te laten zijn zodat ook alle elementen tonen
	$numElementen = count($invulveld); 
	$kolom_nummer = 1; 
	$width = 100 / $kolommen - 2;
	print "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
	for ($label = 1; $label < $numElementen; $label++ ) { 
		$name_id = $name . "[" . $label . "]"; //naam en id een array naam geven
		if ($kolom_nummer == 1) {
			print "<tr>\n";
		}		
		print "<td width=\"2%\" valign=\"middle\">";
		print "<input name=\"$name_id\" type=\"checkbox\" id=\"$name_id\" value=\"1\"";
		if ($var[$label] == "1") { 
			print "checked=\"checked\""; 
		}
		print "></td>\n";
		print "<td width=\"$width%\" class=\"tekst\" valign=\"middle\">$invulveld[$label]</td>\n";
		if ($kolom_nummer >= $kolommen) {
			print "</tr>\n";
			$kolom_nummer = 1;
		} else {
			$kolom_nummer = $kolom_nummer + 1; 
		}
	}
	print "</table>\n";
}

function select_reeks($name,$invulveld,$var,$onchange) {
	if ($onchange) { $onchange = "onChange=\"$onchange\""; }
	print "<select name=\"$name\" id=\"$name\" $onchange>\n";
		$numElementen = count($invulveld);   
		for ($label = 0; $label < $numElementen; $label++ ) { 
			if ($invulveld[$label] == "--") { $value = ""; } else { $value = "$invulveld[$label]"; } 
			print "<option value=\"$value\"";
			if ($var == "$invulveld[$label]") { print "selected=\"selected\""; }
			print ">$invulveld[$label]</option>\n";
		}
	print "</select>\n";
}


function select_radio($name,$invulveld,$var,$onchange,$extra) {
	print "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
	$numElementen = count($invulveld);   
	for ($label = 0; $label < $numElementen; $label++ ) { 
		$label_naam = $label + 1;
		if (($name == "getipt")  AND ($invulveld[$label] == "ja")){ $onchange = "onclick=\"document.getElementById('tip_form').style.display = 'block';\""; }
		if (($name == "getipt")  AND ($invulveld[$label] == "nee")){ $onchange = "onclick=\"document.getElementById('tip_form').style.display = 'none';\""; }
		if (($name == "koopwoning")  AND ($invulveld[$label] == "ja")){ $onchange = "onclick=\"document.getElementById('tip_form').style.display = 'block';\""; }
		if (($name == "koopwoning")  AND ($invulveld[$label] == "nee")){ $onchange = "onclick=\"document.getElementById('tip_form').style.display = 'none';\""; }
		if ($extra == "janee") { 
			$form_var = $name . "_form";
			if (($invulveld[$label] == "ja")){ $onchange = "onclick=\"document.getElementById('$form_var').style.display = 'block';\""; }
			if (($invulveld[$label] == "nee")){ $onchange = "onclick=\"document.getElementById('$form_var').style.display = 'none';\""; }		
		}
		if ($extra == "YesNo") { 
			$form_var = $name . "_form";
			if (($invulveld[$label] == "Yes")){ $onchange = "onclick=\"document.getElementById('$form_var').style.display = 'block';\""; }
			if (($invulveld[$label] == "No")){ $onchange = "onclick=\"document.getElementById('$form_var').style.display = 'none';\""; }		
		}
		print "<tr valign=\"middle\">\n";
		print "<td width=\"20\" style=\"padding-bottom:4px;\">";
		print "<input name=\"$name\" type=\"radio\" id=\"$name\" $onchange value=\"$invulveld[$label]\"";
		if ($var == "$invulveld[$label]") { print "checked=\"checked\""; }
		print "></td>\n";
		print "<td class=\"tekst\" height=\"20\">$invulveld[$label]</td>\n";
		print "</tr>\n";
		unset ($onchange);
	}
	print "</table>\n";
}

function select_radio_horiz($name,$invulveld,$var) {
	$numElementen = count($invulveld);
	print "<tr>\n";
		print "<td align=\"left\" class=\"tekst\">$name</td>";
	for ($label = 0; $label < $numElementen; $label++ ) { 
		$label_naam = $label + 1;
		print "<td align=\"center\">";
		if (($invulveld[$label] != "nvt") OR ($invulveld[$label] == "nvt" AND $name == "tuin")) {
			print "<input name=\"$name\" class=\"styled\" type=\"radio\" id=\"$name\" value=\"$invulveld[$label]\"";
			if ($var == "$invulveld[$label]") { print "checked=\"checked\""; }
			print ">";
		}
		print "</td>\n";
	}
	print "</tr>\n";
}


function select_nummer($name,$start,$eind,$select,$zijnjaartal) {
	print "<select name=\"$name\" id=\"$name\">\n";
	print "<option value=\"\"";
		if ($select == "") { print "selected=\"selected\""; }
	print ">--</option>\n";
	if ($zijnjaartal) { 
		print "<option value=\"< $start\"";
			if ($select == "< $start") { print "selected=\"selected\""; }
		print ">< $start</option>\n";
	}
	for ($i = $start; $i <= $eind; $i++) {
		print "<option value=\"$i\"";
		if ($select == "$i") { print "selected=\"selected\""; }
		print ">$i</option>\n";
	}
	print "</select>\n";
}

function opmerking($name,$var,$kop,$cols,$rows) {
	if (!($cols)) { $cols = 60; }
	if (!($rows)) { $rows = 2; }
	print "	  <table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n";
	if ($kop) {
		print "        <tr valign=\"bottom\">\n";
		print "          <td height=\"20\" class=\"tekst\">$kop</td>\n";
		print "        </tr>\n";
	}
	print "        <tr valign=\"top\">\n";
	print "          <td><textarea name=\"$name\" id=\"$name\" cols=\"$cols\" rows=\"$rows\">$var</textarea></td>\n";
	print "        </tr>\n";
	print "      </table>\n";
}

function convert_date($date = false){  
    $date = ($date) ? explode('-', $date) : false;  
	if ($date[2] == "01") $date[2] = "1";
	if ($date[2] == "02") $date[2] = "2";
	if ($date[2] == "03") $date[2] = "3";
	if ($date[2] == "04") $date[2] = "4";
	if ($date[2] == "05") $date[2] = "5";
	if ($date[2] == "06") $date[2] = "6";
	if ($date[2] == "07") $date[2] = "7";
	if ($date[2] == "08") $date[2] = "8";
	if ($date[2] == "09") $date[2] = "9";
	
	if ($date[1] == "01") $date[1] = "januari";
	if ($date[1] == "02") $date[1] = "februari";
	if ($date[1] == "03") $date[1] = "maart";
	if ($date[1] == "04") $date[1] = "april";
	if ($date[1] == "05") $date[1] = "mei";
	if ($date[1] == "06") $date[1] = "juni";
	if ($date[1] == "07") $date[1] = "juli";
	if ($date[1] == "08") $date[1] = "augustus";
	if ($date[1] == "09") $date[1] = "september";
	if ($date[1] == "10") $date[1] = "oktober";
	if ($date[1] == "11") $date[1] = "november";
	if ($date[1] == "12") $date[1] = "december";
	return ($date) ? $date[2] . ' ' . $date[1] . ' ' . $date[0] : false; 
} 

function convert_month($month = false){  
	if ($month == "01") $month = "januari";
	if ($month == "02") $month = "februari";
	if ($month == "03") $month = "maart";
	if ($month == "04") $month = "april";
	if ($month == "05") $month = "mei";
	if ($month == "06") $month = "juni";
	if ($month == "07") $month = "juli";
	if ($month == "08") $month = "augustus";
	if ($month == "09") $month = "september";
	if ($month == "10") $month = "oktober";
	if ($month == "11") $month = "november";
	if ($month == "12") $month = "december";
	return $month; 
} 


function vraag($vraag,$error_var) {
	if ($error_var) {
		print "<font class=\"error\">$vraag ($error_var)</font>\n";
	} else {
		print "<font class=\"vraag\">$vraag</font>\n";
	}
}

function vraag_sub($vraag,$error_var) {
	if ($error_var) {
		if ($error_var == "_") {
			print "<font class=\"error\">$vraag</font>\n";
		} else {
			print "<font class=\"error\">$vraag ($error_var)</font>\n";
		}
	} else {
		print "$vraag\n";
	}
}

function vraag_vragenlijst($vraag,$error_var) {
	if ($error_var) {
		print "<font class=\"error\">$vraag</font>\n";
	} else {
		print "<font class=\"vraag\">$vraag</font>\n";
	}
}

function error($error_nr) {
	if ($error_nr) {
		print "<font class=\"error\">";
	}
}

function generatePassword ($length)
{
  $password = "";
  $possible = "0123456789bcdfghjkmnpqrstvwxyz"; 
  $i = 0; 
   
  while ($i < $length) { 
    $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
    if (!strstr($password, $char)) { 
      $password .= $char;
      $i++;
    }
  }
  return $password;
}

function shortenString($string, $aantal_tekens = 30) {  
        if(strlen($string) > $aantal_tekens) {  
            $row = explode(" ", $string);  
                if(strlen($row[0]) < $aantal_tekens) {  
                      for($i = 0; $i < count($row); $i++) {  
                          if(strlen($de_string_op_lengte." ".$row[$i]) < $aantal_tekens) {  
                              if($i == 0) {  
                                $de_string_op_lengte = $row[$i];  
                            } 
                            else {  
                                  $de_string_op_lengte = $de_string_op_lengte." ".$row[$i];  
                            }  
                          } 
                        else break; 
                      }     
                } 
                else {  
                      $de_string_op_lengte = substr($string, 0, $aantal_tekens);  
                }  
              $string = $de_string_op_lengte . "...";  
        }
        return $string;  
    } 


function convert($string) {
		$temp = $string;
		$temp = str_replace("\'", "\\'", $temp);
		$temp = str_replace("\n", "<br>", $temp);
        return $temp;  
}

function unconvert($string) {
		$temp = $string;
		$temp = str_replace("\\'", "\'", $temp);
		$temp = str_replace("<br>", "\n", $temp);
        return $temp;  
}

function convert_tags($string) {
		$temp = str_replace("[naam]", "$klant_naam", $temp);
		$temp = str_replace("[datum]", "$datum_convert", $temp);
		$temp = str_replace("[adres]", "$klant_adres", $temp);
		$temp = str_replace("[woonplaats]", "$klant_woonplaats", $temp);
		$temp = str_replace("[makelaar]", "$makelaar", $temp);
		$temp = str_replace("[kantoor]", "$kantoor_naam", $temp);
        return $temp;  
}

function convert_datetag($datum) {
		$datum = str_replace("Monday", "maandag", $datum);
		$datum = str_replace("Tuesday", "dinsdag", $datum);
		$datum = str_replace("Wednesday", "woensdag", $datum);
		$datum = str_replace("Thursday", "donderdag", $datum);
		$datum = str_replace("Friday", "vrijdag", $datum);
		$datum = str_replace("Saturday", "zaterdag", $datum);
		$datum = str_replace("Sunday", "zondag", $datum);

		$datum = str_replace("January", "januari", $datum);
		$datum = str_replace("February", "februari",     $datum);
		$datum = str_replace("March", "maart", $datum);
		$datum = str_replace("April", "april", $datum);
		$datum = str_replace("May", "mei", $datum);
		$datum = str_replace("June", "juni", $datum);
		$datum = str_replace("July", "juli", $datum);
		$datum = str_replace("August", "augustus", $datum);
		$datum = str_replace("September", "september", $datum);
		$datum = str_replace("October", "oktober", $datum);
		$datum = str_replace("November", "november", $datum);
		$datum = str_replace("December", "december", $datum);

		return $datum;  
}

function convert_date_to_us($date = false){  
    $date = ($date) ? explode('-', $date) : false;  
	return ($date) ? $date[2] . '-' . $date[1] . '-' . $date[0] : false; 
} 

function getRandomString($length) {
    $validCharacters = "abcdefghijklmnopqrstuxyvwzABCDEFGHIJKLMNOPQRSTUXYVWZ+-*#&@!?1234567890";
    $validCharNumber = strlen($validCharacters);
 
    $result = "";
 
    for ($i = 0; $i < $length; $i++) {
        $index = mt_rand(0, $validCharNumber - 1);
        $result .= $validCharacters[$index];
    }
 
    return $result;
}

?>
