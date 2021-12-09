<?php
error_reporting(0);
?>
<?php if($_SESSION['login']!="")
{
$student_id=$_SESSION['login'];
?>
<header>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <strong>Welcome: </strong><?php echo htmlentities($_SESSION['sname']);?>
                    &nbsp;&nbsp;



                    <strong>Last Login:<?php
                    $query=("SELECT  * from userlog where student_id=? order by id desc limit 1,1");
                    $stmt=$pdo->prepare($query);
                    $stmt->execute([$student_id]);
                    $row= $stmt->fetchALL();
                    echo $row['userip']; ?> at <?php echo $row['loginTime'];?>
                   
                    
                    </strong>
                </div>

            </div>
        </div>
    </header>
    <?php } ?>

    <div class="navbar navbar-inverse set-radius-zero">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php" style="color:#fff; font-size:24px;4px; line-height:24px; ">

                   ONLINE COURSE   REGISTRATION
                </a>

            </div>

            <div class="left-div">
                <i class="fa fa-user-plus login-icon" ></i>
        </div>
            </div>
        </div>
