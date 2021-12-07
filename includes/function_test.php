<?php 
class prepare extends Dbh {

  public function getUsers($regno, $password){
    $sql = "SELECT * FROM student WHERE student_id=? and password = ?";
    $stmt = $this->connect()->query($sql);
    $stmt->execute([$regno, $password]);
    $names = $stmt->fetchALL();

      foreach($names as $name)
      { 
	echo $name['student_id']; 
      }
      	
    
    }
  }
}



?>
