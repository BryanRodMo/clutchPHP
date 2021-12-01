<?php 
require_once("includes/config.php");
if(!empty($_POST["regno"])) {
	$regno= $_POST["regno"];
	
		$result =mysqli_query($bd, "SELECT student_id FROM student WHERE student_id='$regno'");
		$count=mysqli_num_rows($result);
if($count>0)
{
echo "<span style='color:red'> Student with this Username Already Registered.</span>";
 echo "<script>$('#submit').prop('disabled',true);</script>";
} else{
	

}
}


?>
