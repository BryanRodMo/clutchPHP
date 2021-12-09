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
if(isset($_POST['save']))
{ 

if (!empty($_POST['radio'])) {
   $array = $_POST['radio'];
   $implArray  = implode('-',$array) ;
   $explArray = explode('-', $implArray);
   $i = 0;
   $status = 0;
   $count = count($explArray);
   $count = $count / 2;
   for($x = 0; $x < $count ; $x++)
   {

      $query = "INSERT INTO enrollments (student_id, course_id, section_id, status)
      VALUES (:student_id, :course_id, :section_id, :status)";

          $stmt = $pdo->prepare($query);
          $stmt->execute(array(
              ':student_id' => $_SESSION['id'],
              ':course_id' => $explArray[$i],
              ':section_id' => $explArray[$i + 1],
              ':status' => $status
          ));


          $query2 = "UPDATE  section SET capacity = capacity - 1
                   WHERE section_id = :section_id AND course_id = :course_id";

                       $stmt = $pdo->prepare($query2);
                       $stmt->execute(array(":section_id" => $explArray[$i + 1],":course_id" => $explArray[$i] ));
                       $i = $i + 2;

   }
   header('location: search_page.php');

}
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
$query=("delete enrollments
FROM enrollments
where enrollments.section_id=? && enrollments.course_id=? && enrollments.student_id=?");
$stmt=$pdo->prepare($query);
$stmt->execute([$_GET['sid'],$_GET['cid'], $_SESSION['id']]);
$_SESSION['delmsg']="Course deleted !!";
$sql2 = "UPDATE  section SET capacity = capacity + 1
        WHERE section_id = :section_id AND course_id = :course_id";
$stmt = $pdo->prepare($sql2);
$stmt->execute(array(":section_id" => $_GET['sid'],":course_id" => $_GET['cid'] ));
$i = $i + 2;
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

$cnt=1;
    

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
        
     $prev_row="TEST3000";
     $i=0;
     $query=("SELECT * FROM `section` where course_id like '%$searchrequest%'");
     $stmt = $pdo->prepare($query);
     $row = $stmt->execute();
    
            while($row= $stmt->fetch(PDO::FETCH_ASSOC))
     {
            $query=("SELECT * FROM `enrollments` where course_id=? && student_id=?");
            $stmt2 = $pdo->prepare($query);
            $stmt2->execute([$row['course_id'],$_SESSION['id']]);
            $check = $stmt2->fetch(PDO::FETCH_ASSOC);
          if ($row['course_id'] == $prev_row) {
              if(!empty($check)){
                            echo '<input type = "radio" name = "radio[ ' . $i . ' ]" value = "' . $row['course_id'] . '-' . $row['section_id'] . ' " disabled>';?>
          <label for="course"> <?php echo htmlentities($row['course_id']); ?> <?php echo htmlentities($row['section_id']); ?> </label><br>
        <?php }
              else{
          echo '<input type = "radio" name = "radio[ ' . $i . ' ]" value = "' . $row['course_id'] . '-' . $row['section_id'] . ' ">';?>
          <label for="course"> <?php echo htmlentities($row['course_id']); ?> <?php echo htmlentities($row['section_id']); ?> </label><br>
                           
    <?php }
        } else {
               if(!empty($check)){
                $i += 1;
                            echo '<input type = "radio" name = "radio[ ' . $i . ' ]" value = "' . $row['course_id'] . '-' . $row['section_id'] . ' " disabled>';?>
          <label for="course"> <?php echo htmlentities($row['course_id']); ?> <?php echo htmlentities($row['section_id']); ?> </label><br>
             <?php }
              else{
          $i += 1;
          echo '<input type = "radio" name = "radio[ ' . $i . ' ]" value = "' . $row['course_id'] . '-' . $row['section_id'] . '">';?>
          <label for="course"> <?php echo $row['course_id'].'-'.$row['section_id']; ?> </label><br>
                           <?php

        }}
        $prev_row = $row['course_id'];
        ?>
               
      <?php } ?>
    <button type="submit" name="save"  class="btn btn-default">Save</button>
     
  
    </form>
      
<?php } ?>
   
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
                                             
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
$query=("SELECT course.*, section.section_id, section.capacity
FROM `course` INNER JOIN section 
ON course.course_id = section.course_id 
INNER JOIN enrollments 
ON course.course_id = enrollments.course_id 
where enrollments.student_id=? && enrollments.status=0");
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
                                            
  <a href="search_page.php?sid=<?php echo $row['section_id']?>&cid=<?php echo$row['course_id'] ?>&del=delete" onClick="return confirm('Are you sure you want to drop request?')">
                                            <button class="btn btn-danger">Drop Request</button>
</a>
                                            </td>
                                            
                                            
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


</body>
</html>
<?php } ?>
