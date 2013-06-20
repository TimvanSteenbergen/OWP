<?
error_reporting(E_ALL ^ E_NOTICE);
require_once 'excel_reader2.php';
$bestand = $_FILES['uploadedfile']['name'];
$data = new Spreadsheet_Excel_Reader($bestand);

//BEVEILIGING
include("../include/login.php");



//parameter voor stijl
$tab_act = "tab_mail";
if (!($a)) { $a = "t"; }

if ($a == "o") { //Overzicht mailinglist
	$menu_item_act = "mail_overzicht"; 
}

if ($a == "t") { //Toevoegen mailinglist
	$menu_item_act = "mail_toevoegen"; 
}

//Includeer de uiteindelijke style
//include ("../beheer_style/style.php");
//include ("../include/excel_reader2.php");
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

	if ($actie == "opsl") {
		$db_id = $_SESSION['id'];
		//$result = execQuery($link, "INSERT INTO  `onderwijspeiling_nl_owp`.`adressenlijst` (`id`, `naam`, `account_id`, `status`) VALUES (NULL , '$naam_lijst', '$db_id', '1');"); //lijst aanmaken
		//$adressenlijst_id = mysql_fetch_array(execQuery($link, "SELECT * FROM adressenlijst WHERE account_id = '$db_id' AND status = '1' ORDER BY id DESC LIMIT 1"));	//lijst id ophalen


		if ($bestand) {
			print "aaaaaaaaajax";
		    $sheet = 0;
		    $rowcount = $data->rowcount($sheet);
		    for($i = 1; $i <= $rowcount; ++$i) //rows are 1 based, first row is header
		    {
			   $naam_db = $data->val($i, 1, $sheet);
			   $email_db = $data->val($i, 2, $sheet);
			   if ($naam_db == "") { $error = 1; }
			   if ($email_db == "") { $error = 1; }	   
			   if (!(ereg( '^[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+'. '@'. '[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.' . '[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$', $email_db))) {
					$error = 1;
				}  
		
		        if (!($error)) {

			        execQuery($link, "INSERT INTO adressen (`id`, `adressenlijst_id`, `naam`, `email`) VALUES ('NULL', '$adressenlijst_id[0]', '$naam_db', '$email_db')") or die("error in mysql_query");
		        }
		       unset($error);
		    }
		    mysql_close($db);
		}
		print "Lijst $naam_lijst is opgeslagen en  namen zijn opgeslagen ";
		exit();		
	}
	


?>
<B>Toevoegen</B><br><br>

<script type="text/javascript">
  $().ready(function() {
	 // $("#form2").validate();
  });
</script>

<form id="form2" name="form2" method="post" action="index copy.php" enctype="multipart/form-data">
		<table id="lijsten" border="0" cellspacing="0" cellpadding="2">
			<tbody>
					<tr>
						<td width="200">
							<label>Naam mailinglist</label>
						</td>
						<td class='required naam_lijst'>
							<input size='60' class="naam_lijst" id="naam_lijst" name="naam_lijst" />
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
					<input type="hidden" name="a" value="t" />
					<input type="hidden" name="actie" value="opsl" />
					<input class="submit" type="submit" value="Opslaan"/></td>
				</tr>
			</tfoot>
		</table>
</form>

	<form enctype="multipart/form-data" action="../admin/excel_import.php" method="POST">
	<input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
	Selecteer Excel bestand om in te laden: <input type="file" accept="application/vnd.ms-excel" ID="fileSelect" name="uploadedfile" runat="server" /> <br />
	<input type="submit" value="Importeer" />
	</form>


<?




}

//Overzicht
if ($a == "o") { 
?>
<B>Overzicht</B><br><br>

<?
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