
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Onderwijspeiling.nl</title>
  <link href="../beheer_style/include/style.css" rel="stylesheet" type="text/css"> 
	<!--[if lt IE 7]>
	<style media="screen" type="text/css">
	#container {
		height:100%;
	}
	</style>
	<![endif]-->


	<script type="text/javascript">
	$(document).ready(function() {
	$("#tab_proj").removeClass("tab");
	$("#tab_proj").addClass("tab_act");
	$("#proj_aanvragen").removeClass("menu_item");
	$("#proj_aanvragen").addClass("menu_item_act");
	});
	</script>
   <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
  <script src="http://code.jquery.com/jquery-1.9.1.js"></script>
  <script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
</head>
<body>

<div id="menu_back"></div>
<div id="container">

<!-- HEADER -->
<div id="body">


<script type="text/javascript">
	$(function(){

		$("#form").formwizard({ 
			formPluginEnabled: true,
			historyEnabled : true,
			validationEnabled: true,
			formOptions :{
				success: function(data){$("#status").html("<b><i>Uw aanvraag is verzonden! Op de pagina overzicht kunt u de status bekijken!</b></i>")},
				beforeSubmit: function(data){$("#main_inhoud").css({"visibility": "hidden"}),$("#status").html("Uw nieuwe project wordt opgeslagen...").fadeTo(1500,100)},
				dataType: 'json',	
				resetForm: true
			}					
		 }
		);

		$( "#startdatum" ).datepicker({ 
			minDate: -0,
			onSelect: function(dateText, inst) {
				  $("#startdatum_error").html("");
				  $("#startdatum").css("border", "1px solid #abadb3");
				  $("#herinnering_txt").html("Herinnering");
				  $("#einddatum_txt").html("Einddatum");
				  var myDate = $.datepicker.parseDate('dd-mm-yy', dateText);
		   		  var addDays = 10;
				  myDate.setDate(myDate.getDate()+addDays);
				  var newFormat = $.datepicker.formatDate("dd-mm-yy", myDate);
				  $("#herinnering").html(newFormat);
				  var myDate2 = $.datepicker.parseDate('dd-mm-yy', dateText);
		   		  var addDays2 = 21;
				  myDate2.setDate(myDate2.getDate()+addDays2);
				  var newFormat2 = $.datepicker.formatDate("dd-mm-yy", myDate2);
				  $("#einddatum").html(newFormat2);
			 }
		});


				// function for appending step visualization
				function tekst_ophalen(id){
					if (id == "tab_2") {
						 $.post("../include/template_data.php", { template:$('#template').val() }, function(data) {
							 $("#tekst_mail").html(data.mail);
							 $("#tekst_kop").html(data.kop);
							 $("#tekst_dank").html(data.dank);
						 }, "json");
					}
				}

				$("#form").bind("step_shown", function(event, data){
					$.each(data.activatedSteps, function(){
						tekst_ophalen(this)
					});

					
				})



	});
</script>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td class="menu" width="150px">
<!-- MENU -->
		<a class="menu_item" id="proj_overzicht" href="?a=o">Overzicht</a>
		<a class="menu_item" id="proj_aanvragen" href="?a=a">Aanvragen</a>

	</td>
	<td class="main"> 
<!-- MAIN -->
<B>Het aanvragen van een nieuw project</B><br><br>
Via dit programma voert u de gegevens van een nieuw te starten onderzoek in. <br />
Alvorens een onderzoek op te starten dient u allereerst de volgende stappen te doorlopen:<br />
<ul>
<li>Onder het tabje "Vragen" kunt u schoolspecifieke vragen invoeren die u vervolgens in een vragenlijst kunt opnemen.</li>
<li>U kunt onder het tabje "Mailinglijsten" de bestanden met namen en e-mailadressen opnemen</li></ul>
Na het invoeren van de projectgegevens wordt de aanvraag verzonden naar schoolpeiling.nl. <br />Het team van schoolpeiling.nl
controleert uw aanvraag indien alles akkoord is wordt het project gestart op <br />de gewenste startdatum. U krijgt bericht zodra uw aanvraag is goedgekeurd. 
Indien er vragen zijn over de aanvraag neemt een adviseur<br /> van onderwijspeiling.nl telefonisch contact met u op.<br><br>
<div id="step_visualization"></div>
<div id="status"></div>
		<div id="main_inhoud">
			<form id="form" method="post" action="../include/project_opslaan.php" class="bbq">
				<div id="fieldWrapper">

