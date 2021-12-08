<?php
session_start();
include "includes/config.php";
$pdo=connectDB();
if ($pdo == false)
    die("ERROR: Unable to connect to database!");

if(isset($_POST['submit']))
{
$regno=$_POST['regno'];
$password=md5($_POST['password']);
$query="SELECT * FROM student WHERE student_id=? and password=?";
$sql= $pdo->prepare($query);
//$sql->bindParam("student_id", $regno, "password", $password, PDO::PARAM_STR);
$sql->execute([$regno, $password]);
$num=$sql->fetch(PDO::FETCH_ASSOC);

if($num)
{
  if($num['year_of_study']==0)
    $extra="admin/search_page.php";
  else{
    $extra="search_page.php";//
    } 
$_SESSION['login']=$_POST['regno'];
$_SESSION['id']=$num['student_id'];
$_SESSION['sname']=$num['name'];
$uip=$_SERVER['REMOTE_ADDR'];
$status=1;
$query=("insert into userlog (student_id,userip,logout,status) 
        values(:login,:uip,:logout, :status)");
$stmt=$pdo->prepare($query);
$stmt->bindParam('login',$_SESSION['login']);
$stmt->bindParam('uip',$uip);
$stmt->bindValue('logout',0);
$stmt->bindParam('status',$status);
$stmt->execute();
   
    
    /*
$$log=mysqli_query("insert into userlog(student_id,userip,status)
values('".$_SESSION['login']."','$uip','$status')");*/
$host=$_SERVER['HTTP_HOST'];
$uri=rtrim(dirname($_SERVER['PHP_SELF']),'/\\');
header("location:http://$host$uri/$extra");
exit();
}
else
{
$_SESSION['errmsg']="Invalid Username or Password";
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
                        <span>New here? <a href="student-registration.php">Register!</a> </span><!-- href="student-registration.php"-->
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
