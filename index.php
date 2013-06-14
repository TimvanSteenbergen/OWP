<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Onderwijspeiling.nl</title>
<link href="css/main_style.css" rel="stylesheet" type="text/css"> 
<link href="css/fade.css" rel="stylesheet" type="text/css"> 
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script src="js/main_site.js"></script>

    <script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" src="js/jquery.form.js"></script>
    <script type="text/javascript" src="js/jquery.validate.js"></script>
    <script type="text/javascript" src="js/bbq.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.8.5.custom.min.js"></script>
    <script type="text/javascript" src="js/jquery.form.wizard.js"></script>
    
    <script type="text/javascript">
		$(function(){
			<? if ($l=="a") { ?>
					var popID = 'login_form'; //Get Popup Name
					var popWidth = 400; //Gets the first query string value
					$('#' + popID).fadeIn().css({ 'width': Number( popWidth ) }).prepend('<a href="#" class="close"><img src="images/close.png" class="btn_close" title="Sluiten" alt="Sluiten" border="0"></a>');
					var popMargTop = ($('#' + popID).height() + 80) / 2;
					var popMargLeft = ($('#' + popID).width() + 80) / 2;
					$('#' + popID).css({
						'margin-top' : -popMargTop,
						'margin-left' : -popMargLeft
					});
					$('body').append('<div id="fade"></div>'); //Add the fade layer to bottom of the body tag.
					$('#fade').css({'filter' : 'alpha(opacity=80)'}).fadeIn(); //Fade in the fade layer - .css({'filter' : 'alpha(opacity=80)'}) is used to fix the IE Bug on fading transparencies 
			<?}?>

				$("#brin").bind("change", function(e){
				  $.getJSON("include/haal_brin.php?brin=" + $("#brin").val(),
						function(data){
						  $.each(data, function(i,item){
							if (item.field == "school_naam") {
								if (item.value == "error") {
									$("#school_naam").html("Ongeldig BRIN nummer");
									$("#school_naam").css({"color": "red"});
									$("#brin").val("")
								} else {
									$("#school_naam").html(item.value);
									$("#school_naam").css({"color": "#9b9b9b"});
								}
							} else 
							   if (item.field == "school_plaats") {
							      $("#school_plaats").html(item.value);
							    }
							   else
							      if (item.field == "school_adres") {
							         $("#school_adres").html(item.value);
							    }
						  });
						});
				});

				$("#form").formwizard({ 
				 	formPluginEnabled: true,
				 	historyEnabled : false,
				 	validationEnabled: true,
				 	formOptions :{
						success: function(data){$("#status").html("Bedankt voor uw aanmelding!<br><br>U ontvangt een e-mail met verdere instructies.<br><br><a href=\"#\" class=\"close\">Sluiten</a>").fadeTo(500, 1)},
						beforeSubmit: function(data){
							$("#registreer_form_txt").css({"visibility": "hidden"})
							$("#status").html("Uw registratie wordt opgeslagen...")
						},
						dataType: 'json',	
						resetForm: true
				 	}						
				 }
				);
				
				$("#formc").formwizard({ 
				 	formPluginEnabled: true,
				 	historyEnabled : false,
				 	validationEnabled: true,
				 	formOptions :{
						success: function(data){$("#statusc").html("Bedankt voor uw contactaanvraag!<br><br>Wij nemen binnen 1 werkdag contact met u op.<br><br><a href=\"#\" class=\"close\">Sluiten</a>").fadeTo(500, 1)},
						beforeSubmit: function(data){$("#contact_form_txt").css({"visibility": "hidden"})},	
						resetForm: true
				 	}						
				 }
				);

				$("#login_form").submit(function()
				{
					//remove all the class add the messagebox classes and start fading
					$("#msgbox").removeClass().addClass('messagebox').text('Controleren....').fadeIn(1000);
					//check the username exists or not from ajax
					$.post("include/login.php?login_a=check_user",{ user_name:$('#username').val(),password:$('#password').val(),rand:Math.random() } ,function(data)
					{
					  if(data=='yes') //if correct login detail
					  {
						$("#msgbox").fadeTo(200,0.1,function()  //start fading the messagebox
						{ 
						  //add message and change the class of the box and start fading
						  $(this).html('Inloggen.....').addClass('messageboxok').fadeTo(900,1,
						  function()
						  { 
							 //redirect to secure page
							 document.location='mijnomgeving/?l=d';
						  });
						  
						});
					  }
					  else 
					  {
						$("#msgbox").fadeTo(200,0.1,function() //start fading the messagebox
						{ 
						  //add message and change the class of the box and start fading
						  $("#username").val("")
						  $("#password").val("")
						  $(this).html('Foute inloggegevens!').addClass('messageboxerror').fadeTo(900,1);
						});		
					  }
							
					});
					return false; //not to post the  form physically
				});
				//now call the ajax also focus move from 
				$("#password").blur(function()
				{
					$("#login_form").trigger('submit');
				});
  		});
    
