<?php
session_start();
$useremail = $_SESSION["user"];
include('connect.php');

// Retrieve appoid from the URL using $_GET
$appoid = isset($_GET['appoid']) ? $_GET['appoid'] : null;

// Check if appoid is set and not empty
if (!empty($appoid)) {
    // Retrieve user details
    $userRow = $db->query("SELECT * FROM messages WHERE appoid = '$appoid'")->fetch(PDO::FETCH_ASSOC);

    if ($userRow) {
        $docid = isset($userRow['docid']) ? $userRow['docid'] : null;

        // Query messages from 'messages' table
        $resultMessages = $db->prepare("SELECT * FROM messages WHERE user = :useremail");
        $resultMessages->bindParam(':useremail', $useremail);
        $resultMessages->execute();

        // Display messages
        while ($row = $resultMessages->fetch(PDO::FETCH_ASSOC)) {
            echo '<div style="color:' . $row['textcolor'] . '">' . $row['user'] . ' : ' . $row['message'] . '</div>';

            // Insert data into 'edoc' table
            $sqlEdoc = "INSERT INTO edoc (docid, message, appoid) VALUES (:docid, :message, :appoid)";
            $qEdoc = $db->prepare($sqlEdoc);
            $qEdoc->execute(array(':docid' => $docid, ':message' => $row['message'], ':appoid' => $appoid));
        }
    } else {
        echo 'No user found for the given appoid.';
    }
} else {
    echo 'Appoid is missing or empty in the URL.';
    echo '</br>';
    echo '$useremail = ' . $useremail;
    echo '$appoid = ' . $appoid;
}
?>
