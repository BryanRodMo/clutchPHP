<?php
session_start();
error_reporting(1);
include("includes/config.php");
if(isset($_POST['submit']))
{
$regno=$_POST['regno'];
$password=md5($_POST['password']);
$query=mysqli_query($bd, "SELECT * FROM student WHERE student_id='$regno' and password='$password'");
if(mysqli_num_rows($query)>0)
{
$num=mysqli_fetch_array($query);
$extra="change-password.php";//
$_SESSION['login']=$_POST['regno'];
$_SESSION['id']=$num['student_id'];
$_SESSION['sname']=$num['name'];
$uip=$_SERVER['REMOTE_ADDR'];
$status=1;
$log=mysqli_query($bd, "insert into userlog(student_id,userip,status) values('".$_SESSION['login']."','$uip','$status')");
$host=$_SERVER['HTTP_HOST'];
$uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
header("location:http://$host$uri/$extra");
exit();
}
else
{
$_SESSION['errmsg']="Invalid Reg no or Password";
$extra="index.php";
$host  = $_SERVER['HTTP_HOST'];
$uri  = rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
header("location:http://$host$uri/$extra");
exit();
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

    <title>Student Login</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
</head>
<body>
    <?php include('includes/header.php');?>
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-head-line">Please Login To Enter </h4>

                </div>

            </div>
             <span style="color:red;" ><?php echo htmlentities($_SESSION['errmsg']); ?><?php echo htmlentities($_SESSION['errmsg']="");?></span>
            <form name="admin" method="post">
            <div class="row">
                <div class="col-md-6">
                     <label>Enter Username : </label>
                        <input type="text" name="regno" class="form-control"  />
                        <label>Enter Password :  </label>
                        <input type="password" name="password" class="form-control"  />
                        <hr />
                        <button type="submit" name="submit" class="btn btn-info"><span class="glyphicon glyphicon-user"></span> &nbsp;Log Me In </button>&nbsp;
                        <span>New here? <a href="student-registration.php">Register!</a></span>
                </div>
                </form>
                <div class="col-md-6">
                    <div class="alert alert-info">
                        This is a Web Programming Project for CCOM4019
                        <br />
                         <strong> Overview:</strong>
                        <ul>
                            <li>
                                A system for students to select courses for enrollment.  
                            </li>
                            <li>
                                The students will be able to search for their course, using either the entire course code or a prefix of it, and then add it to their enrollment.
                            </li>
                            <li>
                                The administrators will be able to create courses, sections, or process the pending students' enrollment.                            </li>
                            
                        </ul>
                       
                    </div>
                                    </div>

            </div>
        </div>
    </div>
 
    <?php include('includes/footer.php');?>
   
    <script src="assets/js/jquery-1.11.1.js"></script>

    <script src="assets/js/bootstrap.js"></script>
</body>
</html>
