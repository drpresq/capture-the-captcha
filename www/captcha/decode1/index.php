<?php
    session_start();
    if (!isset($_POST["captcha"])){
        $_SESSION["count"]=0;
    }
    if ( (isset($_POST["captcha"])) && ($_POST["captcha"] != $_SESSION["captcha_code"]) ){
        $msg = "Incorrect CAPTCHA<br>";
        $_SESSION["count"]=0;
        $count = 0;
    };
    if ($_POST["captcha"] === $_SESSION["captcha_code"]){
        $_SESSION['count']=$_SESSION['count']+1;
    }

    if (!isset($_SESSION["flag"])){
        $_SESSION["flag"] = md5(rand());
    };
    
?>
<html>
<head>
</head>
<body>
    <? echo ($count > 10)?"<h1>You WIN, heres the flag: ".$_SESSION["flag"]."</h1><br>":''; ?>
    <? echo ($msg)?"<h1>".$msg."</h1><br>":'';?>
    <br><br>
    <form id=submissionForm method="POST" onsubmit="index.php">
        <p><img src="captcha1.php" width="70" height="30" border="1" alt="CAPTCHA"></p>
        <p><input type="text" size="6" maxlength="6" name="captcha" value=""><br>
        <small>copy the digits from the image into this box</small></p>
        <input type="submit" action="submit">
    </form>
    <br>
    <?echo "You have solved this CAPTCHA ".$_SESSION['count']." times.<br>"?>

<br>
<table>
    <tr>
        <?php echo "POST['captcha']= ".$_POST['captcha']; ?>
    </tr>

    <tr>
        <?php echo "SESSION['captcha']= ".$_SESSION['captcha_code']; ?>
    </tr>
</table>
</body>
</html>