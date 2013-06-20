<?
//BEVEILIGING
include("../include/login.php");

//code voor opslaan instellingen
if ($actie == "opslaan") {
	$db_id = $_SESSION['id'];
	$result = execQuery($link, "UPDATE accounts SET naam = '$veld_naam' WHERE `id` = $db_id LIMIT 1;");
	$_SESSION['naam'] = $veld_naam;
}


//bovenkant stijl
include ("../beheer_style/style.php");

// MAIN 
print "<div class=\"main\">\n";

print "Op deze pagina kunt u de instellingen wijzigen<br><br>";
?>
	<!-- Stukje script dat zorgt dat het form wordt gecontroleerd -->
	<script type="text/javascript">
	$().ready(function() {
		$("#form").validate();
	});
	</script>
	  
	  <form name="form" id="form" method="post" action="index.php">
        <br />
		<p>
			<label for="name">Naam instelling *</label>
			<input id="veld_naam" name="veld_naam" class="required" size="50" maxlength="50" value="<? echo $_SESSION['naam']; ?>" />
        </p>
			<input value="Opslaan" type="submit" />
			<input type="hidden" id="actie" name="actie" value="opslaan" />
	  </form>





<br><br><br>Hieronder staan de velden die er nog bij moeten;<br>
		<p>
			<label for="adres">Straat */ Nr.*/ Toev.</label>
			<input id="straat" name="straat" class="required" size="50" maxlength="50" value="<? echo $_SESSION['straat']; ?>" />
            <input id="nummer" name="nummer" class="required" size="6" maxlength="6" value="<? echo $_SESSION['nummer']; ?>"/>
            <input id="toev" name="toev" class="optioneel" size="6" maxlength="6" value="<? echo $_SESSION['toev']; ?>"/>
		</p>
		<p>
			<label for="pc">Postcode */Plaats *</label>
			<input id="pc" name="pc" class="required" size="7" maxlength="7" value="<? echo $_SESSION['pc']; ?>"/>
            <input id="plaats" name="plaats" class="required" size="50" maxlength="50" value="<? echo $_SESSION['plaats']; ?>"/>
		</p>
        <p>
			<label for="url">Website</label>
			<input id="url" name="url" class="url" size="50" maxlength="50" value="<? echo $_SESSION['url']; ?>" />
        </p>
        <p>
			<label for="email">E-mail *</label>
			<input id="email" name="email" class="required email" size="50" maxlength="50" value="<? echo $_SESSION['email']; ?>" />
        </p>
        <p>
			<label for="kvk">KvK-nummer *</label>
			<input id="kvk" name="kvk" class="required" size="8" minlength="8" maxlength="8" value="<? echo $_SESSION['kvk']; ?>" />
        </p>
        <p>
		  <label for="adres">Contactpersoon *</label>
            <select name="c_aanhef" size="1" class="required" >
              <option value="Heer">De heer</option>
              <option value="Mevrouw">Mevrouw</option>
            </select>
			<input id="c_vnaam" name="c_vnaam" class="required" size="20" maxlength="20" value="<? echo $_SESSION['c_vnaam']; ?>"/>
            <input id="c_tnaam" name="c_tnaam" class="optioneel" size="8" maxlength="8" value="<? echo $_SESSION['c_tnaam']; ?>"/>
            <input id="c_anaam" name="c_anaam" class="required" size="30" maxlength="30" value="<? echo $_SESSION['c_anaam']; ?>"/>
		</p>
        <p>
		<label for="c_tel_1">Telefoon 1 *</label>
		<input id="c_tel_1" name="c_tel_1" class="required" size="12" maxlength="12" value="<? echo $_SESSION['c_tel_1']; ?>" />
		</p>
		<p>
		<label for="c_tel_2">Telefoon 2</label>
		<input id="c_tel_2" name="c_tel_2" class="optioneel" size="12" maxlength="12" value="<? echo $_SESSION['c_tel_2']; ?>" />
		</p>
		<p>
			<label for="c_email">E-mail *</label>
			<input id="c_email" name="c_email" class="required email" size="50" maxlength="50" value="<? echo $_SESSION['c_email']; ?>" />
		</p>
        <p>
			<label for="brin">Brin-nummer *</label>
			<input id="brin" name="brin" class="required" size="8" maxlength="8" value="<? echo $_SESSION['brin']; ?>" />
		</p>
		<p>
			<label for="iban">IBAN *</label>
			<input id="iban" name="iban" class="required" size="18" minlength="18" maxlength="18" value="<? echo $_SESSION['iban']; ?>" />
		</p>
		<p>
			<label for="bic">BIC-code *</label>
			<input id="bic" name="bic" class="required" size="11" minlength="8" maxlength="11" value="<? echo $_SESSION['bic']; ?>" />
		</p>
		<p>
			<label for="kleur_1">Kleur 1 *</label>
			<input id="kleur_1" name="kleur_1" class="required" size="7" maxlength="7" value="<? echo $_SESSION['kleur_1']; ?>" />
		</p>
		<p>
			<label for="kleur_2">Kleur 2 *</label>
			<input id="kleur_2" name="kleur_2" class="required" size="7" maxlength="7" value="<? echo $_SESSION['kleur_2']; ?>" />
		</p>
        <p>
			<input class="knop" type="submit" value="Opslaan"/>
		</p>
        <p>Met de button "Selecteer logo" haalt u allereerst het logo op vanaf uw werkstation. Met de link "Opslaan geselecteerde logo" zet u het logo vervolgens op onze server.</p>
		<p>
            <input id="file_upload" name="file_upload" type="file" size="75"/><br />
            <a href="javascript:$('#file_upload').uploadifyUpload();">Opslaan geselecteerde logo</a>

		</p>

<?
print "</div>\n";

// MENU
print "<div class=\"menu\">\n";

print "</div>\n";

// onderkant 
include ("../beheer_style/style_bottom.php");
?>