<? 
// include/contact.php
// 1. versturen ingevuld contactformulier naar info-adres
// 2. indien gewenst kopie naar verzender
include_once 'functions.php';
//
$fromName    = $param[naam]; 
$fromAddress = $param[email]; 
include_once 'mail_basis.php';
$message .= "Er is een contactaanvraag gedaan op ".$param[naam].". Hieronder staan de gegevens van de aanvrager vermeld.<br /><br />"; 
$message .= "Naam : ".$naam."<br /><br />";
$message .= "School : ".$school."<br /><br />";
$message .= "Telefoon : ".$tel."<br /><br />";
$message .= "E-mail : ".$email."<br /><br />";
$message .= "Vraag : <br />".$vraag."<br /><br />";
$message .= "Met vriendelijke groet,<br /><br />";
$message .= "Het team van ".$param[naam];
$message .= "</td></tr>\n";
$message .= "</table>\n";
$message .= "</body>\n";
$message .= "</html>\n";
$username = $naam;
$mail     = $fromAddress;
$subject  = "Contactaanvraag ".$param[naam];	
mail($username." <".$mail.">",$subject, $message, $headers);
// kopie aan verzender indien gewenst
if ($kopiemail == 1) {
   $mail    = $email;
   $subject = 'Uw contactaanvraag aan '.$param[naam];	
   mail($username." <".$mail.">",$subject, $message, $headers);
}
?>