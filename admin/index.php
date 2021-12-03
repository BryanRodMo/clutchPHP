<?php
session_start();
include("includes/config.php");
$pdo=connectDB();
if ($pdo == false)
    die("ERROR: Unable to connect to database!");


if(isset($_POST['submit']))
{
$username=$_POST['username'];
$password=md5($_POST['password']);/*
$query=mysqli_query($bd, "SELECT * FROM admin WHERE username='$username' and password='$password'");
$num=mysqli_fetch_array($query);*/
$query=("SELECT * FROM admin WHERE username=? and password=?");
$stmt=$pdo->prepare($query);
$stmt->execute([$username,$password]);
$num=$stmt->fetchALL();  
if($num>0) 
{
$extra="course.php";//
$_SESSION['alogin']=$_POST['username'];
$_SESSION['id']=$num['id'];
$host=$_SERVER['HTTP_HOST'];
$uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
header("location:http://$host$uri/$extra");
exit();
}
else
{
$_SESSION['errmsg']="Invalid username or password";
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

    <title>Admin Login</title>
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
                        <input type="text" name="username" class="form-control" required />
                        <label>Enter Password :  </label>
                        <input type="password" name="password" class="form-control" required />
                        <hr />
                        <button type="submit" name="submit" class="btn btn-info"><span class="glyphicon glyphicon-user"></span> &nbsp;Log Me In </button>&nbsp;
                </div>
                </form>
                <div class="col-md-6">
                    This is a Web Programming Project for CCOM4019 - ADMIN SIDE
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
