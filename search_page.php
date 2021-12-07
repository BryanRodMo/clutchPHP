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
if(isset($_POST['search']) && $_POST['search'] != ""){
$searchrequest= strtoupper($_POST['search']);

}
if(isset($_POST['save']))
{ /*
$student_id=$_POST['student_id'];
$section=$_POST['CIBI3001'];
$course='CIBI3001';//$_POST['course_id'];
$query=("insert into enrollments (student_id,course_id,section_id,status) 
        values(:student_id,:course,:section,:status)");
$stmt=$pdo->prepare($query);
$stmt->bindParam('student_id',$student_id);
$stmt->bindParam('section',$section);
$stmt->bindParam('course',$course);
$stmt->bindValue('status',0);

$ret=$stmt->execute();*/
//$ret=mysqli_query($bd, "insert into enrollments(student_id,section,course) values('$student_id','$section','$course')");
var_dump($_POST['radio']);

if($ret)
{
$_SESSION['msg']="Saved Successfully !!";
}
else
{
  $_SESSION['msg']="Error : Not Saved";
}
}
if(isset($_GET['del']))
      {
              /*mysqli_query($bd, "delete from course where course_id = '".$_GET['id']."'");*/
$query=("select * from student where student_id=?");
$stmt = $pdo->prepare($query);
$row = $stmt->execute([$_SESSION['login']]);
$row=$stmt->fetch(PDO::FETCH_ASSOC);
while($row= $stmt->fetch(PDO::FETCH_ASSOC))
$student_id= $row['student_id'];

$query=("DELETE FROM enrollments
WHERE enrollments.student_id = ?
AND enrollments.course_id = ?");
$stmt=$pdo->prepare($query);
$stmt->execute([$student_id,$_GET['id']]);
 


      }
else
    {
        $_SESSION['delmsg']="";

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
                        <h1 class="page-head-line">Course Enroll </h1>               <?php  var_dump($_POST['save']);?>

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
    <input type="text" class="form-control" id="studentname" name="studentname" value="<?php echo htmlentities($row['name']);?>" readonly />
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
    </form>
      <?php     
    
 if(isset($searchrequest))
    {
    

     ?><p>Choose from:</p><form method="post">
  <?php 
          /*  $sql=mysqli_query($bd, "SELECT * FROM `section` where course_id like '%$searchrequest%'");
            while($row=mysqli_fetch_array($sql))*/
     $prev_row="TEST3000";
     $i=0;
     $query=("SELECT * FROM `section` where course_id like '%$searchrequest%'");
     $stmt = $pdo->prepare($query);
     $row = $stmt->execute();
            while($row= $stmt->fetch(PDO::FETCH_ASSOC))
     {
            
          if ($row['course_id'] == $prev_row) {

          echo '<input type = "radio" name = "radio[ ' . $i . ' ]" value = "' . $row['course_id'] . '-' . $row['section_id'] . ' ">';?>
          <label for="course"> <?php echo htmlentities($row['course_id']); ?> <?php echo htmlentities($row['section_id']); ?> </label><br>
    <?php
        } else {
          $i += 1;
          echo '<input type = "radio" name = "radio[ ' . $i . ' ]" value = "' . $row['course_id'] . '-' . $row['section_id'] . '">';?>
          <label for="course"> <?php echo $row['course_id'].'-'.$row['section_id']; ?> </label><br>
                           <?php

        }
        $prev_row = $row['course_id'];
        ?>
                           
                           
                           
                           
                           
                           <!--
                <input type="radio" id=" <?php// echo htmlentities($row['course_id']); ?> "
                name="<?php// echo htmlentities($row['course_id']); ?> "
                value="<?php// echo htmlentities($row['section_id']); ?> " >
                <label for="course"> <?php// echo htmlentities($row['course_id']); ?> <?php// echo htmlentities($row['section_id']); ?> </label><br>
-->
      <?php } ?>
    <button type="submit" name="save"  class="btn btn-default">Save</button>
     
  
    </form>
      
<?php } ?>
   <!-- <span id="course-availability-status1" style="font-size:12px;"> -->
  </div>
                         
 <strong>
                          Courses Selected:
                        </strong>
                            <div class="table-responsive table-bordered">
                    
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Course Name </th>
                                             <th>Title</th>
                                             <th>Section</th>
                                             <!--<th>Action</th>-->
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
$query=("SELECT course.*, section.section_id, section.capacity
FROM `course` INNER JOIN section 
ON course.course_id = section.course_id 
INNER JOIN enrollments 
ON course.course_id = enrollments.course_id 
where student_id=? && status=0");
     $stmt=$pdo->prepare($query);
     $stmt->execute([$_SESSION['login']]);
$cnt=1;
while($row = $stmt->fetch(PDO::FETCH_ASSOC))
{
?>


                                        <tr>
                                            <td><?php echo $cnt;?></td>
                                            <td><?php echo htmlentities($row['course_id']);?></td>
                                            <td><?php echo htmlentities($row['title']);?></td>
                                             <td><?php echo htmlentities($row['section_id']);?></td>
                                              <td>
                                            
  <a href="search_page.php?id=<?php echo $row['course_id']?>&del=delete" onClick="return confirm('Are you sure you want to drop this course?')">
                                            <button class="btn btn-danger">Drop Request</button>
</a>
                                            </td>
                                            
                                            <!--
                                            <td>
                                            <a href="" target="_blank">

                                            <a href="print.php?id=<?php// echo $row['cid']?>" target="_blank"> 
<button class="btn btn-primary"><i class="fa fa-print "></i> Print</button> </a>                                       


                                            </td>
                                        </tr>--> 
<?php 
$cnt++;
} ?>

                                        
                                    </tbody>
                                </table>
                         
                   

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
