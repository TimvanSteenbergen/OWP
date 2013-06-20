<?
//BEVEILIGING
include("../include/login.php");

$bericht = 'Op deze pagina kunt u de instellingen wijzigen<br><br>';
//code voor opslaan instellingen
if ($actie == "opslaan") {
	$db_id        = $_SESSION['id'];
	//$veld_kleur_1 = substr($veld_kleur_1, 1);
	$result = execQuery($link, "UPDATE accounts SET naam     = '$veld_naam' ,
	                                                straat   = '$veld_straat',
													nummer   = '$veld_nummer',
													pc       = '$veld_pc',
													plaats   = '$veld_plaats',
													tel      = '$veld_tel',
													email    = '$veld_email',
													kvk      = '$veld_kvk',
													kleur_1  = '',
													url      = '$veld_url',
													c_aanhef = '$veld_c_aanhef',
													c_vnaam  = '$veld_c_vnaam',
													c_tnaam  = '$veld_c_tnaam',
													c_anaam  = '$veld_c_anaam',
													c_tel    = '$veld_c_tel',
													c_email  = '$veld_c_email' WHERE `id` = $db_id LIMIT 1;");
	$_SESSION['naam']       = $veld_naam; 
	$_SESSION['straat']     = $veld_straat;
	$_SESSION['nummer']     = $veld_nummer;
	$_SESSION['pc']         = $veld_pc;
	$_SESSION['plaats']     = $veld_plaats;
	$_SESSION['tel']        = $veld_tel;
	$_SESSION['email']      = $veld_email;
	$_SESSION['kvk']        = $veld_kvk;
	// $_SESSION['iban']       = $veld_iban;
	// $_SESSION['bic']        = $veld_bic;
	$_SESSION['logo']       = $veld_logo;
	$_SESSION['kleur_1']    = $veld_kleur_1;
	// $_SESSION['kleur_2']    = $veld_kleur_2;
	//if ($_SESSION['kleur_1'] == '')
	//    $_SESSION['kleur_1'] = 'e5e5e5';
	//if ($_SESSION['kleur_2'] == '')
	//    $_SESSION['kleur_2'] = 'e5e5e5';
	$_SESSION['url']        = $veld_url;
	$_SESSION['c_aanhef']   = $veld_c_aanhef;
	$_SESSION['c_vnaam']    = $veld_c_vnaam;
	$_SESSION['c_tnaam']    = $veld_c_tnaam;
	$_SESSION['c_anaam']    = $veld_c_anaam;
	$_SESSION['c_tel']      = $veld_c_tel;
	$_SESSION['c_email']    = $veld_c_email;
	//
	$bericht = 'Uw instellingen zijn opgeslagen.<br /><br />';
}


//bovenkant stijl
include ("../beheer_style/style.php");
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td class="menu" width="150px">
<!-- MENU -->


	</td>
	<td class="main"> 
<!-- MAIN -->
<?

print $bericht;
?>  
	<!-- Stukje script dat zorgt dat het form wordt gecontroleerd -->
	<script type="text/javascript">
	  $().ready(function() {
		  $("#form").validate();
	  });
	</script>
  <!-- stukje script voor de kleurpicker -->
    <link type="text/css" rel="stylesheet" href="../jpicker/jPicker.css" />
    <link type="text/css" rel="stylesheet" href="../jpicker/css/jPicker-1.1.6.css" />
    <script src="../jpicker/jquery-1.4.4.min.js" type="text/javascript"></script> 
    <script src="../jpicker/jpicker-1.1.6.js" type="text/javascript"></script>
      <script type="text/javascript">
    $(function()
      {
        $.fn.jPicker.defaults.images.clientPath='../jpicker/images/';
        var LiveCallbackElement = $('#Live'),
            LiveCallbackButton = $('#LiveButton');
        $('#Inline').jPicker({window:{title:'Inline Example'}});
        $('#Expandable').jPicker({window:{expandable:true,title:'Expandable Example'}});
        $('#Alpha').jPicker({window:{expandable:true,title:'Alpha (Transparency) Example)',alphaSupport:true},color:{active:new $.jPicker.Color({ahex:'99330099'})}});
        $('#Binded').jPicker({window:{title:'Binded Example'},color:{active:new $.jPicker.Color({ahex:'993300ff'})}});
        $('.Multiple').jPicker({window:{title:'Multiple Binded Example'}});
        $('#Callbacks').jPicker(
          {window:{title:'Callback Example'}},
          function(color, context)
          {
            var all = color.val('all');
            alert('Color chosen - hex: ' + (all && '#' + all.hex || 'none') + ' - alpha: ' + (all && all.a + '%' || 'none'));
            $('#Commit').css({ backgroundColor: all && '#' + all.hex || 'transparent' });
          },
          function(color, context)
          {
            if (context == LiveCallbackButton.get(0)) alert('Color set from button');
            var hex = color.val('hex');
            LiveCallbackElement.css({ backgroundColor: hex && '#' + hex || 'transparent' });
          },
          function(color, context)
          {
            alert('"Cancel" Button Clicked');
          });
        $('#LiveButton').click(
          function()
          {
            $.jPicker.List[7].color.active.val('hex', 'e2ddcf', this);
          });
        $('#AlterColors').jPicker({window:{title:'Color Interaction Example'}});
        $('#GetActiveColor').click(
          function()
          {
            alert($.jPicker.List[8].color.active.val('ahex'));
          });
        $('#GetRG').click(
          function()
          {
            var rg=$.jPicker.List[8].color.active.val('rg');
            alert('red: ' + rg.r + ', green: ' + rg.g);
          });
        $('#SetHue').click(
          function()
          {
            $.jPicker.List[8].color.active.val('h', 133);
          });
        $('#SetValue').click(
          function()
          {
            $.jPicker.List[8].color.active.val('v', 38);
          });
        $('#SetRG').click(
          function()
          {
            $.jPicker.List[8].color.active.val('rg', { r: 213, g: 118 });
          });
      });
  </script>

  <!-- Stukje script om logo te kunnen uploaden 
    <script type="text/javascript" src="../uploadify/jquery-1.4.2.min.js"></script> 
    <link type="text/css" rel="stylesheet" href="../uploadify/uploadify.css" />
    <script type="text/javascript" src="../uploadify/jquery.uploadify.v2.1.4.min.js"></script>
    <script type="text/javascript" src="../uploadify/swfobject.js"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $('#file_upload').uploadify({
          'uploader'  : '../uploadify/uploadify.swf',
          'script'    : '../uploadify/uploadify.php',
		  'cancelImg' : '../uploadify/cancel.png',
		  'fileExt'   : '*.jpg;*.gif;*.png',
		  'fileDesc'  : 'Bestanden (.JPG, .GIF, .PNG)',
		  'buttonText': 'Selecteer logo',
		  'sizeLimit' : '151200',
          'folder'    : '/logos',
		  'onComplete': function(a, b, c, d, e){
                    if (d !== '1')
                        {
                        alert(d);
                        }
                    else
                        {
                        alert('Filename: ' + c.name + ' was uploaded');
                        }
                  },
		  'auto'      : true,
        });
      });
    </script>
