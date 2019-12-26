<?php

	$conn = mysqli_connect("localhost", "root", "");
	$db=mysqli_select_db($conn,"fuerte");
	
	$qry="select * from donate where orderid = '".$_GET['id']."'";
	$result=mysqli_query($conn,$qry);
	
	?>
	<html lang="en">
<head>
  
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

</head>
<body>
<div class="contanier">
	<div class="row">
		<div class="col-sm-12">
  <table class="table table-striped" border="1" style="width:600px;height:250px;margin-top:150px;margin-left:340px;border-width:  4px;box-shadow: 5px 10px #888888;">
    
    <tbody>
      <tr>
         
        <td style="background-color:lightgreen;text-align:center;padding-top:30px;"><b>Your Payment 
Successful</b></td>
        <td style="background-color:lightgreen;text-align:center;padding-top:30px;"><b>
Successful</b></td>
       
      </tr>
	  <?php while ($row = mysqli_fetch_assoc($result)){ ?>
      <tr>
        
        <td >Your Order Id</td>
        <td><?php echo  $row['orderid'];?></td>
      </tr>

      <tr>
       
        <td>Date</td>
        <td><?php echo  $row['date'];?></td>
      </tr>
      <tr>
       
        <td>Amount</td>
        <td><?php echo $row['amount'];?></td>
      </tr>
      <?php
		}	
?>
	  <tr >
		<td colspan="2" style="text-align:center;padding-top:30px;"><center><b>Thank you For Donate</b></center></td>
	  </tr>
	  <tr >
		<td colspan="2"style="background-color:lightgreen;padding-top:30px;" ><center><a href='http://localhost/fuerte/razorpay-php/NEW/razorpay-php-testapp-master/razorpay-php-testapp-master/index.php' style="font-size:20px;text-align:center;"><b style="color:black;">Back Home</b></a></center></td>
    
	  </tr>
    </tbody>
  </table>
  
  </div>
  </div>
</div>

</body>
</html>
	