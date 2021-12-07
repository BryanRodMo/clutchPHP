<?php
session_start();
include('includes/config.php');
$pdo=connectDB();
if ($pdo == false)
    die("ERROR: Unable to connect to database!");


if(strlen($_SESSION['login'])==0)
    {   
header('location:index.php');
}
else{

if(isset($_POST['submit']))
{
$coursecode=$_POST['coursecode'];
$coursename=$_POST['coursename'];
$courseunit=$_POST['courseunit'];
$coursesection=$_POST['coursesection'];
$seatlimit=$_POST['seatlimit'];
    
$query=("insert into course (course_id,title,credits) 
            values(:coursecode,:coursename,:courseunit)");
$stmt=$pdo->prepare($query);
$stmt->bindParam('coursecode',$coursecode);
$stmt->bindParam('coursename',$coursename);
$stmt->bindParam('courseunit',$courseunit);
$ret=$stmt->execute();
    
$query=("insert into section (course_id,section_id,capacity)
        values(:coursecode,:coursesection,:capacity)");
$stmt=$pdo->prepare($query);
$stmt->bindParam('coursecode',$coursecode);
$stmt->bindParam('coursesection',$coursesection);
$stmt->bindParam('capacity',$seatlimit);
$ret2=$stmt->execute();/*
$ret=mysqli_query($bd, "insert into course(course_id,title,credits) values('$coursecode','$coursename','$courseunit')");
$ret2=mysqli_query($bd, "insert into section(course_id,section_id,capacity) values('$coursecode','$coursesection','$seatlimit')");
    */
if($ret&&$ret2)
{
$_SESSION['msg']="Course Created Successfully !!";
}
else
{
  $_SESSION['msg']="Error : Course not created";
}
}
if(isset($_GET['del']))
      {
              /*mysqli_query($bd, "delete from course where course_id = '".$_GET['id']."'");*/
$query=("delete course.*, section.*, enrollments.*
FROM course INNER JOIN section 
ON course.course_id = section.course_id 
INNER JOIN enrollments 
where section.section_id=? && course.course_id=? ");
$stmt=$pdo->prepare($query);
$delete=$stmt->execute([$_GET['id'],$_GET['cid']]);
$_SESSION['delmsg']="Course deleted !!";
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
    <title>Admin | Course</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
</head>

<body>
<?php include('includes/header.php');?>
    
<?php if($_SESSION['login']!="")
{
 include('includes/menubar.php');
}
 ?>
   
    <div class="content-wrapper">
        <div class="container">
              <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">Course  </h1>
                    </div>
                </div>
                <div class="row" >
                  <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                           Course 
                        </div>
<font color="green" align="center"><?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?></font>


                        <div class="panel-body">
                       <form name="dept" method="post">
   <div class="form-group">
    <label for="coursecode">Course ID  </label>
    <input type="text" class="form-control" id="coursecode" name="coursecode" pattern="[A-Z]{4}[0-9]{4}" maxlength="8" placeholder="Course ID" required />
  </div>

 <div class="form-group">
    <label for="coursename">Title  </label>
    <input type="text" class="form-control" id="coursename" name="coursename" placeholder="Course Title" required />
  </div>
 <div class="form-group">
    <label for="coursesection">Section  </label>
    <input type="text" class="form-control" id="coursesection" name="coursesection" placeholder="Course Section" maxlength="3" required />
  </div>

<div class="form-group">
    <label for="courseunit">Credits  </label>
    <input type="text" class="form-control" id="courseunit" name="courseunit" min="1" placeholder="Course Credits" required />
  </div> 

<div class="form-group">
    <label for="seatlimit">Capacity  </label>
    <input type="text" class="form-control" id="seatlimit" name="seatlimit" min="1" placeholder="Course Capacity" required />
  </div>   

 <button type="submit" name="submit" class="btn btn-default">Submit</button>
</form>
                            </div>
                            </div>
                    </div>
                  
                </div>
                <font color="red" align="center"><?php echo htmlentities($_SESSION['delmsg']);?><?php echo htmlentities($_SESSION['delmsg']="");?></font>
                <div class="col-md-12">
                    
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Manage Course
                        </div>
                       
                        <div class="panel-body">
                            <div class="table-responsive table-bordered">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <td><b>#</b></td>
                                            <td><b>Course Code</b></td>
                                            <td><b>Course Name</b></td>
                                             <td><b>Section</b></td>
                                            <td><b>Course Credits</b></td>
                                            <td><b>Capacity</b></td>
					     <td><b>Action</b></td>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
/*$sql=mysqli_query($bd, "SELECT course.*, section.section_id, section.capacity FROM `course` INNER JOIN section ON course.course_id = section.course_id");*/
$query=("SELECT course.*, section.section_id, section.capacity FROM `course` INNER JOIN section ON course.course_id = section.course_id");
$stmt=$pdo->prepare($query);
$stmt->execute(); 
$cnt=1;
while($row=$stmt->fetch(PDO::FETCH_ASSOC))
{
?>


                                        <tr>
                                            <td><?php echo $cnt;?></td>
                                            <td><?php echo htmlentities($row['course_id']);?></td>
                                            <td><?php echo htmlentities($row['title']);?></td>
                                            <td><?php echo htmlentities($row['section_id']);?></td>
                                            <td><?php echo htmlentities($row['credits']);?></td>
                                             <td><?php echo htmlentities($row['capacity']);?></td>
                    
                                            <td>
                                            <a href="edit-course.php?id=<?php echo $row['course_id']?>&sec_id=<?php echo $row['section_id']?>">
<button class="btn btn-primary"><i class="fa fa-edit "></i> Edit</button> </a>                                        
  <a href="course.php?id=<?php echo $row['section_id']?>&cid=<?php echo$row['course_id'] ?>&del=delete" onClick="return confirm('Are you sure you want to delete?')">
                                            <button class="btn btn-danger">Delete</button>
</a>
                                            </td>
                                        </tr>
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
    
  <?php include('includes/footer.php');?>
    
    <script src="assets/js/jquery-1.11.1.js"></script>
    
    <script src="assets/js/bootstrap.js"></script>
</body>
</html>
<?php } ?>
