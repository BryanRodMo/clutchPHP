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
                                           <td><strong>#</strong></td>
                                           <td><strong>Course Name </strong></td>
                                           <td><strong>Title</strong></td>
                                           <td><strong>Section</strong></td>
                                           <td><strong>status</strong></td>
					    
                                             <!--<th>Action</th>-->
                                        </tr>
                                    </thead>
                                    <tbody>
<?php
$query=("SELECT * FROM enrollments");
     $stmt7=$pdo->prepare($query);
     $stmt7->execute();
$cnt=1;
while($row = $stmt7->fetch(PDO::FETCH_ASSOC))
{
?>


                                        <tr>
                                            <td><?php echo $cnt;?></td>
                                            <td><?php echo htmlentities($row['student_id']);?></td>
                                            <td><?php echo htmlentities($row['course_id']);?></td>
                                             <td><?php echo htmlentities($row['section_id']);?></td>
<?php						                 switch($row['status']){
    case '0':
?>  <td><?php echo "PENDING";?></td> <?php
        break;
    case '1':
        ?>  <td><?php echo "SUCCESSFUL";?></td> <?php
        break;
    case '2':
        ?>  <td><?php echo "UNSUCCESSFUL";?></td> <?php
        break;
        
        ?>
                                                
                                       <?php } ?>
                                        </tr>            


 
<?php 
$cnt++;
} ?>

                                                
                                                       
                                        
                                    </tbody>
                                </table>
                                <div class="panel-body">
                                    <form name="enroll" method="post">
                                <a>
                                    <button name="enroll" type="submit" value="enroll" class="btn btn-primary"><i class=" fa fa-refresh "></i> ENROLL</button> </a></form> </div>
                                
                          
                           <?php
if(isset($_POST['enroll']))
{

    for($i = 5; $i > 0 ; $i--){
        
        $query=("SELECT student_id FROM `student` where year_of_study='$i'"); //grab students from each year of study
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        while($row= $stmt->fetch(PDO::FETCH_ASSOC)){
            
        $query=("SELECT enrollments.student_id, section.* FROM `section` inner join enrollments on section.section_id = enrollments.section_id  where enrollments.student_id=? && enrollments.status='0' having section.capacity>0"); //get student_id, courses and sections of student that hasn't enroll
        $stmt2 = $pdo->prepare($query);
        $stmt2->execute([$row['student_id']]);
        while($check2= $stmt2->fetch(PDO::FETCH_ASSOC)){

        $query=("UPDATE enrollments set status=1 where student_id=? && course_id=? && section_id=?"); // update the ones with capacity available to 1
        $stmt3=$pdo->prepare($query);
        $stmt3->execute([$check2['student_id'],$check2['course_id'],$check2['section_id']]);
        
        
        $query2 = "UPDATE section SET capacity = capacity - 1
                   WHERE section_id =? AND course_id = ?"; // update the capacity of the students that did enroll
        $stmt4 = $pdo->prepare($query2);
        $stmt4->execute([$check2['section_id'],$check2['course_id']]);
                    
                }
        
                    
        }
    }
        $query=("UPDATE enrollments set status=2 where status=0"); // update the ones with no capacity available to 2
        $stmt=$pdo->prepare($query);
        $stmt->execute();
}
     
?>      
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
