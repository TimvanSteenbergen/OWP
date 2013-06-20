<?	
// mail_basis.php	
$headers  = "MIME-Version: 1.0\n";  
$headers .= "Content-type: text/html; charset=iso-8859-1\n";  
$headers .= "From: ".$fromName." <".$fromAddress.">";
//
$message = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
$message .= "<html xmlns=\"http://www.w3.org/1999/xhtml\">\n";
$message .= "<head>\n";
$message .= "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n";
$message .= "<style type=\"text/css\">\n";
$message .= "<!--\n";
$message .= "body {\n";
$message .= "	background-color: white;\n";
$message .= "	margin-left: 20px;\n";
$message .= "	margin-top: 20px;\n";
$message .= "	margin-right: 20px;\n";
$message .= "	margin-bottom: 20px;\n";
$message .= "}\n";
$message .= "A:link { font-size: 12px; color: black ; text-decoration:underline }\n";
$message .= "A:active { font-size: 12px; color: black; text-decoration:underline }\n";
$message .= "A:visited { font-size: 12px; color: black; text-decoration:underline }\n";
$message .= "A:hover { font-size: 12px; color: black; text-decoration:none }\n";
$message .= ".style1 {\n";
$message .= "	font-size: 12px;\n";
$message .= "	color: black;\n";
$message .= "	font-family: Arial, Helvetica, sans-serif;\n";
$message .= "	font-weight:none;\n";
$message .= "}\n";
$message .= ".style2 {\n";
$message .= "	font-weight:bold;\n";
$message .= "	color: black;\n";
$message .= "	font-style: italic; \n";
$message .= "}\n";
$message .= "-->\n";
$message .= "</style></head>\n";
$message .= "\n";
$message .= "<body>\n";
$message .= "<table width=\"80%\" border=\"0\" cellspacing=\"0\" cellpadding=\"5\" align=\"center\">\n";
$message .= "  <tr>\n";
$message .= "    <td bgcolor=\"#FFFFFF\"><img src=\"$home_url/images/logo.png\"/></td>\n";
$message .= "  </tr>\n";
$message .= "  <tr>\n";
$message .= "    <td bgcolor=\"$param_data[kleur_1]\" weight=\"30\">&nbsp;</td></tr>\n";
$message .= "    <tr><td bgcolor=\"#e5e5e5\" style=\"padding:20px;\"><span class=\"style1\">\n";
?>