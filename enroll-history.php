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



?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Enroll History</title>
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
                        <h1 class="page-head-line">Enroll History  </h1>
                    </div>
                </div>
                <div class="row" >
            
                <div class="col-md-12">
                   
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Enroll History
                        </div>
                      
                        <div class="panel-body">
                            <div class="table-responsive table-bordered">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <td><b>#</b></td>
                                            <td><b>Course Name</b> </td>
                                             <td><b>Title</b></td>
                                             <td><b>Section</b></td>
                                            <td><b>status</b></td>

                                             <!--<th>Action</th>-->
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
$query=("SELECT course.*, section.section_id, section.capacity, enrollments.status
FROM `course` INNER JOIN section 
ON course.course_id = section.course_id 
INNER JOIN enrollments 
ON course.course_id = enrollments.course_id 
where student_id=?");
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
                                            <?php						if($row['status']==0){?>
                                            <td><?php echo "PENDING";?></td>
<?php } else if($row['status']==1){?>
 <td><?php echo "SUCCESSFUL";?></td>
<!-- <?php}  else{?>
 <td><?php //echo "UNSUCCESSFUL";?></td>
<?php } ?>-->

                                         
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
