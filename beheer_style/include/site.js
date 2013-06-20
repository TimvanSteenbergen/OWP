$(document).ready(function() {

//start functions
	$(".main").load("start.html");
//	$(".menu").load("menu.php?i=start");
//	$("#tab_proj").removeClass("tab");
//	$("#tab_proj").addClass("tab_act");


//functions
	$.tab_wissel = function(actief)
    {
		if ($('#tab_proj').hasClass('tab_act')) {
			$("#tab_proj").removeClass("tab_act");
			$("#tab_proj").addClass("tab");
		}
		if ($('#tab_rap').hasClass('tab_act')) {
			$("#tab_rap").removeClass("tab_act");
			$("#tab_rap").addClass("tab");
		}
		if ($('#tab_mail').hasClass('tab_act')) {
			$("#tab_mail").removeClass("tab_act");
			$("#tab_mail").addClass("tab");
		}
		if ($('#tab_beh').hasClass('tab_act')) {
			$("#tab_beh").removeClass("tab_act");
			$("#tab_beh").addClass("tab");
		}
		$(actief).removeClass("tab");
		$(actief).addClass("tab_act");
    }

	$.menu_act = function(actief)
    {
		$('a').removeClass('menu_item_act')
//		$(actief).removeClass("menu_item")
		$(actief).addClass("menu_item_act");
    }

	$.laden = function(pagina)
    {
		$(".main").empty().html('<img src="images/loading.gif" />');
		$(".main").load(pagina);
	}

//projecten
	$("#tab_proj").click(function(){
		$.tab_wissel("#tab_proj");
		$(".menu").load("menu.php?i=proj", function() {
			$.menu_act("#proj_overzicht");	
			$("#proj_overzicht").click(function(){
				$.laden("projecten.php?i=overzicht");
				$.menu_act("#proj_overzicht");
			});
			$("#proj_aanmaken").click(function(){
				$.laden("projecten.php?i=aanmaken");
				$.menu_act("#proj_aanmaken");
			});
			$("#proj_wijzigen").click(function(){
				$.laden("projecten.php?i=wijzigen");
				$.menu_act("#proj_wijzigen");
			});	
			$.laden("projecten.php");
		});	
	});
	
//rapportages	
	$("#tab_rap").click(function(){
		$.tab_wissel("#tab_rap");
		$(".menu").load("menu.php?i=rap", function() {
			$.menu_act("#rap_totaal");	
			$("#rap_totaal").click(function(){
				$.laden("rapportages.php?i=Totaal");
				$.menu_act("#rap_totaal");
			});
			$("#rap_branche").click(function(){
				$.laden("rapportages.php?i=Branche");
				$.menu_act("#rap_branche");
			});
			$("#rap_maand").click(function(){
				$.laden("rapportages.php?i=Maand");
				$.menu_act("#rap_maand");
			});
			$("#rap_jaar").click(function(){
				$.laden("rapportages.php?i=Jaar");
				$.menu_act("#rap_jaar");
			});
			$.laden("rapportages.php");
		});	
	});

	
	
	$("#tab_mail").click(function(){
		$.tab_wissel("#tab_mail");
		$(".menu").load("menu.php?i=mail", function() {
			$.menu_act("#mail_overzicht");	
			$("#mail_overzicht").click(function(){
				$.laden("mailinglijsten.php?i=Overzicht");
				$.menu_act("#mail_overzicht");
			});
			$("#mail_nieuw").click(function(){
				$.laden("mailinglijsten.php?i=Nieuw");
				$.menu_act("#mail_nieuw");
			});
			$.laden("mailinglijsten.php");
		});	
	});

	$("#tab_beh").click(function(){
		$.tab_wissel("#tab_beh");
		$(".menu").load("menu.php?i=beh", function() {
			$.menu_act("#beh_teksten");	
			$("#beh_teksten").click(function(){
				$.laden("beheer.php?i=Teksten");
				$.menu_act("#beh_teksten");
			});
			$("#beh_vragen").click(function(){
				$.laden("beheer.php?i=Vragen");
				$.menu_act("#beh_vragen");
			});
			$.laden("beheer.php");
		});	

	});


});