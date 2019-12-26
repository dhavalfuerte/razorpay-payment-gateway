<?php

require('config.php');

session_start();

require('razorpay-php/Razorpay.php');
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

$success = true;

$error = "Payment Failed";

if (empty($_POST['razorpay_payment_id']) === false)
{
    $api = new Api($keyId, $keySecret);

    try
    {
        // Please note that the razorpay order ID must
        // come from a trusted source (session here, but
        // could be database or something else)
        $attributes = array(
            'razorpay_order_id' => $_SESSION['razorpay_order_id'],
            'razorpay_payment_id' => $_POST['razorpay_payment_id'],
            'razorpay_signature' => $_POST['razorpay_signature']
        );
		
        $api->utility->verifyPaymentSignature($attributes);
    }
    catch(SignatureVerificationError $e)
    {
        $success = false;
        $error = 'Razorpay Error : ' . $e->getMessage();
		echo "<a href='http://localhost/fuerte/razorpay-php/NEW/razorpay-php-testapp-master/razorpay-php-testapp-master/index.php'>back</a>";
    }
}

if ($success === true)
{
	$conn = mysqli_connect("localhost", "root", "");
			$db=mysqli_select_db($conn,"fuerte");
			$qry="INSERT INTO `donate`(`name`, `email`, `mobileno`, `orderid`, `paymentid`, `signature`,amount,date) VALUES 
			('".$_SESSION['name']."','".$_SESSION['email']."','".$_SESSION['mobileno']."','".$_SESSION['razorpay_order_id']."','"
			.$_POST['razorpay_payment_id']."','". $_POST['razorpay_signature']."','". $_SESSION['amount']."','".date("Y-m-d")."');";
			echo $qry;
			mysqli_query($conn,$qry);
			
			header('Location: disp.php?id='.$_SESSION['razorpay_order_id']);
			
    $html = "<p>Your payment was successful</p>
             <p>Payment ID: {$_POST['razorpay_payment_id']}</p>
			 <a href='http://localhost/fuerte/razorpay-php/NEW/razorpay-php-testapp-master/razorpay-php-testapp-master/index.php'>back</a>
			 ";
			 
}
else
{?>
		<html lang="en">
		<head>
		  		  <meta charset="utf-8">
		  <meta name="viewport" content="width=device-width, initial-scale=1">
		  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
		<style>

		</style>
		</head>
		<body>

		  <table class="table table-striped" border="1" style="width:600px;height:250px;">
			
			<tbody>
			  <tr>
				 
				<td>Your Payment Failed</td>
			
			   
			  </tr>
			  <tr><td>Please Back Then Again Donate</td></tr>
			  <tr >
				<td colspan="2" ><center><a href='http://localhost/fuerte/razorpay-php/NEW/razorpay-php-testapp-master/razorpay-php-testapp-master/index.php'>back</a></center></td>
			  </tr>
			</tbody>
		  </table>
		  
		</div>

		</body>
		</html>
	<?php 		
}
?>

