<?php 
require_once("includes/config.php");
$pdo=connectDB();
if ($pdo == false)
    die("ERROR: Unable to connect to database!");
if(!empty($_POST["regno"])) {
	$regno= $_POST["regno"];

		$query ="SELECT student_id FROM student WHERE student_id=?";
        $stmt=$pdo->prepare($query);
        $stmt->execute([$regno]);
		$row=$stmt->fetch(PDO::FETCH_ASSOC);
}
if($row)
{
echo "<span style='color:red'> Student with this Username Already Registered.</span>";
 echo "<script>$('#submit').prop('disabled',true);</script>";
} else{
	echo "<span style='color:green'> Username Available.</span>";
 echo "<script>$('#submit').prop('disabled',false);</script>";

}



?>
