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
        <?PHP
              
                $name=$surname=$cellno=$staffno="";

               if(isset($_SESSION['email']))
                {


                  $email=$_SESSION['email'];

                  $query="select * FROM doctor WHERE email='$email'";
                  $result=mysqli_query($conn,$query);
                  $rows=mysqli_num_rows($result);
                  while ($rows=mysqli_fetch_array($result)) {
                  
                    
                     $staffno = $_SESSION['doctor_id']= $rows['doctor_id']; 
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
                            <li  class="selected-item"><a href="dr.php">Home</a></li>
                            <li ><a href="p.php">Patients</a></li>
                            <li><a href="logout.php">Log out</a></li>
                            
                        </ul>

					</li>	
					
					
				</ul>
			</aside>
			<section id="content" class="column-right">
                		
	    <article>
				<?PHP
                  $query="SELECT patient.name as name,patient.surname as surname,patient.email as email,appointment.date as date,appointment.info as info,appointment.payment as payment FROM appointment,patient where patient.patient_id=appointment.patient_id and appointment.doctor_id='$staffno'";
                  $result=mysqli_query($conn,$query);
                  $rows=mysqli_num_rows($result);
                  
                 
                  
                  if ($rows>0) {
                    
                    ?>
                    <h3>Appointment</h3>
                    <table cellspacing="0">
                    <tr>
                      <th>Booked by</th>
                        <th>Date and Time</th>
                        <th>Additional info</th>
                        
                        <th>Payment Type</th>
                        <th></th>
                    </tr>
                    <?php
                    while ($rows=mysqli_fetch_array($result)) {
                  ?>
                    
                     
                    <tr>
                      <td><?php echo $rows['name']." ".$rows['surname'];?></td>
                    <td><?php echo $rows['date'];?></td>
                    <td><?php echo $rows['info'];?></td>
                    
                    <td><?php echo $rows['payment'];?></td>
                    <th><p style="color: white;"><a class="button button-reversed" href="cancel.php?edt=<?php echo $rows['appoint_id'];?>" >Remove</a></p></th>
                   </tr>
                     <?php
                  
                    }
                    ?>
                    </table>
                    <?php
                  }else{
                    ?>
                    <h3>You don't have any Appointment(s)</h3>
                    <?php
                  }
                  
                
                  ?>
  
				
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
