<?php
session_start();
require_once("LogicHandler.php");
$logichandler = new LogicHandler();
$logichandler -> LoginGuard();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<?php

$cnt = 1;

foreach($_SESSION["Questions"] as $question)
{
  echo ("<h3>".$cnt.".".$question["Q_String"]."  --  ".$question["C_ID"]."</h3>");
  $cnt++;
}

?>

<body>
    
</body>
</html>