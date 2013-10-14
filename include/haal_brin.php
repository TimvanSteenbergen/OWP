<?
include("functions.php");
$result = mysql_fetch_array(execQuery($link, "SELECT * FROM z_scholen WHERE nr_administratie = '$brin' LIMIT 1"));
$naam   = $result[naam_volledig];
$adres  = $result[naam_straat_vest].' '.$result[nr_huis_vest];
$plaats = $result[postcode_vest].'  '.$result[naam_plaats_vest];

if (!($result)) {
	$naam = "error";
//	$naam = "<label class=error>Ongeldig BRIN nummer</label>";
	$plaats = "";
	$adres  = "";
}

$plaats = hoofdletter_caps($plaats);

//build the JSON array for return
$json = array(array('field' => 'school_naam', 
                    'value' => $naam),
			  array('field' => 'school_adres',
			        'value' => $adres), 
              array('field' => 'school_plaats', 
                    'value' => $plaats));
//print $json;
//phpinfo();
echo json_encode($json);

?>