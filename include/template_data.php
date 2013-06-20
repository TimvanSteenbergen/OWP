<?
include("../include/functions.php");

$row = mysql_fetch_array(execQuery($link, "SELECT * FROM templates WHERE `id` = '$template' LIMIT 1;"));
//echo "$row[tekst_mail]";

echo json_encode(array("mail"=>"$row[tekst_mail]","kop"=>"$row[tekst_kop]","dank"=>"$row[tekst_dank]"));

?>