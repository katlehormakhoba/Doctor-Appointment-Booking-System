<?php
$conn = mysqli_connect("localhost","root","","doctor");

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
  session_start();
?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Doctor</title>
<!--[if lt IE 9]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!--
afflatus, a free CSS web template by ZyPOP (zypopwebtemplates.com/)

Download: http://zypopwebtemplates.com/

License: Creative Commons Attribution
//-->
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
<link rel="stylesheet" href="styles.css" type="text/css" />
<style type="text/css">
 .error {color: #FF0000;}
 </style>
</head>

<body>

		<div id="sitename">
			<div class="width">
				<h1><a href="#">Doctor Reservation System</a></h1>


				<nav>
					<ul>
        					<li><a href="index.php">Home</a></li>
        	    				
          	  				
        				</ul>
				</nav>
	
				<div class="clear"></div>
			</div>
		</div>
		<header>
			<div class="width">
				<h2>Welcome to my Doctor Appointment Booking System!</h2>		
			</div>
		</header>
		<section id="body" class="width clear">
			<aside id="sidebar" class="column-left">
				<ul>
                	<li>
						<h4>Navigate</h4>
                        <ul class="blocklist">
                            <li><a href="index.php">Home</a></li>
                            <li ><a href="login.php">Log In</a></li>
                            <li class="selected-item"><a href="dlogin.php">Doctor Log In</a></li>
                            <li ><a href="register.php">Patient</a></li>
                            <li ><a href="dreg.php">Doctor</a></li>
                            
                        </ul>

					</li>	
					
					
				</ul>
			</aside>
			<section id="content" class="column-right">
                		
	    <article>
				<?php
                                // define variables and set to empty values

                             
                            $emailErr = $err = $erpwd ="";
                              $email = $pwd ="";
                              $Temail = $Tpwd =false;
                                
                            if (isset($_POST['send'])) {

                              
                              //email
                              if (empty($_POST["email"])) {
                                $emailErr = "Email is required";
                                $Temail=false;
                              } else {
                                $email = test_input($_POST["email"]);
                                $Temail=true;
                                // check if e-mail address is well-formed
                                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                  $emailErr = "Invalid email format";
                                  $Temail=false; 
                                }
                              }
                               
        
                               
                               //2nd password 
                             if (empty($_POST["pwd"])) {
                                $erpwd = "Password is required";
                                $Tpwd=false;
                              } else {

                                   $pwd = test_input($_POST["pwd"]);
                                   $Tpwd=true;
                                   
                                }
                                 if ($Tpwd && $Temail) {
                                     
                                   
                                    $query="SELECT * FROM doctor WHERE email='$email'";
                                    $result=mysqli_query($conn,$query);

                                    if(!$result)
                                    {
                                      $err="unable to connect to database";
                                       mysqli_error($conn);
                                    }else{
                                        $rows=mysqli_num_rows($result);
                                        if($rows<1)
                                        {
                                            $erpwd="username or password doesnt exsist";
                                    
                                        }else{
                                                

                                                while ($rows=mysqli_fetch_assoc($result)) 
                                                    {
                                                        $cpwd=$rows['password'];
                                                        
                                                        //!password_verify('$passwd',$cpwd) !hash_equals('$passwd',$cpwd)
                                        

                                                        if (!password_verify($pwd,$cpwd)) {
                                                            $err="incorect email or password ";
                                                        }else{
                                                            $_SESSION['email']=$rows['email'];
                                                            echo '<script> window.location = "dr.php";</script>';
                                                            
                                                          }
                          
                                                            
                                                            
                                                            
                                                                            
                                                        }


                                                
                                                    }

                                            }
                                        }
                                      
                                    }

                            function test_input($data) {
                              $data = trim($data);
                              $data = stripslashes($data);
                              $data = htmlspecialchars($data);
                              return $data;
                            }
                           
                            ?> 
			
				<h3>Log In Form</h3>
				<fieldset>

					<legend>Doctor</legend>
					<form action="dlogin.php" method="post">
                    
                    <p><label for="email">Email:</label>
                    <input name="email" id="email" value="<?php echo $email;?>" type="email" /><span class="error"><?php echo $emailErr;?></span></p>
                    
                    <p><label for="name">Password:</label>
                    <input name="pwd" id="pwd" value="<?php echo $pwd;?>" type="Password" /><span class="error"><?php echo $erpwd;?></span></p>
                    

                    <p><input name="send" style="margin-left: 150px;" class="formbutton" value="Send" type="submit" /></p>

                </form>
	
				</fieldset>
			</article>
		</section>

	</section>
	
		<footer class="clear">
			<div  class="width">
				<p class="left">&copy; 2020 sitename.</p>
				
			</div>
		</footer>
</body>
</html>
