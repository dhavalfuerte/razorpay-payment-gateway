
<?php

require('config.php');
require('razorpay-php/Razorpay.php');
session_start();

if($_POST['amount']==0)
{
		header('Location: index.php');
}
// Create the Razorpay Order

use Razorpay\Api\Api;

$api = new Api($keyId, $keySecret);

//
// We create an razorpay order using orders api
// Docs: https://docs.razorpay.com/docs/orders
//
$orderData = [
    'receipt'         => "ORDS" . rand(10000,99999999),
    'amount'          => $_POST['amount']*100, // 2000 rupees in paise
    'currency'        => 'INR',
    'payment_capture' => 1 // auto capture
];?>
<html lang="en">
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
 <style>
  .button {
  background-color: #4CAF50; /* Green */
  border: none;
  border-radius:20px;
  color: white;
  padding: 16px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 12px 2px;
  box-shadow: 5px 8px 5px #888888;
  margin-left:500px;
 -webkit-transition-duration: 0.4s; /* Safari */
  transition-duration: 0.4s;
  cursor: pointer;
  
}

.button1 {
  background-color: white; 
  color: black; 
  border: 2px solid #4CAF50;
}

.button1:hover {
  background-color: #4CAF50;
  color: white;
}
  </style>
  
</head>
<body>
<table class="table table-striped" border="1" style="width:600px;
  height:250px;margin-top:150px;margin-left:340px;box-shadow:5px 8px #888888;text-align:center;">
    <thead>
      <tr>
        <th style="padding:10px;font-size: 20px;background-color:LightGreen  ;color:black;">S.No</th>
        <th style="padding:10px;font-size: 20px;background-color:LightGreen  ;color:black;">Label</th>
        <th style="padding:10px;font-size: 20px;background-color:LightGreen  ;color:black;">Value</th>
      </tr>
    </thead>
    <tbody>
      <tr>
          <td>1</td>
        <td>Name *</td>
        <td><?php echo $_POST['first_name'].''.$_POST['last_name'];?></td>
       
      </tr>
      <tr>
        <td>2</td>
        <td>Email *</td>
        <td><?php echo  $_POST['email'];?></td>
      </tr>

      <tr>
        <td>3</td>
        <td>Mobile No *</td>
        <td><?php echo $_POST['phone'];?></td>
      </tr>
      <tr>
        <td>4</td>
        <td>Amount *</td>
        <td><?php echo  $_POST['amount'];?></td>
        
      </tr>
    </tbody>
  </table>
 
</body>
</html><?php

$razorpayOrder = $api->order->create($orderData);

$razorpayOrderId = $razorpayOrder['id'];

$_SESSION['razorpay_order_id'] = $razorpayOrderId;
$_SESSION['name']=$_POST['first_name'].' '.$_POST['last_name'];
$_SESSION['mobileno']=$_POST['phone'];
$_SESSION['email']=$_POST['email'];
$_SESSION['amount']=$_POST['amount'];



$displayAmount = $amount = $orderData['amount'];

if ($displayCurrency !== 'INR')
{
    $url = "https://api.fixer.io/latest?symbols=$displayCurrency&base=INR";
    $exchange = json_decode(file_get_contents($url), true);

    $displayAmount = $exchange['rates'][$displayCurrency] * $amount / 100;
}

$checkout = 'automatic';



$data = [
    "key"               => $keyId,
    "amount"            => $amount,
    "name"              => "name",
    "description"       => "description",
    "image"             => "logo",
    "prefill"           => [
    "name"              => $_POST['first_name'].''.$_POST['last_name'],
    "email"             => $_POST['email'],
    "contact"           => $_POST['phone'],
    ],
    "notes"             => [
    "address"           => "Hello World",
    "merchant_order_id" => rand(10000,99999999),
    ],
    "theme"             => [
    "color"             => "#F37254"
    ],
    "order_id"          => $razorpayOrderId,
];

if ($displayCurrency !== 'INR')
{
    $data['display_currency']  = $displayCurrency;
    $data['display_amount']    = $displayAmount;
}

$json = json_encode($data);

require("automatic.php");