//Issue "voorkom aanmelding met een al bestaand emailadres"
				//bind callback to the before_remote_ajax event
				$("#form").bind("before_remote_ajax", function(event, data){
					alert("triggered by the before_remote_ajax event on step: " + data.currentStep);
				})
				//bind callback to the after_remote_ajax event
				$("#form").bind("after_remote_ajax", function(event, data){
					alert("triggered by the after_remote_ajax event on step: " + data.currentStep);
				})
				
							
				$("#form").formwizard({ 
				 	formPluginEnabled: true,
				 	validationEnabled: true,
				 	focusFirstInput : true,
				 	remoteAjax : {"contact_form" : { // add a remote ajax call when moving next from the second step
				 		url : "/vragenlijst/examples/validate.html", 
				 		dataType : 'json',
				 		beforeSend : function(){alert("Starting validation.")},
				 		complete : function(){alert("Validation complete.")},
				 		success : function(data){
				 			if(data.emailtaken){ // change this value to false in validate.html to simulate successful validation
					 			$("#status").fadeTo(500,1,function(){
					 				$(this).html(data.emailerrormessage).fadeTo(5000, 0) 
					 			}); 
				 				return false; //return false to stop the wizard from going forward to the next step (this will always happen)
				 			}
				 			return true; //return true to make the wizard move to the next step
				 		}
				 	}},
				 	formOptions :{
						success: function(data){$("#status").fadeTo(500,1,function(){ $(this).html("You are now registered!").fadeTo(5000, 0); })},
						beforeSubmit: function(data){$("#data").html("data sent to the server: " + $.param(data));},
						dataType: 'json',
						resetForm: true
				 	}
				 }
				);
//Einde Issue "voorkom aanmelding met een al bestaand emailadres"   
//Issue "Wachtwoord vergeten"
				//bind callback to the before_remote_ajax event
				$("#formw").bind("before_remote_ajax", function(event, data){
					alert("triggered by the before_remote_ajax event on step: " + data.currentStep);
				})
				//bind callback to the after_remote_ajax event
				$("#formw").bind("after_remote_ajax", function(event, data){
					alert("triggered by the after_remote_ajax event on step: " + data.currentStep);
				})
				
							
				$("#formw").formwizard({ 
				 	formPluginEnabled: true,
				 	validationEnabled: true,
				 	focusFirstInput : true,
				 	remoteAjax : {"first" : { // add a remote ajax call when moving next from the first step
				 		url : "/vragenlijst/examples/validate.html", 
				 		dataType : 'json',
				 		beforeSend : function(){alert("Starting validation.")},
				 		complete : function(){alert("Validation complete.")},
				 		success : function(data){
				 			if(data.emailtaken){ // change this value to false in validate.html to simulate successful validation
					 			$("#status").fadeTo(500,1,function(){
					 				$(this).html(data.emailerrormessage).fadeTo(5000, 0) 
					 			}); 
				 				return false; //return false to stop the wizard from going forward to the next step (this will always happen)
				 			}
				 			return true; //return true to make the wizard move to the next step
				 		}
				 	}},
				 	formOptions :{
						success: function(data){$("#status").fadeTo(500,1,function(){ $(this).html("You are now registered!").fadeTo(5000, 0); })},
						beforeSubmit: function(data){$("#data").html("data sent to the server: " + $.param(data));},
						dataType: 'json',
						resetForm: true
				 	}
				 }
				);
