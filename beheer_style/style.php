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
  <script src="http://code.jquery.com/jquery-latest.min.js"></script>
  <!-- <script src="include/site.js"></script> -->

	<script type="text/javascript">
	$(document).ready(function() {
<? 
	if ($tab_act) { 
		print"	$(\"#$tab_act\").removeClass(\"tab\");\n";
		print"	$(\"#$tab_act\").addClass(\"tab_act\");\n";
	} 
	if ($menu_item_act) { 
		print"	$(\"#$menu_item_act\").removeClass(\"menu_item\");\n";
		print"	$(\"#$menu_item_act\").addClass(\"menu_item_act\");\n";
	} 
?>
	});
	</script>
 
</head>
<body>

<div id="menu_back"></div>
<div id="container">

<!-- HEADER -->
<div id="header">
<div class="logo"><A HREF="../mijnomgeving"><IMG SRC="../images/logo.png" HEIGHT="90" BORDER="0" ALT=""></A></div>
<? if ($hide_tabs_all != 1) { ?>
	<div  class="tabs_all">
	<TABLE>
	<TR>
        <TD><a class="tab" id="tab_inl" href="../mijnomgeving">Voorbereiding</a></TD>	
        <TD><a class="tab" id="tab_ond" href="../onderzoeken">Onderzoeken</a></TD>        
        <TD><a class="tab" id="tab_eig" href="../eigenvragen">Eigen vragen</a></TD>
        <TD><a class="tab" id="tab_mail" href="../mailinglijsten">Mailinglijsten</a></TD>
        <TD><a class="tab" id="tab_proj" href="../projecten">Projecten</a></TD>        
		<TD><a class="tab" id="tab_rap" href="../rapportages">Rapportages</a></TD>
		
	</TR>
	</TABLE>
	</div>
<? } ?>


<? if ($hide_top_logout != 1) { ?>
	<div class="top_logout">
	  <? print "<font color=red><B>$melding</B></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";?>
      <? echo $_SESSION['naam']; ?> <a href="mailto:<? echo $_SESSION['c_email']; ?>" class="orange_link">(<? echo $_SESSION['c_email']; ?>)</a>&nbsp;&nbsp;&nbsp;
      <a href="../instellingen/" class="white_link">Instellingen</a> &nbsp;&nbsp;&nbsp;
      <a href="../uitloggen" class="white_link">Uitloggen</a><br /><br /><br />
	</div>
<? } ?>
</div>
<div id="body">