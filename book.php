<?php
$conn = mysqli_connect("localhost","root","","doctor");

// Check connection
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
  session_start();
?>
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
        <?PHP
              
                $name=$surname=$cellno=$staffno="";

               if(isset($_SESSION['email']))
                {


                  $email=$_SESSION['email'];

                  $query="select * FROM patient WHERE email='$email'";
                  $result=mysqli_query($conn,$query);
                  $rows=mysqli_num_rows($result);
                  while ($rows=mysqli_fetch_array($result)) {
                  
                    
                     $staffno = $_SESSION['patient_id']= $rows['patient_id']; 
                     $name = $_SESSION['name']= $rows['name'];  
                     $surname = $_SESSION['surname']= $rows['surname'];
                     //$dob = $_SESSION['dob']= $rows['dob']; 
                     $cellno = $_SESSION['cellno']=$rows['cellno'];
                     
                  
                  }
                }
                  ?>


				<nav>
					<ul>
        					<li><a href="pat.php">Home</a></li>
        	    				
         	   				<li class="start selected end"><a href="#"><?php echo $name." ".$surname;?></a></li>
          	  				
        				</ul>
				</nav>
	
				<div class="clear"></div>
			</div>
		</div>
		<header>
			<div class="width">
        

				<h2> Welcome to my Doctor Appointment Booking System!</h2>		
			</div>
		</header>
		<section id="body" class="width clear">
			<aside id="sidebar" class="column-left">
				<ul>
                	<li>
						<h4>Navigate</h4>
                        <ul class="blocklist">
                            <li  class="selected-item"><a href="pat.php">Home</a></li>
                            <li ><a href="ap.php">Book Appointment</a></li>
                            <li><a href="logout.php">Log out</a></li>
                            
                        </ul>

					</li>	
					
					
				</ul>
			</aside>
			<section id="content" class="column-right">
                		
	    <article>
				<?php
                              $doc_id=$_GET['edt'];
                              $name=$surname=$dob=$email=$cellno=$pwd=$cpwd=$hashp="";
                         
                              $ername=$ersurname=$erdob=$eremail=$ercellno=$erpwd=$ercpwd="";
                              $Tname=$Tsurname=$Tdob=$Temail=$Tcellno=$Tpwd=$Tcpwd=false;


                              if (isset($_POST['send'])) {
                                 
                              if (empty($_POST["name"])) {
                                $ername = "Date and Time is required";
                                $Tname=false;
                              } else {
                                $name = test_input($_POST["name"]);
                                $Tname=true;
                                $s=date_create($name);
                                $d=date_format($s,"Y-m-d");
                                $sytdate=date("Y-m-d");
                                if ($d<$sytdate) {
                                  $ername = "Date and Time is invalid";
                                $Tname=false;
                                }
                                
                                
                              }

                               if (empty($_POST["surname"])) {
                                //$ersurname = "surname is required";
                                $Tsurname=false;
                                $surname="N/A";
                              } else {
                                $surname = test_input($_POST["surname"]);
                                $Tsurname=true;
                                // check if name only contains letters and whitespace
                                
                              }
                              
                              

                                   //cellno
                              if (empty($_POST["cellno"])) {
                                $ercellno = "Type of Doctor is required";
                                $Tcellno=false;
                              } else {
                                $cellno = test_input($_POST["cellno"]);
                                $Tcellno=true;

                                
                              }

                              

                             if (empty($_POST["email"])) {
                                $eremail= "Payment Type is required";
                                $Temail=false;
                              } else {
                                $email = test_input($_POST["email"]);
                                $Temail=true;
                                // check if e-mail address is well-formed
                                
                              
                               }
                               

                                
                               if ($Tname&&$Tsurname&&$Temail) {
                                          
                                                    //echo $staffno." ".;
                                         
                                                  $sql="insert into appointment (date,info,payment,patient_id,doctor_id)
                                                   values ('$name','$surname','$email','$staffno','$doc_id')";
                                                  if(mysqli_query($conn,$sql))
                                                      {
                                                          echo '<script type="text/javascript">alert("You Succesfully Booked an Appointment"); window.location = "pat.php";</script>';
                                                          

                                                          
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

            <fieldset>
                <legend>Book Appointment</legend>
                <form action="book.php?edt=<?php echo $doc_id;?>" method="post">
                    <p><label for="name">Date and Time:</label>
                    <input name="name" id="name" value="<?php echo $name;?>" type="datetime-local" /> <span class="error"><?php echo $ername;?></span> </p>
                   
                    

                    <p><label for="email">Additional info:</label>
                    <input name="surname" id="surname" value="<?php echo $surname;?>" type="text" /> <span class="error"><?php echo $ersurname;?></span> </p>

                   
                  

                    <p><label for="email">Payment Type:</label>
                    
                    <select name="email">
                      <option>Medical Aid</option>
                      <option>Cash</option>
                      <option>Card</option>
                    </select>
                    <span class="error"><?php echo $eremail;?></span>
                  </p>

                    

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
