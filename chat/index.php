<?php
session_start();

if (empty($_SESSION["user"])) {
    header("location: ../login.php");
    exit();
}

include("../chat/connect.php");

$useremail = $_SESSION["user"];
$appoid = isset($_SESSION['appoid']) ? $_SESSION['appoid'] : null;
$userType = '';

$doctorResult = $database->query("SELECT * FROM doctor WHERE docemail='$useremail'");
$patientResult = $database->query("SELECT * FROM patient WHERE pemail='$useremail'");

$doctorFetch = $doctorResult->fetch_assoc();
$patientFetch = $patientResult->fetch_assoc();

if ($doctorFetch) {
    $userId = $doctorFetch["docid"];
    $userName = $doctorFetch["docname"];
    $userType = "doctor";
} elseif ($patientFetch) {
    $userId = $patientFetch["pid"];
    $userName = $patientFetch["pname"];
    $userType = "patient";
} else {
    header("location: ../login.php");
    exit();
}

// Retrieve messages based on the user type
if ($userType === "doctor") {
    $appoid = isset($_GET['appoid']) ? (int)$_GET['appoid'] : 0;
    $patientId = isset($_GET["patient_id"]) ? (int)$_GET["patient_id"] : 0;
    $messagesResult = $database->query("SELECT * FROM messages WHERE appoid=$appoid AND user=$patientId");
} elseif ($userType === "patient") {
    $appoid = isset($_GET['appoid']) ? (int)$_GET['appoid'] : 0;
    $doctorId = isset($_GET["doctor_id"]) ? (int)$_GET["doctor_id"] : 0;
    $messagesResult = $database->query("SELECT * FROM messages WHERE appoid=$appoid AND user=$doctorId");
}


// Fetch and display messages
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat</title>
    <link rel="stylesheet" href="style1.css" type="text/css" media="screen" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
        
    <title>Dashboard</title>
    <style>
        .dashbord-tables, .doctor-heade {
            animation: transitionIn-Y-over 0.5s;
        }
        .filter-container {
            animation: transitionIn-Y-bottom 0.5s;
        }
        .sub-table, #anim {
            animation: transitionIn-Y-bottom 0.5s;
        }
        .doctor-heade {
            animation: transitionIn-Y-over 0.5s;
        }
    </style>
    <script type="text/javascript" src="jscolor.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                cache: false,
                beforeSend: function() {
                    $('#messages').hide();
                    $('#messages').show();
                    $("#messages").animate({"scrollTop": $('#messages')[0].scrollHeight}, "slow");
                },
                complete: function() {
                    $('#messages').hide();
                    $('#messages').show();
                    $("#messages").animate({"scrollTop": $('#messages')[0].scrollHeight}, "slow");
                },
                success: function() {
                    $('#messages').hide();
                    $('#messages').show();
                    $("#messages").animate({"scrollTop": $('#messages')[0].scrollHeight}, "slow");
                }
            });

            var $container = $("#messages");
            $container.load('ajaxload.php?id=<?php echo 'a' ?>');

            var refreshId = setInterval(function() {
                $container.load('ajaxload.php?id=<?php echo 'a' ?>');
            }, 3000);

            $("#userArea").submit(function() {
                $.post('ajaxPost.php', $('#userArea').serialize(), function(data) {
                    $("#messages").append(data);
                    $("#messages").animate({"scrollTop": $('#messages')[0].scrollHeight}, "slow");
                    document.getElementById("output").value = "";
                });
                return false;
            });
        });
    </script>
</head>
<body>
    <section class="main">
    <div class="container">
<div class="menu">
            <table class="menu-container" border="0">
                <tr>
                    <td style="padding:10px" colspan="2">
                        <table border="0" class="profile-container">
                            <tr>
                                <td width="30%" style="padding-left:20px" >
                                    <img src="../img/user.png" alt="" width="100%" style="border-radius:50%">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                    <p class="profile-title"><?php 
                                    if ($userType= "doctor") echo $userName;
                                    else echo substr($username,0,13)  ?>..</p>
                                    <p class="profile-subtitle"><?php echo substr($useremail,0,22)  ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="../logout.php" ><input type="button" value="Log out" class="logout-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                    </table>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-dashbord menu-active menu-icon-dashbord-active" >
                        <a href="../doctor/index.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">Dashboard</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="../appointment.php" class="non-style-link-menu"><div><p class="menu-text">My Appointments</p></a></div>
                    </td>
                </tr>
                
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-session">
                        <a href="../schedule.php" class="non-style-link-menu"><div><p class="menu-text">My Sessions</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-patient">
                        <a href="../patient.php" class="non-style-link-menu"><div><p class="menu-text">My Patients</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-settings">
                        <a href="../settings.php" class="non-style-link-menu"><div><p class="menu-text">Settings</p></a></div>
                    </td>
                </tr>
                
            </table>
        </div>
        
            <div class="dash-body" style="margin-top: 15px">
                <center>
                    <table class="filter-container doctor-header" style="border: none;width:95%" border="0" >
                    <tr>
                        <td >
                            <h3>Welcome!</h3>
                            <h1><?php 
                            if ($userType = "doctor") echo $userName;
                            else echo substr($username,0,13)  ?>.</h1>
                            <p>Thanks for joinnig with us. We are always trying to get you a complete service<br>
                            You can view your dailly schedule, Reach Patients Appointment at home!<br><br>
                            </p>
                            <a href="../appointment.php" class="non-style-link"><button class="btn-primary btn" style="width:30%">View My Appointments</button></a>
                            <br>
                            <br>
                        </td>
                    </tr>
                    </table>
                    </center>

        <div id="messages">
            
        </div>

                    <!-- Post Form HTML code here -->
                    <form id="userArea">
                        <div id="usercolor">
                            <?php
                            $username = isset($_SESSION["user"]) ? $_SESSION["user"] : "argie";
                            ?>
                            <input type="text" name="user" placeholder="User" required="required" value="<?php echo $username; ?>" id="text" style="margin-bottom: 5px;" />
                            <input name="text" class="color" id="text" maxlength="6" value="000000" />
                        </div>
                        <div id="messagesntry">
                            <textarea id="output" name="messages" placeholder="Message" ></textarea>
                        </div>
                        <div id="messagesubmit">
                            <input class="btn-primary btn" type="submit" value="Post message" id="submitmessage" />
                        </div>
                    </form>
                </center>
            </div>
        </div>
    </section>
</body>
</html>