<span class="step" id="tab_1">
<div class="labels">Naam van het onderzoek</div>
	<input class="required" type="text" name="naam_project" id="naam_project" size="40">
<div class="tussenregel"></div>

<div class="labels">Vragenlijst</div>
	<select class="required" name="template" id="template">
	<option value=""></option>
<div class="tussenregel"></div>
		<option value="1">Vragenlijst personeel</option>
		<option value="3">Vragenlijst ouders</option>
		<option value="5">Vragenlijst leerlingen</option>
</select>
<div class="tussenregel"></div>
<!-- <label for="adressenlijst">Eigen vragen toevoegen?</label><br>
	<select class="required" name="pers_vr" id="pers_vr">
	<option value=""></option>
	<option value="1">ja</option>
	<option value="2">nee</option>
</select><br> -->

<div class="labels">E-mail adressen</div>
	<select class="required" name="adressenlijst" id="adressenlijst">
	<option value=""></option>
<div class="tussenregel"></div>
		<option value="4">Ouders</option>
		<option value="5">Leerkrachten</option>
		<option value="6">Leerlingen</option>
		<option value="27">Testje</option>
		<option value="28">Testje</option>
		<option value="29">test</option>
</select>
<div class="tussenregel"></div>
<div class="labels">Startdatum</div>
<input class="required" type="text" name="startdatum" id="startdatum" size="7"><label for="startdatum" style="display: none;" name="startdatum_error" id="startdatum_error" class="error">Verplicht</label><br>
<div class="tussenregel"></div>
<div class="labels"><label for="herinnering" name="herinnering_txt" id="herinnering_txt"></label></div>
<div name="herinnering" id="herinnering"><br></div>
<div class="tussenregel"></div>
<div class="labels"><label for="einddatum" name="einddatum_txt" id="einddatum_txt"></label></div>
<div name="einddatum" id="einddatum"><br></div>
 
<p>Date: <input type="text" id="datepicker" /></p>
</span>

<span class="step" id="tab_2">
  <label for="email_tekst">Tekst voor de e-mail uitnodiging</label><br>
  <textarea class="required" name="tekst_mail" id="tekst_mail" cols="50" rows="12"></textarea><br>
</span>

<span class="step" id="tab_3">
  <label for="email_tekst">Tekst begin vragenlijst</label><br>
  <textarea class="required" name="tekst_kop" id="tekst_kop" cols="50" rows="6"></textarea><br>
  <label for="email_tekst">Tekst bedankt na invullen vragenlijst</label><br>
  <textarea class="required" name="tekst_dank" id="tekst_dank" cols="50" rows="4"></textarea><br>
</span>

<span class="step" id="tab_4">
  <label for="email_tekst">Selecteer uw extra vragenlabel><br>
		<select id="pers_vr[]" name="pers_vr[]" multiple="multiple">
<option value="48">test2</option>
<option value="49">lalala</option>
		</select>
<i>Met de CRT toets kunt u meerdere vragen tegelijk selecteren. Als u geen vraag selecteert komen er geen extra vragen in het project</i>
		<br>
</span>



				</div>
				<div id="project_aanvr_but">
					<BR>
					<input class="navigation_button" id="back" value="Terug" type="reset" />
					<input class="navigation_button" id="next" value="Verder" type="submit" />
				</div>
			</form>
		</div>
	</form>
</div>

</td></tr></table>
</div>

	
</div>
</body>
</html>