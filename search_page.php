<?php
session_start();
include('includes/config.php');
$pdo=connectDB();
if ($pdo == false)
    die("ERROR: Unable to connect to database!");
if(strlen($_SESSION['login'])==0) // or strlen($_SESSION['pcode'])==0)
    {   
header('location:index.php');
}
else{
if(isset($_POST['search'])){
$searchrequest= strtoupper($_POST['search']);
var_dump($searchrequest);
}
if(isset($_POST['submit.student_id']))
{
$student_id=$_POST['student_id'];
$section=$_POST['section_id'];
$course=$_POST['course_id'];
$query=("insert into enrollments (student_id,section,course) 
        values(:student_id,:section,:password,:course)");
$stmt=$pdo->prepare($query);
$stmt->bindParam('student_id',$student_id);
$stmt->bindParam('section',$section);
$stmt->bindParam('course',$course);
$ret=$stmt->execute();
//$ret=mysqli_query($bd, "insert into enrollments(student_id,section,course) values('$student_id','$section','$course')");
if($ret)
{
$_SESSION['msg']="Enroll Successfully !!";
}
else
{
  $_SESSION['msg']="Error : Not Enroll";
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
    <title>Course Enroll</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
</head>

<body>
<?php include('includes/header.php');?>
    <!-- LOGO HEADER END-->
<?php if($_SESSION['login']!="")
{
 include('includes/menubar.php');
}
 ?>
    <!-- MENU SECTION END-->
    <div class="content-wrapper">
        <div class="container">
              <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">Course Enroll </h1>
                    </div>
                </div>
                <div class="row" >
                  <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                          Course Enroll
                        </div>
<font color="green" align="center"><?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?></font>
<?php $query=("select * from student where student_id=?");
    $stmt = $pdo->prepare($query);
    $row = $stmt->execute([$_SESSION['login']]);
//$sql=mysqli_query($bd, "select * from student where student_id='".$_SESSION['login']."'");
$cnt=1;
//while($row=mysqli_fetch_array($sql))
    while($row= $stmt->fetch(PDO::FETCH_ASSOC))
{ ?>

                        <div class="panel-body">
                       <form name="dept" method="post" enctype="multipart/form-data">
   <div class="form-group">
    <label for="studentname">Student Name  </label>
    <input type="text" class="form-control" id="studentname" name="studentname" value="<?php echo htmlentities($row['name']);?>"  />
  </div>

 <div class="form-group">
    <label for="student_id">Username </label>
    <input type="text" class="form-control" id="student_id" name="student_id" value="<?php echo htmlentities($row['student_id']);?>"  placeholder="username" readonly />
    
  </div>


 <?php } ?>




<div class="form-group">
    <label for="Course">Course  </label>
    <input type="text" class="form-control" name="search" placeholder="Search..">  
     <button type="submit" name="submit" id="search" value="search" class="btn btn-default">Search Course</button>
    
      <?php     
    
 if(isset($searchrequest))
    {
     
     ?><p>Choose from:</p>
       <form method="post"><?php 
          /*  $sql=mysqli_query($bd, "SELECT * FROM `section` where course_id like '%$searchrequest%'");
            while($row=mysqli_fetch_array($sql))*/
     $query=("SELECT * FROM `section` where course_id like '%$searchrequest%'");
     $stmt = $pdo->prepare($query);
     $row = $stmt->execute();
            while($row= $stmt->fetch(PDO::FETCH_ASSOC))
     {?>
            
                <input type="radio" id=" <?php echo htmlentities($row['course_id']); ?> "name="<?php echo htmlentities($row['course_id']); ?> "value="<?php echo htmlentities($row['section_id']); ?> " >
                <label for="html"> <?php echo htmlentities($row['course_id']); ?> <?php echo htmlentities($row['section_id']); ?> </label><br>

      <?php } if(isset($searchrequest)){ ?>
    <button type="submit" name="submit"  class="btn btn-default">Enroll</button>
               <?php  var_dump($_POST['submit']);?>
     
    <?php } ?>
    </form>
<?php } ?>
   <!-- <span id="course-availability-status1" style="font-size:12px;"> -->
  </div>




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
<script>/*
function courseAvailability() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'cid='+$("#course").val(),
type: "POST",
success:function(data){
$("#course-availability-status1").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}*/
</script>


</body>
</html>
<?php } ?>
