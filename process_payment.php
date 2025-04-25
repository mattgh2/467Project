<?php
// Show all errors (for debugging; remove on production)
ini_set('display_errors', 1);
error_reporting(E_ALL);
include "utils.php";
require("dbconnect.php");
session_start();
$successfull = false;
?>

<?php
echo $_SERVER['REQUEST_METHOD'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sample vendor ID (replace with your actual assigned vendor ID)
    $vendorId = 'Sigmas';

    $quantities = $_POST['amounts'];
    $ids = $_POST['itemID'];
    $prices = $_POST['prices'];
    
    $itemQuantityMap = array();
    for ($i = 0; $i < sizeof($quantities); ++$i) {
        $itemQuantityMap[$ids[$i]] = [$quantities[$i],getProductFromID($pdoLegacy,$ids[$i]), $prices[$i]];
    }


    //POST data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $cc = $_POST['cc_number']; 
    $exp = $_POST['cc_exp']; 
    $amount = $_POST['amount']; 
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $shippingCost = $_POST['shippingCost'];

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
        $successfull = true;
        $customer_id = insert_customer_data($pdoInventory, $name, $email, $address, $city, $state, $zip);
        $order_id = insert_order($pdoInventory, $customer_id, $amount, $shippingCost);

        foreach($itemQuantityMap as $productID => $a) {
            insert_order_product($pdoInventory, $order_id, $productID, $a[0], $a[2]);
        }
        header('Location: ./order_complete.php?confirmation=' . urlencode($capture_space[1]) . "&email=" . urlencode($email));
        exit;
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
?>

