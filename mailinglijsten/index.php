<?
//BEVEILIGING
include("../include/login.php");



//parameter voor stijl
$tab_act = "tab_mail";
if (!($a)) { $a = "o"; }

if ($a == "o") { //Overzicht mailinglist
	$menu_item_act = "mail_overzicht"; 
}

if ($a == "t") { //Toevoegen mailinglist
	$menu_item_act = "mail_toevoegen"; 
}

//Includeer de uiteindelijke style
include ("../beheer_style/style.php");
?>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td class="menu" width="150px">
<!-- MENU -->
		<a class="menu_item" id="mail_overzicht" href="?a=o">Overzicht</a>
		<a class="menu_item" id="mail_toevoegen" href="?a=t">Toevoegen</a>
	</td>
	<td class="main"> 
<!-- MAIN -->
<?


//Toevoegen
if ($a == "t") { 
?>
<B>Toevoegen</B><br><p>
In dit onderdeel kunt u de e-mail adressen t.b.v. de onderzoeken opnemen. De adressen moeten zijn opgenomen in een Excel sheet met het formaat "Excel 97-2003".<br />
Dit formaat kunt u kiezen op het moment dat u in Excel de sheet wilt opslaan. De sheet moet twee kolommen bevatten, naam en e-mail adres.<br /><br />

U kunt <a href="mail_example.xls" target="_blank"><u>hier</u></a> een voorbeeld inzien.
</p>
<br />
<?
	if ($actie == "opsl") {		
		if ($naam_lijst == "") { $error = "<font color=\"red\">Geen naam mailinglijst opgegeven</font><br>\n"; }
		if ($uploadedfile == "") { $error .= "<font color=\"red\">Geen bestand geselecteerd</font><br>\n"; }
		
		if ($error) {
			print $error;
			unset($actie);
		}
	}

	if ($actie == "opsl") {
	
		$db_id = $_SESSION['id'];
		$result = execQuery($link, "INSERT INTO `adressenlijst` (`id`, `naam`, `account_id`, `status`) VALUES (NULL , '$naam_lijst', '$db_id', '1');"); //lijst aanmaken
		$adressenlijst_id = mysql_fetch_array(execQuery($link, "SELECT * FROM adressenlijst WHERE account_id = '$db_id' AND status = '1' ORDER BY id DESC LIMIT 1"));	//lijst id ophalen
		$adressenlijst_id = $adressenlijst_id[0];
		
		require_once '../include/excel_reader2.php';
		$bestand = $_FILES['uploadedfile']['tmp_name'];
		$bestand_naam = $_FILES['uploadedfile']['name'];
		$data = new Spreadsheet_Excel_Reader($bestand);

		if ($bestand) {
		    $sheet = 0;
		    $rowcount = $data->rowcount($sheet);
	        $aantal_opgeslagen = 0;
		    for($i = 1; $i <= $rowcount; ++$i) //rows are 1 based, first row is header
		    {
			   $naam_db = $data->val($i, 1, $sheet);
			   $email_db = $data->val($i, 2, $sheet);
			   if ($adressenlijst_id == "") { $error = 1; }
			   if ($naam_db == "") { $error = 1; }
			   if ($email_db == "") { $error = 1; }	   
			   if (!(ereg( '^[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+'. '@'. '[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.' . '[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$', $email_db))) {
					$error = 1;
				}  
		
		        if (!($error)) {

			        execQuery($link, "INSERT INTO adressen (`id`, `adressenlijst_id`, `naam`, `email`) VALUES ('NULL', '$adressenlijst_id', '$naam_db', '$email_db')") or die("error in mysql_query");
			        $aantal_opgeslagen += 1;
		        }
		       unset($error);
		    }
		    mysql_close($db);
		}
		
		$result = execQuery($link, "UPDATE adressenlijst SET `aantal` = '$aantal_opgeslagen' WHERE `id` = $adressenlijst_id LIMIT 1;"); //aantal adressen opslaan
		print "Lijst <i>$naam_lijst</i> is opgeslagen en <i>$aantal_opgeslagen</i> adressen zijn opgeslagen ";
		exit();		
	}
	


?>


<script type="text/javascript">
  $().ready(function() {
	 // $("#form2").validate();
  });
</script>

<form id="form2" name="form2" method="post" action="?a=t&actie=opsl" enctype="multipart/form-data">
		<table id="lijsten" border="0" cellspacing="0" cellpadding="2">
			<tbody>
					<tr>
						<td width="200">
							<label>Naam mailinglijst</label>
						</td>
						<td class='required naam_lijst'>
							<input size='60' value="<? print $naam_lijst;?>" class="naam_lijst" id="naam_lijst" name="naam_lijst" />
						</td>
						<td class='naam-error'></td>
					</tr>
					<tr>
						<td>
							<label>Selecteer Excel bestand</label>
						</td>
						<td>
							<input type="file" accept="application/vnd.ms-excel" ID="fileSelect" name="uploadedfile" runat="server" /> <br />						
						</td>

					</tr>	
			</tbody>
			<tfoot>
				<tr>
					<td colspan="2" align="left"><input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
                    <br  />
					<input class="submit" type="submit" value="Opslaan"/></td>
				</tr>
			</tfoot>
		</table>
</form>


<?




}

//Overzicht
if ($a == "o") { 
?>
<B>Overzicht</B><br>
<p>
In dit onderdeel kunt u de e-mail adressen t.b.v. de onderzoeken opnemen. De adressen moeten zijn opgenomen in een Excel sheet met het formaat "Excel 97-2003".<br />
Dit formaat kunt u kiezen op het moment dat u in Excel de sheet wilt opslaan. De sheet moet twee kolommen bevatten, naam en e-mail adres.<br /><br />

U kunt <a href="mail_example.xls" target="_blank"><u>hier</u></a> een voorbeeld inzien.
</p>
	<TABLE cellspacing="5" cellpadding="2">
	<TR>
		<TD width="150"><B>Mailinglist naam</TD>
		<TD><B>Aantal adressen</TD>
	</TR>
	<?
		$db_id = $_SESSION['id'];
		$result = execQuery($link, "SELECT * FROM adressenlijst WHERE  account_id = '$db_id' and status = '1' ORDER BY id ASC");
		while ($row = mysql_fetch_array($result)) {
			print"<TR>\n"; 
			print"	<TD><a href=\"overzicht.php?adressenlijst_id=$row[id]&adressenlijst_naam=$row[naam]\" target=\"_blank\">$row[naam]</a></TD>\n"; 
			print"	<TD>$row[aantal]</TD>\n"; 			
			print "</TR>\n";
		}
	print"</TABLE>\n";
	


}



print "</div>\n";
?>


<!-- MENU 
<div class="menu">
	<a class="menu_item" id="mail_overzicht" href="?a=o">Overzicht</a>
	<a class="menu_item" id="mail_toevoegen" href="?a=t">Toevoegen</a>
</div>-->


<?
include ("../beheer_style/style_bottom.php");
?>