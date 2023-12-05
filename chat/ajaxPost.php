<?php
include('connect.php');
$text = '#'.$_POST['text'];
$message = $_POST['messages'];
$user = $_POST['user'];
$sql = "INSERT INTO messages (user,message,textcolor) VALUES (:sas,:asas,:asafs)";
$q = $db->prepare($sql);
$q->execute(array(':sas'=>$user,':asas'=>$message,':asafs'=>$text));

echo '<div style="color:'.$text.'">'.$user .' : '. $message.'</div>'; 
?>

<?php
include('connect.php');

$text = '#' . $_POST['text'];
$message = $_POST['messages'];
$user = $_POST['user'];
$userId = $_POST['userId']; // Assuming you have userId in the form
$doctorId = $_POST['doctorId']; // Assuming you have doctorId in the form

$sql = "INSERT INTO messages (user, message, textcolor, userId, doctorId) VALUES (:sas, :asas, :asafs, :userId, :doctorId)";
$q = $db->prepare($sql);
$q->execute(array(':sas' => $user, ':asas' => $message, ':asafs' => $text, ':userId' => $userId, ':doctorId' => $doctorId));

echo '<div style="color:' . $text . '">' . $user . ' : ' . $message . '</div>';
?>
 