-->	  
	  <form name="form" id="form" method="post" action="index.php?actie=opslaan">
        <br />
		<table width="50%" border="0">
        <tr>
        <td width="20%">Naam instelling *</td>
        <td width="80%"><input class="required" id="veld_naam" name="veld_naam" size="50" maxlength="50" value="<? echo $_SESSION['naam']; ?>" /></td>
        </tr><tr>
        <td>Straat*/Nr.*</td>
        <td><input id="veld_straat" name="veld_straat" class="required" size="50" maxlength="50" value="<? echo $_SESSION['straat']; ?>" />
            <input id="veld_nummer" name="veld_nummer" class="required" size="7" maxlength="6" value="<? echo $_SESSION['nummer']; ?>"/></td>
        </tr><tr>
        <td>Postcode*/Plaats*</td>
        <td><input id="veld_pc" name="veld_pc" class="required" size="7" maxlength="7" value="<? echo $_SESSION['pc']; ?>"/>
            <input id="veld_plaats" name="veld_plaats" class="required" size="50" maxlength="50" value="<? echo $_SESSION['plaats']; ?>"/></td>
        </tr><tr>
        <td>Website*</td>
        <td><input id="veld_url" name="veld_url" class="url" size="50" maxlength="50" value="<? echo $_SESSION['url']; ?>" /></td>
        </tr><tr>
        <td>E-mail school*</td>
        <td><input id="veld_email" name="veld_email" class="required email" size="50" maxlength="50" value="<? echo $_SESSION['email']; ?>" /></td>
        </tr><tr>
        <td>KvK-nummer</td>
        <td><input id="veld_kvk" name="veld_kvk" class="" size="11" minlength="8" maxlength="8" value="<? echo $_SESSION['kvk']; ?>" /></td>
        </tr><tr>
        <td>Contactpersoon*</td>
        <td><select name="veld_c_aanhef" size="1" class="required" >
              <option value="De heer" <? if ($_SESSION['c_aanhef'] == "De heer") { ?> selected="selected" <? } ?>>De heer</option>
              <option value="Mevrouw" <? if ($_SESSION['c_aanhef'] == "Mevrouw") { ?> selected="selected" <? } ?>>Mevrouw</option>
            </select>
			<input id="veld_c_vnaam" name="veld_c_vnaam" class="required" size="10" maxlength="20" value="<? echo $_SESSION['c_vnaam']; ?>"/>
            <input id="veld_c_tnaam" name="veld_c_tnaam" class="optioneel" size="8" maxlength="8" value="<? echo $_SESSION['c_tnaam']; ?>"/>
            <input id="veld_c_anaam" name="veld_c_anaam" class="required" size="25" maxlength="30" value="<? echo $_SESSION['c_anaam']; ?>"/></td>
        </tr><tr>
        <td>Telefoon*</td>
        <td><input id="veld_c_tel" name="veld_c_tel" class="required" size="12" maxlength="12" value="<? echo $_SESSION['c_tel']; ?>" /></td>
        </tr><tr>
        <td>E-mail*</td>
        <td><input id="veld_c_email" name="veld_c_email" class="required email" size="50" maxlength="50" value="<? echo $_SESSION['c_email']; ?>" /></td>
        </tr>
        </table><br />
        <input value="Opslaan" type="submit" class="submit"/>
			<input type="hidden" id="actie" name="actie" value="opslaan" />
	  </form>
<!-- voorlopig even niet logo uploaden
        <p>Onderstaand kunt u een eigen logo selecteren en op onze server zetten. Dit logo wordt gebruikt om e-mails<br /> en vragenlijsten herkenbaar te presenteren. Met de button "Selecteer logo" haalt u het logo<br /> op vanaf uw werkstation. Indien het logo aan de gestelde voorwaarden voldoet wordt het meteen op<br />onze server gezet.</p>
		<p>
            <input id="file_upload" name="Filedata" type="file"/>
		</p>
-->
<?
print "</div>\n";

// onderkant 
include ("../beheer_style/style_bottom.php");
?>