//Einde Issue "Wachtwoord vergeten"   
    </script>

</head>

<body>
<!-- main -->
<div class="main">
	<div class="logo"><IMG SRC="images/logo.png" HEIGHT="90" BORDER="0" ALT=""></div>
	<a href="#" class="poplight login"      rel="login_form"      id="login"><IMG SRC="images/login.png" WIDTH="24" HEIGHT="24" BORDER="0" ALT="">Login</a>
	<a href="#" class="poplight registreer" rel="registreer_form" id="registreer"><IMG SRC="images/registreer.png" HEIGHT="24" BORDER="0" ALT="">Registreer</a>
	<a href="#" class="poplight contact"    rel="contact_form"    id="contact"><IMG SRC="images/contact.png" HEIGHT="24" BORDER="0" ALT="">Contact</a>
	<div class="infobox infobox1" id="infobox1"><strong>Tevredenheidsonderzoeken</strong><br />
	Tevredenheidsonderzoeken zijn een krachtig middel om er achter te komen hoe de ouders van uw kinderen, de kinderen zelf en de leerkrachten waarderen hoe de school bezig is. Een onderzoek geeft een doorkijkje in afwegingen die ouders maken, in de sterke en zwakke punten van school door de bril van de leerkrachten en in de ervaringen van kinderen. Voor een moderne professionele organisatie is een periodiek onderzoek onontbeerlijk om de prioriteiten juist te stellen. <br><a href="#" rel="pop_1" class="poplight lees_verder">Lees verder</a>
	</div>
	<div class="infobox infobox2" id="infobox2"><strong>Onderwijspeiling.nl</strong><br />
Onderwijspeiling.nl biedt u de mogelijkheid om een gedegen onderzoek af te nemen onder alle stakeholders (ouders, kinderen, leerkrachten) waarbij er uitgebreide mogelijkheid is voor het toetsen van schoolspecifieke zaken. Onderwijspeiling.nl werkt volledig webbased en levert u in weinig tijd heel veel waardevolle informatie. Informatie die door uzelf verwerkt kan worden in een schoolplan maar waar wij u uiteraard ook over kunnen adviseren. <br><br><a href="#" rel="pop_2" class="poplight lees_verder">Lees verder</a>
</div>
	<div class="infobox infobox3" id="infobox3"><strong>Hoe het werkt</strong><br />
Na het aanvragen van een toegangscode krijgt u een webruimte voor het opzetten van uw onderzoek. U kunt dan via een gebruikersvriendelijke interface uw schoolgegevens completeren ten behoeve van de benchmark, uw specifieke vragen toevoegen aan de database en de deelnemers aan de verschillende onderzoeken toevoegen. Na het aanvragen van een onderzoek start het team van onderwijspeiling.nl het project en controleert de voortgang. <br><a href="#" rel="pop_3" class="poplight lees_verder">Lees verder</a>
</div>
	<div class="infobox_klein infobox4" id="infobox4"><div class="promo_tekst">"Degelijk, diepgaand, makkelijk"</div><div class="promo_tekst_van"></div></div>
	<div class="infobox_klein infobox5" id="infobox5"><div class="promo_tekst">"Goede workshop"</div><div class="promo_tekst_van"></div></div>
	<div class="infobox_klein infobox6" id="infobox6"><div class="promo_tekst">"Verrassend beeld uit kindonderzoek"</div><div class="promo_tekst_van"></div></div>
	<div class="infobox_klein infobox7" id="infobox7"><div class="promo_tekst">"Nieuwe verbeterpunten gevonden"</div><div class="promo_tekst_van"></div></div>
	<div class="infobox_klein infobox8" id="infobox8"><div class="promo_tekst">"We gaan dit elk jaar herhalen"</div><div class="promo_tekst_van"></div></div>

