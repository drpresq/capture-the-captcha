<?php
    $command = escapeshellcmd("python solver.py");
    $output = shell_exec($command);
    function printLines($array){
        foreach($array as $line){
            echo $line."<br>";
        }
    }
?>

<html>
<head>
</head>
<body width="50%" style="background:#333333; color:#ffffff; font-size:120%">
<span >
        <? printLines($output = explode("\n", $output)); ?>
</span>
</body>
</html>