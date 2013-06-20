<?
$account = mysql_fetch_array(execQuery($link, "SELECT * FROM accounts WHERE c_email = '$id' AND wachtwoord = '$ww' LIMIT 1"));
if (!$account)
   $bericht                  = 'Logingegevens onbekend';
if ($account[status] == '2')
   $bericht                  = 'Dit account is reeds geactiveerd';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title>Account activeren</title>
  <link href="../css/style_aanmelden_afronden.css" rel="stylesheet" type="text/css"> 
  <script src="http://code.jquery.com/jquery-latest.min.js"></script>
  <script type="text/javascript" src="../js/jquery.form.js"></script>
  <script type="text/javascript" src="../js/jquery.validate.js"></script>
  <script type="text/javascript" src="../js/jquery-ui-1.8.5.custom.min.js"></script>
  <script type="text/javascript" src="../js/jquery.form.wizard.js"></script>
</head>
 <body>
<div id="main" name="main">
	<div id="success">
	  <div id="main_inhoud">
		<?
		if ($bericht != '') {
		   echo $bericht;
		   exit ();
		} else {
		   echo '<B><I>Uw account is bijna geactiveerd!</I></B><br /><br />';
		   echo 'Als eerste voert u hieronder een voor u herkenbaar wachtwoord in, daarna kun u in de beheerfunctie uw overige gegevens aanvullen.';
		}
		?>
		<form id="form" method="post" action="../include/beheer_opslaan_wachtwoord.php">
		<div id="fieldWrapper">
		<span class="step" id="first">		
				<br><br>
				<input type="hidden" id="idopslaan" name="idopslaan" value="<? echo $account[id]; ?>" />
				<label for="ww1">Nieuw wachtwoord</label><br />
				<input class="" name="password" id="password" type="password" size="12" maxlength="12"/><br>
				<label for="ww2">Nogmaals uw wachtwoord</label><br />
				<input class="" name="confirm_password" id="confirm_password" type="password" size="12" maxlength="12" />	 						
		</span>
		</div>
		<div id="demoNavigation">						
			<input class="navigation_button" id="next" value="Opslaan" type="submit" />
		</div>
		</form>
    </div>
  </div>
</div>
    <script type="text/javascript">
			$(function(){
				$("#form").formwizard({ 
				 	formPluginEnabled: true,
				 	validationEnabled: true,
				 	focusFirstInput : true,
				 	formOptions :{
						success: function(data){$("#success").html("Uw wachtwoord is opgeslagen!<br><br>\n<form id=\"form_opgeslagen\" method=\"post\" action=\"../instellingen/\"><input type=\"hidden\" id=\"login_b\" name=\"login_b\" value=\"na_eerste_aanmelding\" /><input class=\"\" id=\"beheer\" value=\"Naar uw eigen omgeving\" type=\"submit\" /></form>")},
						beforeSubmit: function(data){$("#main_inhoud").css({"visibility": "hidden"})},
						dataType: 'json',
						resetForm: true
				 	}, 
					validationOptions : {
						rules: {
							password: {
								required: true,
								minlength: 5
							},
							confirm_password: {
								required: true,
								minlength: 5,
								equalTo: "#password"
							}
						},
						messages: {
							password: {
								required: "Vul een wachtwoord in",
								minlength: "Het wachtwoord moet minimaal 5 tekens lang zijn"
							},
							confirm_password: {
								required: "Vul een wachtwoord in",
								minlength: "Het wachtwoord moet minimaal 5 tekens lang zijn",
								equalTo: "Vul het zelfde wachtwoord in als hierboven"
							}
						}
					}							
				 }
				);
  		});
    </script>
</body>
</html>