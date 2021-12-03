<?php

    function connectDB(){    
        try{ 
            $pdoObj = new PDO('mysql:host=136.145.29.193; dbname=bryrodmo_db','bryrodmo','bryccom840');  
            return $pdoObj;         
        }        
 catch(PDOException $e){       
    echo $e->getMessage();                     
     return false;         
     }    
} ?>