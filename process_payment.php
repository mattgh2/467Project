<?php
// Show all errors (for debugging; remove on production)
ini_set('display_errors', 1);
error_reporting(E_ALL);
include "utils.php";
require("dbconnect.php");
?>

<?php
var_dump($_POST);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sample vendor ID (replace with your actual assigned vendor ID)
    $vendorId = 'Sigmas';

    $quantities = $_POST['amounts'];
    $descriptions = $_POST['descriptions'];
    
    $itemQuantityMap = array();
    for ($i = 0; $i < sizeof($quantities); ++$i) {
        $itemQuantityMap[$descriptions[$i]] = $quantities[$i];
    }

    print_r($itemQuantityMap);

    //ST data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $cc = $_POST['cc_number']; // Make sure your form includes this field
    $exp = $_POST['cc_exp']; // Add this field to the form if missing
    $amount = $_POST['amount']; // Also add this field if missing

    // You can also validate and sanitize inputs here

    // Create a unique transaction ID
    $transactionId = uniqid('trans-', true);

    // Build JSON payload
    $payload = array(
        'vendor' => $vendorId,
        'trans' => $transactionId,
        'cc' => $cc,
        'name' => $name,
        'exp' => $exp,
        'amount' => $amount
    );

    // Send POST request to payment server
    $url = 'http://blitz.cs.niu.edu/CreditCard/';
    $options = array(
        'http' => array(
            'header' => array('Content-type: application/json', 'Accept: application/json'),
            'method' => 'POST',
            'content'=> json_encode($payload)
        )
    );
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    $re = "/.*errors\":\[\"(.*)\"].*/";
    $re2 = "/.*authorization\":\"(.*)\",.*/";

    if (preg_match($re, $result, $capture_space)) {
        echo "<h2 style='color:red;'>Payment Error:</h2><p  class='text-5xl'>$capture_space[1]</p>";
    } else if (preg_match($re2, $result, $capture_space)) {
        echo "<h2 style='color:green;'>Payment Authorized!</h2><p>Authorization Number: $capture_space[1]</p>";
        $customer_id = insert_customer_data($pdoInventory, $name, $email, $address);
        $order_id = insert_order($pdoInventory, $customer_id);
    } else {
        echo "Error";
    }
} else {
    echo "Invalid request method.";
}


//      1. credit card auth (payment processing system) -- COMPLETE
//      2. alert that an email was sent.
//      4. Clear js sessionStorage
//      5. Put order in orders DB 
//      6. Update quantity in Product DB


//      3. Put customer details in customers DB 
// INsert customer name, email, address into Customer,
// Insert CustomerId, orderDate,orderStatus into Orders
// Insert orderID ProductID into OrderProduct