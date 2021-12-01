<?php
session_start();
include('includes/config.php');


if(isset($_POST['submit']))
{
$name=$_POST['name'];
$student_id=$_POST['student_id'];
$password=md5($_POST['password']);
$year_of_study =$_POST['year_of_study'];
$ret=mysqli_query($bd, "insert into student(name,student_id,password,year_of_study) values('$name','$student_id','$password','$year_of_study')");
if($ret)
{
$extra="change-password.php";
$host=$_SERVER['HTTP_HOST'];
$uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
header("location:http://$host$uri/$extra");
exit();
}
else
{
  $_SESSION['msg']="Error : Student  not Registered";
}
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Student Registration</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
</head>

<body>
<?php include('includes/header.php');?>
    
<?php if($_SESSION['alogin']!="")
{
 include('includes/menubar.php');
}
 ?>
   
    <div class="content-wrapper">
        <div class="container">
              <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">Student Registration  </h1>
                    </div>
                </div>
                <div class="row" >
                  <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                          Student Registration
                        </div>
<font color="green" align="center"><?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?></font>


                        <div class="panel-body">
                       <form name="dept" method="post">
   <div class="form-group">
    <label for="name">Student Name  </label>
    <input type="text" class="form-control" id="name" pattern="[^0-9]+" name="name" placeholder="Student Name" required />
  </div>
                           <div class="form-group">
    <label for="year_of_study">Year of Study   </label>
    <input type="number" class="form-control" id="year_of_study" name="year_of_study"  min="1" max="5" placeholder="Year of Study" required />
  </div>

 <div class="form-group">
    <label for="student_id">Username (Example: name.lastname)  </label>
    <input type="text" class="form-control" id="student_id" name="student_id" pattern="[A-Z]{4}[0-9]{4}" onBlur="userAvailability()" placeholder="Name followed by a '.' and Lastname (must be lowercase)" required />
     <span id="user-availability-status1" style="font-size:12px;">
  </div>



<div class="form-group">
    <label for="password">Password  </label>
    <input type="password" class="form-control" id="password" pattern=".{8,}" name="password" placeholder="Enter password (8 characters minimum)" required />
  </div>   

 <button type="submit" name="submit" id="submit" class="btn btn-default">Submit</button>
</form>
                            </div>
                            </div>
                    </div>
                  
                </div>

            </div>





        </div>
    </div>
  <?php include('includes/footer.php');?>
    <script src="assets/js/jquery-1.11.1.js"></script>
    <script src="assets/js/bootstrap.js"></script>
<script>
function userAvailability() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_user_availability.php",
data:'regno='+$("#student_id").val(),
type: "POST",
success:function(data){
$("#user-availability-status1").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}
</script>


</body>
</html>