<!-- popup's -->
<div id="pop_1" class="popup_block">
	<div class="popup_block_txt"><strong>Tevredenheidsonderzoeken</strong><br />
	Via benchmarking met andere scholen uit een vergelijkbare groep of regio kunnen conclusies getrokken worden hoe de school er ten opzichte van de concurrentie voorstaat. In deze tijd van teruglopende financiering vanuit de overheid moet alles uit de kast gehaald worden om de zittende populatie kinderen te behouden en waar mogelijk nieuwe aan te trekken.<br><br><a href="#" class="close">Sluiten</a></div>
</div>
<div id="pop_2" class="popup_block">
	<div class="popup_block_txt"><strong>Onderwijspeiling.nl</strong><br />
	De achtergrond van onderwijspeiling.nl wordt gevormd door een uitgebreide ervaring in onderwijsbestuur waardoor de resultaten van een onderzoek snel bruikbaar zijn voor de deelnemende scholen. Rapportages die er duidelijke uitzien en u het inzicht geven dat u wenst.<br><br><a href="#" class="close">Sluiten</a></div>
</div>
<div id="pop_3" class="popup_block">
	<div class="popup_block_txt"><strong>Hoe werkt het</strong><br />
	Na afloop van het onderzoek stellen wij uw rapportage samen en kunnen we desgewenst met u een workshop houden om de resultaten van het onderzoek te vertalen in concrete acties.<br /><br />
    Er worden de volgende onderzoeken onderscheiden:<br />
    <ul>
     <li>Ouderpeiling &euro; 300,-</li>
     <li>Leerlingenpeiling &euro; 250,-</li>
     <li>Leerkrachtenpeiling &euro; 325,-</li>
     <li>Combinatieprijs 3 onderzoeken &euro; 750,-</li>
    </ul>
    <br />
    En daarnaast:<br />
    <ul>
     <li>Assistentie bij opzetten onderzoek &euro; 100,-</li>
     <li>Opzetten afwijkende referentiegroep &euro; 200,-</li>
     <li>Bovenschoolse rapportage &euro; 475,- per bestuur</li>
     <li>workshop beoordeling resultaten &euro; 650,-</li>
    </ul>
    <br>
    Bovengenoemde prijzen zijn exclusief BTW.
    <br /><br /><a href="#" class="close">Sluiten</a></div>
</div>

<div class="popup_block" id="login_form">
  <div class="popup_block_txt">
	<form method="post" class="cmxform" id="login_form" action="include/login_check.php">
		<TABLE cellpadding="0" cellspacing="5" border="0" width="410">
		<TR>
			<TD width="75"><label for="user">Gebruiker*</label></TD>
			<TD><input name="username" type="text" id="username" value="" /></TD>
		</TR>
		<TR>
			<TD><label for="pass">Wachtwoord*</label></TD>
			<TD> <input name="password" type="password" id="password" value="" maxlength="20" /></TD>
		</TR>
		<TR>
			<TD colspan="2"><input class="submit" type="submit" value="Inloggen"/><span id="msgbox" style="display:none"></span></TD>
		</TR>
		<TR>
			<TD colspan="2" align=""><a href="#" class="poplight" rel="wachtwoordvergeten_form" id="login_wachtwoord_vergeten">Wachtwoord vergeten?</A></TD>
		</TR>
		</TABLE>
	</form>
  </div>
</div>

