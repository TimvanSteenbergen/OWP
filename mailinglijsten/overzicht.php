<?
//BEVEILIGING
include("../include/login.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Onderwijspeiling.nl</title>
<link href="../beheer_style/include/style.css" rel="stylesheet" type="text/css"> 


<?
if ($adressenlijst_id == "") {
	print "Geen adressenlijst id";
} else { 
?>
	<B>Overzicht lijst <i><? print $adressenlijst_naam;?></i></B><br><br>
	<TABLE cellspacing="5" cellpadding="2">
	<TR>
		<TD width="150"><B>Naam</B></TD>
		<TD><B>E-mail adres</B></TD>
	</TR>
	<?
		$result = execQuery($link, "SELECT * FROM adressen WHERE adressenlijst_id = '$adressenlijst_id' ORDER BY id ASC");
		while ($row = mysql_fetch_array($result)) {
			print"<TR>\n"; 
			print"	<TD>$row[naam]</TD>\n"; 
			print"	<TD>$row[email]</TD>\n"; 			
			print "</TR>\n";
		}
	print"</TABLE>\n";
	


}
