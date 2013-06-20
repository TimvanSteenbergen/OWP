<?
//BEVEILIGING
include("../include/login.php");

//parameter voor stijl
$tab_act = "tab_beh";
if (!($a)) { $a = "v"; }

if ($a == "v") { //Vragen beheer
	$menu_item_act = "beh_vragen"; 
}

//Includeer de uiteindelijke style
include ("../beheer_style/style.php");
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td class="menu" width="150px">
<!-- MENU -->
	<a class="menu_item" id="beh_vragen" href="?a=v">Vragen</a>

	</td>
	<td class="main"> 
<!-- MAIN -->
<?


//Vragen
if ($a == "v") { 

if ($actie == "opsl") {
	$db_id = $_SESSION['id'];
	$result = execQuery($link, "DELETE FROM `vragen_persoonlijk` WHERE `vragen_persoonlijk`.`account_id` = $db_id;");		
	for ($i = 1; $i <= $param[pers_vr]; $i++) {
		$item_type = "item_type_". $i;
		$item_type = $$item_type;
		$item_vraag = "item_vraag_". $i;
		$item_vraag = $$item_vraag;
		if (($item_vraag) AND ($item_type)) {
			$result = execQuery($link, "INSERT INTO  `onderwijspeiling_nl_owp`.`vragen_persoonlijk` (`id`, `account_id`, `volg_nr` ,`soort` ,`vraag` ,`status`) VALUES (NULL , '$db_id', '$i', '$item_type',  '$item_vraag',  '1');");		
		}
	}	

}

?>
<B>Schoolspecifieke vragen vragen</B><br>
<p>
De vragenlijsten voor ouders, personeel en leerlingen zijn niet aan te passen, omdat we u anders geen vergelijk kunnen<br />laten zien van uw school en andere scholen. Wel is het mogelijk om een vragenlijst uit te breiden met een aantal extra vragen<br  />op een laatste pagina. Hieronder kunt u deze vragen aanmaken. <br /><br  />
Bij het aanvragen van een nieuw project bepaalt u welke specifieke vragen onderdeel moeten worden van het project. <br /><br  />
</p>
<script type="text/javascript">
  $().ready(function() {
	  $("#form2").validate();
  });
</script>

<form id="form2" name="form2" method="post" action="?a=v&actie=opsl">
		<table id="vragen" border="0" cellspacing="0" cellpadding="5">
			<tbody>
<?
	
	for ($i = 1; $i <= $param[pers_vr]; $i++) {
		$db_id = $_SESSION['id'];
		$vraag_data = mysql_fetch_array(execQuery($link, "SELECT * FROM vragen_persoonlijk WHERE account_id = '$db_id' AND volg_nr = '$i' AND status = '1' ORDER BY id ASC"));	
		if ($vraag_data[0]) {
			$type = $vraag_data[soort];
			$vraag = $vraag_data[vraag];
		}
?>
					<tr>
						<td>
							<label>Vraag <?print $i;?></label>
						</td>
						<td class="required">
							<select name="item_type_<?print $i;?>">
								<option value="">Selecteer soort...</option>
								<option <? if ($type == "janee") { print "selected=\"selected\""; } ?> value="janee">Ja/nee</option>
								<option <? if ($type == "open") { print "selected=\"selected\""; } ?> value="open">Open</option>
								<!-- <option <? if ($type == "rapport10") { print "selected=\"selected\""; } ?>value="rapport10">Rapport</option> -->
							</select>
						</td>
						<td class='required vraag'>
							<input size='60' class="vraag" value="<?print $vraag;?>" id="item_vraag_<?print $i;?>" name="item_vraag_<?print $i;?>" />
						</td>
						<td class='vraag-error'></td>
					</tr>	

<? 
		unset($vraag);	
		unset($type);	
	} 
?>			
			</tbody>
			<tfoot>
				<tr>
					<td colspan="2">&nbsp;</td>
					<td align="right"><input class="submit" type="submit" value="Opslaan"/></td>
				</tr>
			</tfoot>
		</table>
</form>
<?
}



print "</div>\n";
?>


<?
include ("../beheer_style/style_bottom.php");
?>