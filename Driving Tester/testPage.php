<?php
session_start();
require_once("LogicHandler.php");
$logichandler = new LogicHandler();
$logichandler -> LoginGuard();

if(isset($_POST["questionSwitch"]))
{

  $_SESSION["Current"] = $_POST["questionSwitch"] - 1;
  unset($_POST["questionSwitch"]);

}

if(isset($_POST["responseSubmission"]))
{
  $_SESSION["Responses"][$_SESSION["Current"]] = $_POST["questionResponse"];
  unset($_POST["responseSubmission"]);
}

var_dump($_SESSION["Responses"]);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>


<div style="display: flex;">

<?php

$cnt = count($_SESSION["Questions"]);

$basicstyle = "margin: 2px;";
$selectedstyle = $basicstyle." background-color: red;";

for($i=0; $i<$cnt; $i++)
{
  $current_cnt = $i+1;

  echo  "<form action='' method='post'>";
  if($_SESSION["Current"] == $i )
  {
    echo  "<input type='submit' value=".$current_cnt." name='questionSwitch' style='".$selectedstyle."'>";
  }
  else
  {
     echo  "<input type='submit' value=".$current_cnt." name='questionSwitch' style='".$basicstyle."'>";
  }
  echo  "</form>";
}

?>

</div>

<h2 style="margin-top: 25px"> <?php echo $_SESSION["Questions"][$_SESSION["Current"]]["Q_String"]; ?> </h2>


<form action="" method="post">
<input type="radio" name="questionResponse" id="" value="True" required> <label>True</label>
<input type="radio" name="questionResponse" id="" value="False" required> <label>False</label> <br>
<input type="submit" name="responseSubmission" value="Confirm">
</form>

<body>

<form action="testResult.php" method="post">
  <input type="submit" value="FinishTest">
</form>

</body>
</html>

<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>