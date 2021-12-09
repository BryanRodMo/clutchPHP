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
$id=$_GET['id'];
$section_id=$_GET['sec_id'];

if(isset($_POST['submit']))
{
$capacity=$_POST['seatlimit'];
$newsection_id=$_POST['section_id'];


$query=("UPDATE section
set section_id=?, capacity=?
where course_id='$id' && section_id='$section_id'");
$stmt=$pdo->prepare($query);
$stmt->execute([$newsection_id,$capacity]);
$ret=$stmt;
if($ret)
{

$_SESSION['msg']="Course Updated Successfully !!";
}
else
{
  $_SESSION['msg']="Error : Course not Updated";
}
}
if(isset($_POST['addsec']))
{
$capacity=$_POST['seatlimit'];
$newsection_id=$_POST['section_id'];
$section_id=$_POST['section_id'];


$query=("insert into section (course_id,section_id,capacity)
        values(:coursecode,:coursesection,:capacity)");
$stmt=$pdo->prepare($query);
$stmt->bindParam('coursecode',$id);
$stmt->bindParam('coursesection',$newsection_id);
$stmt->bindParam('capacity',$capacity);
$ret=$stmt->execute();;
if($ret)
{
$_SESSION['msg']="Section Created Successfully !!";
}
else
{
  $_SESSION['msg']="Error : Course not Created";
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
<?php
$query=("SELECT course.*, section.section_id, section.capacity FROM `course` INNER JOIN section ON course.course_id = section.course_id where section.course_id='$id' && section.section_id='$section_id'");
$stmt=$pdo->prepare($query);
$stmt->execute(); 
$cnt=1;
while($row=$stmt->fetch(PDO::FETCH_ASSOC))
{
?>
   <div class="form-group">
    <label for="coursecode">Course Code  </label>
    <input type="text" class="form-control" id="coursecode" name="coursecode" placeholder="Course Code" value="<?php echo htmlentities($row['course_id']);?>" readonly required />
  </div>

 <div class="form-group">
    <label for="coursename">Course Name  </label>
    <input type="text" class="form-control" id="coursename" name="coursename" placeholder="Course Name" value="<?php echo htmlentities($row['title']);?>" readonly required />
  </div>

<div class="form-group">
    <label for="courseunit">Credits</label>
    <input type="text" class="form-control" id="courseunit" name="courseunit" placeholder="Course Credits" value="<?php echo htmlentities($row['credits']);?>" readonly required />
  </div>  
<div class="form-group">
    <label for="Section">Section</label>
    <input type="text" class="form-control" id="Section" name="section_id" placeholder="Section" value="<?php echo htmlentities($row['section_id']);?>" required />
  </div>  

<div class="form-group">
    <label for="seatlimit">Capacity  </label>
    <input type="text" class="form-control" id="seatlimit" name="seatlimit" placeholder="Seat limit" value="<?php echo htmlentities($row['capacity']);?>" required />
  </div>  


<?php } ?>
 <button type="submit" name="addsec" class="btn btn-default"><i class=" fa fa-edit "></i> Add Section</button>
<button type="submit" name="submit" class="btn btn-default"><i class=" fa fa-refresh "></i> Update</button>

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
</body>
</html>
<?php } ?>
