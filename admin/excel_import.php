<?php
	include("../include/functions.php");

error_reporting(E_ALL ^ E_NOTICE);
require_once 'excel_reader2.php';
$bestand = $_FILES['uploadedfile']['tmp_name'];
$bestand_naam = $_FILES['uploadedfile']['name'];
$data = new Spreadsheet_Excel_Reader($bestand);
?>
<html>
<head>
</head>
<body>
<?
if (!($bestand)) {
?>
	<form enctype="multipart/form-data" action="excel_import.php" method="POST">
	<input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
	Selecteer Excel bestand om in te laden: <input type="file" accept="application/vnd.ms-excel" ID="fileSelect" name="uploadedfile" runat="server" /> <br />
	<input type="submit" value="Importeer" />
	</form>
<?
}
?>

<form method="POST">
<?php
if ($bestand) {
    $sheet = 0;

    $rowcount = $data->rowcount($sheet);
    
    for($i = 1; $i <= $rowcount; ++$i) //rows are 1 based, first row is header
    {
	   $naam = $data->val($i, 1, $sheet);
	   $email = $data->val($i, 2, $sheet);
	   if ($naam == "") { $error = 1; }
	   if ($email == "") { $error = 1; }	   
	   if (!(ereg( '^[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+'. '@'. '[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.' . '[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$', $email))) {
			$error = 1;
		}  

        if (!($error)) {
	        execQuery($link, "INSERT INTO excel_import (`naam`, `email`) VALUES ('$naam', '$email')") or die("error in mysql_query");
        }
       unset($error);
    }
    mysql_close($db);

print "Het Excel bestand $bestand_naam is ingelezen";
}
?>
</form>
</body>
</html>