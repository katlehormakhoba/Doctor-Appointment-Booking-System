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
                            <li><a href="login.php">Log In</a></li>
                            <li class="selected-item"><a href="register.php">Patient</a></li>
                            <li ><a href="dreg.php">Doctor</a></li>
                            
                        </ul>

					</li>	
					
					
				</ul>
			</aside>
			<section id="content" class="column-right">
                		
	    <article>
				<?php
                              $name=$surname=$dob=$email=$cellno=$pwd=$cpwd=$hashp="";
                         
                              $ername=$ersurname=$erdob=$eremail=$ercellno=$erpwd=$ercpwd="";
                              $Tname=$Tsurname=$Tdob=$Temail=$Tcellno=$Tpwd=$Tcpwd=false;


                              if (isset($_POST['send'])) {
                                 
                              if (empty($_POST["name"])) {
                                $ername = "First Name is required";
                                $Tname=false;
                              } else {
                                $name = test_input($_POST["name"]);
                                $Tname=true;
                                // check if name only contains letters and whitespace
                                if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
                                  $ername = "Only letters and white space allowed";
                                  $Tname=false; 
                                }else{
                                    if(strlen($name)<2){
                                        $ername = "fisrtname is short";
                                        $Tname=false;

                                    }
                                }
                              }

                               if (empty($_POST["surname"])) {
                                $ersurname = "surname is required";
                                $Tsurname=false;
                              } else {
                                $surname = test_input($_POST["surname"]);
                                $Tsurname=true;
                                // check if name only contains letters and whitespace
                                if (!preg_match("/^[a-zA-Z ]*$/",$surname)) {
                                  $ersurname = "Only letters and white space allowed";
                                  $Tsurname=false; 
                                }else{
                                    if(strlen($surname)<2){
                                        $ersurname = "surname is short";
                                        $Tsurname=false;

                                    }
                                }
                              }
                              
                              

                                   //cellno
                              if (empty($_POST["cellno"])) {
                                $ercellno = "Contact number is required";
                                $Tcellno=false;
                              } else {
                                $cellno = test_input($_POST["cellno"]);
                                $Tcellno=true;
                                // check if name only contains letters and whitespace
                                if (!preg_match("/^[0-9]*$/",$cellno)) {
                                  $ercellno = "Only numbers allowed"; 
                                  $Tcellno=false;
                                }else{
                                    if(strlen($cellno)!=10){
                                        $ercellno = "contact number must be 10 digits";
                                        $Tcellno=false;

                                    }
                                }
                              }

                              

                             if (empty($_POST["email"])) {
                                $eremail= "Email is required";
                                $Temail=false;
                              } else {
                                $email = test_input($_POST["email"]);
                                $Temail=true;
                                // check if e-mail address is well-formed
                                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                  $eremail= "Invalid email format";
                                  $Temail=false; 
                                }else{
                                    $query="SELECT * FROM patient WHERE email='$email'";
                                    $result=mysqli_query($conn,$query);
                                     if(!$result){

                                      die("db access failed ".mysqli_error());
                                    }
                                      //get the number of rows of the executed query  
                                    $rows=mysqli_num_rows($result);
                                                
                              if($rows>0){
                                        $eremail ="email already registered";
                                        $Temail=false;
                                    }
                                }
                              
                               }
                               

                                
                                //1st password
                              if (empty($_POST["pwd"])) {
                                $erpwd = "Password is required";
                                $Tpwd=false;
                              } else {
                                $pwd = test_input($_POST["pwd"]);
                                $Tpwd=true;

                                    if(strlen($pwd)<8){
                                        $erpwd = "password must have at least 8 digits";
                                        $Tpwd=false;
                                        
                                    }
                                }
                                
                              
                                
                               //2nd password 
                             if (empty($_POST["cpwd"])) {
                                $ercpwd = "Password confirm is required";
                                $Tcpwd=false;
                              } else {
                                    $cpwd = test_input($_POST["cpwd"]);
                                    $hashp=password_hash($pwd,PASSWORD_DEFAULT);
                                    $Tcpwd=true;

                                    if (!password_verify($pwd,$hashp)){
                                            $ercpwd = "Password do match";
                                            $Tcpwd=false;
                                    }
                                    
                              }
                               if ($Tname&&$Tsurname&&$Temail&&$Tcellno&&$Tpwd&&$Tcpwd&&$hashp) {
                                          
                                                    //echo $staffno." ".;
                                         
                                                  $sql="insert into patient (name,surname,email,cellno,password)
                                                   values ('$name','$surname','$email','$cellno','$hashp')";
                                                  if(mysqli_query($conn,$sql))
                                                      {
                                                          echo '<script type="text/javascript">alert("You Succesfully Registered Please Login Your Account"); window.location = "login.php";</script>';
                                                          

                                                          
                                                      }else{die("<h3>unsuccessfully not registered </h3>".mysqli_error($conn)); }
                                                    
                                      }
                            }
                            
                          



                            function test_input($data) {
                              $data = trim($data);
                              $data = stripslashes($data);
                              $data = htmlspecialchars($data);
                              return $data;
                            }
                           


        ?>
			
				<h3>Registration Form</h3>
				<fieldset>

					<legend>Patient</legend>
					<form action="register.php" method="post">
                    <p><label for="name">Name:</label>
                    <input name="name" id="name" value="<?php echo $name;?>" type="text" /> <span class="error"><?php echo $ername;?></span> </p>
                   
                    

                    <p><label for="email">Surname:</label>
                    <input name="surname" id="surname" value="<?php echo $surname;?>" type="text" /> <span class="error"><?php echo $ersurname;?></span> </p>

                    <p><label for="name">Cell phone:</label>
                    <input name="cellno" id="cellno" value="<?php echo $cellno;?>" type="text" /> <span class="error"><?php echo $ercellno;?></span> </p>

                    <p><label for="email">Email:</label>
                    <input name="email" id="email" value="<?php echo $email;?>" type="email" /> <span class="error"><?php echo $eremail;?></span> </p>

                    <p><label for="name">Password:</label>
                    <input name="pwd" id="pwd" value="<?php echo $pwd;?>" type="password" /> <span class="error"><?php echo $erpwd;?></span> </p>

                    <p><label for="email">Confirm Password:</label>
                    <input name="cpwd" id="cpwd" value="<?php echo $cpwd;?>" type="password" /> <span class="error"><?php echo $ercpwd;?></span> </p>

                    <p><input name="send" style="margin-left: 150px;" class="formbutton" value="Send" type="submit" /></p>

                    
                </form>				</fieldset>
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
