<?php
session_start();
include("includes/config.php");
$pdo=connectDB();
if ($pdo == false)
    die("ERROR: Unable to connect to database!");

$_SESSION['login']=="";
date_default_timezone_set('Asia/Kolkata');
$ldate=date( 'd-m-Y h:i:s A', time () );
//mysqli_query($bd, "UPDATE userlog  SET logout = '$ldate' WHERE student_id = '".$_SESSION['login']."' ORDER BY id DESC LIMIT 1");
$query=("UPDATE userlog  SET logout = ? WHERE student_id = ? ORDER BY id DESC LIMIT 1");
$stmt=$pdo->prepare($query);
$stmt->execute([$ldate,$_SESSION['login']]);
session_unset();
$_SESSION['errmsg']="You have successfully logout";
?>
<script language="javascript">
document.location="../index.php";
</script>
