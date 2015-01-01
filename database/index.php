<?php
// Create the mysql backup file
// edit this section
$dbuser = $_ENV['OPENSHIFT_MYSQL_DB_USERNAME'];
$dbpass = $_ENV['OPENSHIFT_MYSQL_DB_PASSWORD'];
$dbname = $_ENV['OPENSHIFT_APP_NAME'];
$sendto = "Webmaster <alfy32+accent-database@gmail.com>";
$sendToJill = "Salon Owner <myaccentsalon+accent-database@gmail.com>";
$sendfrom = "Automated Backup <backup@accent.westhostsite.com>";
$sendsubject = "Daily Mysql Backup";
$bodyofemail = "Here is the daily backup.";
// don't need to edit below this section

$backupfile = $dbname . date("\_Y-m-d\_H:i:s") . '.sql';
exec(" mysqldump  -u'$dbuser' -p'$dbpass' $dbname > $backupfile");

// Mail the file

include('Mail.php');
include('Mail/mime.php');

$message = new Mail_mime();
$text = "$bodyofemail";
$message->setTXTBody($text);
$message->AddAttachment($backupfile);
$body = $message->get();
$extraheaders = array("From"=>"$sendfrom", "Subject"=>"$sendsubject");
$headers = $message->headers($extraheaders);
$mail = Mail::factory("mail");
// Send to Alan
$mail->send("$sendto", $headers, $body);
/// Send to Jill
$mail->send("$sendToJill" , $headers, $body);

// Delete the file from your server
unlink($backupfile);

echo "An email has been sent to $sendToJill and $sendto with an SQL dump of the database on " . date("\_Y-m-d\_H:i:s");
?>
