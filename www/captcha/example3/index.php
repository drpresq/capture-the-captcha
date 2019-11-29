<?php
    session_start();
    if (!isset($_POST["captcha"])){
        $count = 0;
    }
    if ( (isset($_POST["captcha"])) && ($_POST["captcha"] != $_SESSION["captcha_text"]) ){
        $msg = "Incorrect CAPTCHA<br>";
        $count = 0;
        $seconds = time();
    };
    if ($_POST["captcha"] === $_SESSION["captcha_text"]){
        $count = $_POST["count"];
        $count++;
    }

    if (!isset($_SESSION["flag"])){
        $_SESSION["flag"] = md5(rand());
    };
    
?>
<html>
<head>
</head>
<body>
    <? echo ($count > 99)?"<h1>You WIN, heres the flag: ".$_SESSION["flag"]."</h1><br>":''; ?>
    <? echo ($msg)?"<h1>".$msg."</h1><br>":'';?>
    <br><br>
    <form id=submissionForm method="POST" onsubmit="index.php">
        <p><img src="captcha3.php" width="200" height="50" border="1" alt="CAPTCHA"></p>
        <p><input type="text" size="6" maxlength="6" name="captcha" value=""><br>
        <small>copy the digits from the image into this box</small></p>
        <input type="submit" action="submit">
        <? echo "<input type='hidden' name='count' value=".$count.">"; ?>
    </form>
    <br>
    <?echo "You have solved this CAPTCHA ".$count." times.<br>"?>

<br>
<table>
<?php 


    foreach ($_POST as $key => $value) {
        echo "<tr>";
        echo "<td>";
        echo $key;
        echo "</td>";
        echo "<td>";
        echo $value;
        echo "</td>";
        echo "</tr>";
    }


?>
</table>
</body>
</html>