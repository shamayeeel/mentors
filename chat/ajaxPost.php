<?php
include('connect.php');

// Get user input
$text = '#' . $_POST['text'];
$message = $_POST['messages'];
$user = $_POST['user'];
$appoid = $_POST['appoid'];

// Insert data into 'messages' table
$insertMessagesSQL = "INSERT INTO messages (user, message, textcolor, appoid) VALUES (:user, :message, :textcolor, :appoid)";
$queryMessages = $db->prepare($insertMessagesSQL);
$queryMessages->execute(array(':user' => $user, ':message' => $message, ':textcolor' => $text, ':appoid' => $appoid));

// Insert data into 'edoc' table
$insertEdocSQL = "INSERT INTO edoc (docid, message, appoid) VALUES (:docid, :message, :appoid)";
$queryEdoc = $db->prepare($insertEdocSQL);
$queryEdoc->execute(array(':docid' => $user, ':message' => $message, ':appoid' => $appoid));

// Display the posted message
echo '<div style="color:' . $text . '">' . $user . ' : ' . $message . '</div>';
?>