<div class="popup_block" id="contact_form">
	<div id="statusc" class="popup_block_txt"></div>
	<div class="popup_block_txt" id="contact_form_txt">
	<form id="formc" method="post" action="include/contact.php">
		<b>Contactformulier</b><br>
		Vult u onderstaand formulier in en wij nemen binnen 24 contact met u op.<br><br>
        <span class="step" id="first">
        	<label for="naam">School</label><br />
			<input class="required" name="school" id="school" size="30" maxlength="50"/><br />
			<label for="naam">Naam</label><br />
			<input class="required" name="naam" id="naam" size="30" maxlength="50"/><br />
            <label for="tel">Telefoon</label><br />
		    <input class="required" name="tel" id="tel"size="14" maxlength="12" /><br />
            <label for="email">E-mail</label><br />
		    <input class="required" name="email" id="email"size="30" maxlength="50" /><br />
            <label for="vraag">Uw vraag</label><br />
            <textarea class="required" name="vraag" id="vraag" rows="4" cols="23"></textarea><br /><br />
            <label for="kopiemail">Stuur mij een kopie</label>	
            <input name="kopiemail" type="checkbox" value="1" checked /> 	
        </span>					
		<div id="demoNavigation">						
			<input class="navigation_button" id="next" value="Verstuur" type="submit" />
		</div>
	</form>
	</div>
</div>

<div class="popup_block" id="wachtwoordvergeten_form">
	<div id="status" class="popup_block_txt"></div>
	<div class="popup_block_txt" id="wachtwoordvergeten_form_txt">
	<form id="formw" method="post" action="include/wachtwoord_wijzigen.php">
		<b>Wachtwoord vergeten?</b><br>
		Door hier uw email-adres in te geven en op verzenden te klikken, krijgt u een nieuw wachtwoord toegestuurd via mail.<br><br>
		<span class="step" id="first">
			<label for="email">Email</label><br />
			<input class="email required" name="email" id="email" size="38" maxlength="50" /><br />
		</span>
		<div id="demoNavigation">						
			<input class="navigation_button" id="next" value="Verstuur" type="submit" />
		</div>
	</form>
	</div>
</div>

<div class="popup_block" id="registreer_form">
	<div id="status" class="popup_block_txt"></div>
	<div class="popup_block_txt" id="registreer_form_txt">
	<form id="form" method="post" action="include/aanmelden_opslaan.php">
		<b>Aanmaken account</b><br>
		Via onderstaand formulier voltooit u het eerst deel van uw aanmelding. Door het ingeven van het BRIN-nummer haalt u de gegevens van uw school op. <br><br>
		<span class="step" id="first">
			<label for="brin">BRIN-nummer school</label><br />
			<input class="required" name="brin" id="brin" size="6" maxlength="4"/><br>
			<label class="brin_tekst" id="school_naam"></label><br>
            <label class="brin_tekst" id="school_adres"></label>
			<label class="brin_tekst" id="school_plaats"></label><br>
			<label for="aanhef">Contactpersoon</label><br>
			<select class="required" name="aanhef" id="aanhef">
			<option value=""></option>
			<option value="De heer">De heer</option>
			<option value="Mevrouw">Mevrouw</option>
			</select><br>
			<label for="voornaam">Voornaam</label><br />
			<input class="required" name="voornaam" id="voornaam" size="17" maxlength="15"/><br />
			<label for="tussennaam">Tussenvoegsel</label><br />
			<input name="tussennaam" class="" id="tussennaam" size="10" maxlength="8" /><br />
			<label for="achternaam">Achternaam</label><br />
			<input class="required" name="achternaam" id="achternaam" size="32" maxlength="30"/><br />
			<label for="email">Email</label><br />
			<input class="email required" name="email" id="email" size="38" maxlength="50" /><br />
            <label for="tel">Telefoon</label><br />
		    <input class="required" name="tel" id="tel"size="14" maxlength="12" />	 						
		</span>
		<div id="demoNavigation">						
			<input class="navigation_button" id="next" value="Verstuur" type="submit" />
		</div>
	</form>
	</div>
</div>

</body>
</html>
