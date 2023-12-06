<?php

    //learn from w3schools.com

    session_start();

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='d'){
            header("location: ../login.php");
        }else{
            $useremail=$_SESSION["user"];
        }

    }else{
        header("location: ../login.php");
    }
    

    //import database
    include("../chat/connection.php");
    $userrow = $database->query("select * from doctor where docemail='$useremail'");
    $userfetch=$userrow->fetch_assoc();
    $userid= $userfetch["docid"];
    $username=$userfetch["docname"];


    //echo $userid;
    //echo $username;
    
    ?>
<!Doctype html>
<html>
<head>
<title>Chat</title>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
        
    <title>Dashboard</title>
    <style>
        .dashbord-tables{
            animation: transitionIn-Y-over 0.5s;
        }
        .filter-container{
            animation: transitionIn-Y-bottom  0.5s;
        }
        .sub-table{
            animation: transitionIn-Y-bottom 0.5s;
        }
    </style>
<link rel="stylesheet" href="style.css" type="text/css" media="screen" />
<script type="text/javascript" src="jscolor.js"></script>
<script type="text/javascript" src="http://jqueryjs.googlecode.com/files/jquery-1.3.2.js"></script>
<script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
<script>
$(document).ready(function() {
	$.ajaxSetup(
        {
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
        var refreshId = setInterval(function()
        {
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
                                    <p class="profile-title">Administrator</p>
                                    <p class="profile-subtitle">admin@edoc.com</p>
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
                        <a href="../index.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">Dashboard</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor ">
                        <a href="../doctors.php" class="non-style-link-menu "><div><p class="menu-text">Mentors</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-schedule">
                        <a href="../schedule.php" class="non-style-link-menu"><div><p class="menu-text">Schedule</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="../appointment.php" class="non-style-link-menu"><div><p class="menu-text">Appointment</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-patient">
                        <a href="../patient.php" class="non-style-link-menu"><div><p class="menu-text">Patients</p></a></div>
                    </td>
                </tr>
            </table>
        </div>
<div id="chatwrapper">
<div id="messages"></div>
<!--post-->
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
<input type="submit" value="Post message" id="submitmessage" />
</div>
</form>
</div>
</body>
</html>