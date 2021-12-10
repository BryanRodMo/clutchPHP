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
if(isset($_POST['search']) && $_POST['search'] != ""){
$searchrequest= strtoupper($_POST['search']);

}

?>
   


<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Browse Courses</title>
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
                        <h1 class="page-head-line">Course Search </h1>               

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
$cnt=1;
    
    while($row= $stmt->fetch(PDO::FETCH_ASSOC))
{ ?>

                        <div class="panel-body">
                       <form name="dept" method="post" enctype="multipart/form-data">
   <div class="form-group">
    <label for="studentname">Admin Name  </label>
    <input type="text" class="form-control" id="studentname" name="studentname" value="<?php echo htmlentities($row['name']);?>" readonly />
  </div>

 <div class="form-group">
    <label for="student_id">Username </label>
    <input type="text" class="form-control" id="student_id" name="student_id" value="<?php echo htmlentities($row['student_id']);?>"  placeholder="username" readonly />
    
  </div>


 <?php } ?>




<div class="form-group">
    <label for="Course">Courses  </label>
    <input type="text" class="form-control" name="search" placeholder="Search..">  
     <button type="submit" name="submit" id="search" value="search" class="btn btn-default">Search Course</button>
    </form>
                             </div>

      <?php     
    
 if(isset($searchrequest))
    {?>
    <div class="panel panel-default">
                        <div class="panel-heading">
                            Add Section
        </div>
                       
                        <div class="panel-body">
                            <div class="table-responsive table-bordered">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <td><b>Section</b></td>
                                            <td><b>Capacity</b></td>
                                            <td><b>Action</b></td>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
 $query=("SELECT * FROM `section` where course_id like '%$searchrequest%' order by course_id ASC, section_id ASC");
     $stmt = $pdo->prepare($query);
     $row = $stmt->execute();
            while($row= $stmt->fetch(PDO::FETCH_ASSOC))
     {
?>


                                        <tr>
                                            <td><?php echo htmlentities($row['course_id']);?></td>
                                            <td><?php echo htmlentities($row['section_id']);?></td>
                                             <td><?php echo htmlentities($row['capacity']);?></td>
                    
                                            <td>
                                             <a href="edit-course.php?id=<?php echo $row['course_id']?>&sec_id=<?php echo $row['section_id']?>">
                                                 <button class="btn btn-primary"><i class=" fa fa-refresh "></i> Edit Section</button> </a>
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
                     
                
      
<?php } ?>
                         
 


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
