<?
include("../include/functions.php");
$result = execQuery($link, "UPDATE projecten SET status = '2' WHERE `id` = $db_id LIMIT 1;");
print "Project met id $db_id is nu actief!";
// mail sturen naar contacptersoon school om aan te geven dat project loopt.
$result = execQuery($link, "SELECT * FROM projecten WHERE id = $db_id LIMIT 1");
$row_prj  = mysql_fetch_array($result);
$result   = execQuery($link, "SELECT * FROM accounts WHERE id = $row_prj[account_id] LIMIT 1");
$row_acc  = mysql_fetch_array($result);
$result   = execQuery($link, "SELECT * FROM param WHERE id = '1' LIMIT 1");
$param_data  = mysql_fetch_array($result);
$username = $row_acc['c_vnaam'].' '.$row_acc['c_tnaam'].' '.$row_acc['c_anaam'];
$fromName    = $username; 
$fromAddress = $_SESSION['c_email']; 
include_once '../include/mail_basis.php';
$message .= "Hierbij ontvangt u de bevestiging dat het onderstaande project is goedgekeurd en gestart<br /><br />";
$message .= "School: ".$row_acc['naam']."<br />";
$message .= "Naam: ".$row_prj['naam']."<br />";
$message .= "Startdatum: ".$row_prj['dd_start']."<br />";
$message .= "Einddatum: ".$row_prj['dd_eind']."<br />";
$message .= "Herinnering: ".$row_prj['dd_herin']."<br />";
$message .= "<br /><br />";
$message .= "Met vriendelijke groet,<br /><br />";
$message .= "Het team van ".$param_data[naam];
$message .= "</td></tr>\n";
$message .= "</table>\n";
$message .= "</body>\n";
$message .= "</html>\n";
//
$mail     = 'mbeukenkamp@gmail.com';
$subject  = "Project goedgekeurd ".$row_prj['naam'];	
//print $message;
mail($username." <".$mail.">",$subject, $message, $headers);
$mail     = $param_data['email'];
mail($username." <".$mail.">",$subject, $message, $headers);
?>