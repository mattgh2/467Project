<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
session_start();
require_once("dbconnect.php");
require_once('utils.php');

if (
  $_SERVER['REQUEST_METHOD'] === 'POST'
  && isset($_POST['orderID'])
  && isset($_POST['action'])
  && $_POST['action'] === 'mark_fulfilled'
) {
  header('Content-Type: application/json');
  $stmt = $pdoInventory->prepare(
    "UPDATE Orders
     SET orderStatus = 'Shipped'
     WHERE orderID = :id"
  );
  if ($stmt->execute([':id' => $_POST['orderID']])) {
    echo json_encode(['success' => true]);
  } else {
    $err = $stmt->errorInfo()[2] ?? 'Unknown error';
    echo json_encode(['success' => false, 'error' => $err]);
  }
  exit;
}

$orders = get_orders($pdoInventory);
$products_in_orders = array();
foreach($orders as $order) {
  $stuff = get_name_qty_and_price($pdoInventory, $order['orderID']);
  $products_in_orders[$order['orderID']] = $stuff;
}

$other_order_stuff = array();
foreach($orders as $order) {
  $other_order_stuff[$order['orderID']] = [$order['amount'], $order["ShippingCost"]];
}

?>


<script>
  let encoded = <?php echo json_encode($products_in_orders); ?>;
  sessionStorage.setItem("details", JSON.stringify(encoded));

  let encoded_order = <?php echo json_encode($other_order_stuff); ?>;
  sessionStorage.setItem("other", JSON.stringify(encoded_order));
</script>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Order Fulfillment | Lite Up Ur Lyfe Auto Parts</title>
  <link rel="stylesheet" href="./public/css/output.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body class="bg-gradient-to-br from-blue-50 via-blue-100 to-blue-50 min-h-screen font-sans">

  <!-- Navbar -->
  <nav class="fixed top-0 left-0 z-50 w-full shadow-md">
    <div class="flex items-center justify-between px-6 h-16 bg-gradient-to-bl from-[#9dd8f8] via-[#55baf2] to-[#9dd8f8]">
      <a href="./" class="text-white text-2xl">
        <i class="fa fa-home"></i>
      </a>
      <ul class="flex gap-6 text-white text-lg">
        <li class="group relative">
          <a class="cursor-pointer">
            <i class="fa fa-lock"></i> Warehouse
            <span class="absolute left-1/2 bottom-0 h-0.5 w-0 bg-white transition-all group-hover:w-full group-hover:left-0"></span>
          </a>
        </li>
      </ul>
    </div>
  </nav>

  <!-- Page Content -->
  <main class="pt-24 px-4 max-w-4xl mx-auto">
    <h1 class="text-4xl font-bold text-center text-blue-500 mb-10">Order Fulfillment</h1>

    <!-- Order List -->
    <section class="space-y-4">
      <?php
      try {
        $stmt = $pdoInventory->query("SELECT * FROM Orders");

        while ($order = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $id = htmlspecialchars($order['orderID']);
          $date = htmlspecialchars($order['orderDate']);
          $status = htmlspecialchars($order['orderStatus']);
          $customerID = getCustomerIDfromOrderId($pdoInventory,$order['orderID']);
          $customerInfo = getCustomerInfo($pdoInventory, $customerID);

          // Default image
          $imageURL = "./public/images/box-icon.png";

          // Get first product from order
          $productStmt = $pdoInventory->prepare("SELECT productID FROM OrderProduct WHERE orderID = :id LIMIT 1");
          $productStmt->execute(['id' => $id]);
          $productRow = $productStmt->fetch(PDO::FETCH_ASSOC);

          if ($productRow) {
            $productID = $productRow['productID'];

            // Get image from legacy DB
            $legacyStmt = $pdoLegacy->prepare("SELECT pictureURL FROM parts WHERE number = :num");
            $legacyStmt->execute(['num' => $productID]);
            $legacyRow = $legacyStmt->fetch(PDO::FETCH_ASSOC);

            if ($legacyRow && !empty($legacyRow['pictureURL'])) {
              $imageURL = htmlspecialchars($legacyRow['pictureURL']);
            }
          }

          echo "
<div class='bg-white rounded-xl shadow-md flex flex-row p-4 gap-6'>
  <!-- Image from Legacy DB -->
  <div class='w-32 h-32 bg-center bg-contain bg-no-repeat' style='background-image: url(\"$imageURL\")'></div>

  <!-- Order Details and Button -->
  <div class='flex flex-col justify-between w-full'>
    <div>
      <p class='text-lg font-semibold text-blue-500'>Order ID: {$id}</p>
      <p class='text-gray-700'>Order Date: {$date}</p>
      <p class='text-gray-700'>Status: {$status}</p>
    </div>
    <div class='flex justify-end'>
      <button 
      onclick=printInvoice(this) 
      class='px-4 py-2 bg-blue-400 text-white rounded-lg hover:bg-green-500 transition-colors duration-200'
      data-customerName='$customerInfo[customerName]'
      data-customeraddr='$customerInfo[addr]'
      data-customercity='$customerInfo[City]'
      data-customerstate='$customerInfo[State]'
      data-customerzip='$customerInfo[Zip]'
      data-customeremail='$customerInfo[email]'
      >
      Complete Order
      </button>
    </div>
  </div>
</div>";
        }
      } catch (PDOException $e) {
        echo "<p class='text-red-500'>Error fetching orders: >" . $e->getMessage() . "</p>";
      }
      ?>
    </section>
  </main>
<script>

  function printInvoice(el) {

    let dim = document.createElement('div');
    dim.className = "fixed inset-0 bg-black bg-opacity-50 opacity-60 z-40";
    document.body.appendChild(dim);

    let invoice = document.createElement('div');
    invoice.className = " bg-white w-1/3 h-[600px] rounded-md shadow-md absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 z-60"; 
    document.body.appendChild(invoice);

    let back = document.createElement('div');
    back.className = "w-8 h-8 bg-red-600 text-white text-center rounded-md shadow-md flex justify-center items-center mt-1 mr-1 cursor-pointer";
    back.innerHTML = '<i class="fa text-center fa-times" aria-hidden="true"></i>';

    let order_back_container = document.createElement("div");
    order_back_container.className = 'w-full h-[10%] flex';

    let order_number_container = document.createElement("div");
    order_number_container.className = 'w-[65%] h-full flex  justify-end items-center';

    let back_container = document.createElement("div");
    back_container.className = 'w-[35%] h-full flex justify-end';

    let order_number = document.createElement("p");
    order_number.className = 'text-lg';
    let id = el.parentNode.previousElementSibling.childNodes[1].innerText.substring(10);
    order_number.innerText = 'Order Number: ' + id;

    let packing_list_container = document.createElement("div");
    packing_list_container.className = 'w-full pb-5';

    let packing_list_text = document.createElement("p");
    packing_list_text.className = 'text-lg font-bold text-slate-900 tracking-wide drop-shadow-xs px-3 mb-[2%]';
    packing_list_text.innerText = "Packing List:";
    packing_list_container.appendChild(packing_list_text);

    let packing_list_all = JSON.parse(sessionStorage.getItem("details"));
    let other_order_stuff_all = JSON.parse(sessionStorage.getItem("other"));
    let other_order_stuff = other_order_stuff_all[id];
    let packing_list = packing_list_all[id];

    for (let [key,value] of Object.entries(packing_list)) {
      let info_box = document.createElement("p");
      info_box.className = 'ml-[2%]';
      info_box.innerText = `(${value['qty']}) ` + value["productName"];
      packing_list_container.appendChild(info_box);
    }
    
    let invoice_container = document.createElement("div");
    invoice_container.className = 'w-full h-[30%] ';
    
    let invoice_container_text = document.createElement("p");
    invoice_container_text.className = ' text-lg font-bold text-slate-900 tracking-wide drop-shadow-xs px-3 mb-[2%]';
    invoice_container_text.innerText = 'Invoice:';

    invoice_container.appendChild(invoice_container_text);
    for (let [key,value] of Object.entries(packing_list)) {
      let info_box = document.createElement("p");
      info_box.className = 'ml-[2%]';
      info_box.innerText = `(${value['qty']}) ` + value["productName"] + '  $' + value["price"] * value['qty'];
      invoice_container.appendChild(info_box);
    }
    let amount_box = document.createElement("p");
    amount_box.className = 'ml-[2%]';
    amount_box.innerText = 'Amount: ' + '$' + other_order_stuff[0];

    let shipping_cost_text = document.createElement("p");
    shipping_cost_text.className = 'ml-[2%]';
    shipping_cost_text.innerText = 'Shipping: ' + '$' + other_order_stuff[1];

    let total_text = document.createElement("p");
    total_text.className = 'ml-[2%] mb-[2%]';
    total_text.innerText = 'Total: $' + (parseFloat(other_order_stuff[0]) + parseFloat(other_order_stuff[1])).toFixed(2);

    invoice_container.appendChild(amount_box);
    invoice_container.appendChild(shipping_cost_text);
    invoice_container.appendChild(total_text);

    let label_container = document.createElement("div");
    label_container.className = 'w-full  mt-6';
    let shippingLabelHeading = document.createElement('h1');
    shippingLabelHeading.innerText = "Shipping Label:";
    shippingLabelHeading.classList = "text-lg font-bold text-slate-900 tracking-wide drop-shadow-xs px-3";
    label_container.appendChild(shippingLabelHeading);
    let shippingLabelTextContainer = document.createElement('div');
    shippingLabelTextContainer.className = "ml-3 mt-3";
    let shippingLabelCustomerName = document.createElement('p');
    let shippingLabelCustomerAddr = document.createElement('p');
    let shippingLabelOrderConfirmation = document.createElement('p');

    let customerAddr = `${el.dataset.customeraddr} ${el.dataset.customercity} ${el.dataset.customerstate} ${el.dataset.customerzip}`;
    shippingLabelCustomerName.innerText = el.dataset.customername;
    shippingLabelCustomerAddr.innerText = customerAddr;
    shippingLabelOrderConfirmation.innerText = `An order confirmation has been sent to: ${el.dataset.customeremail}`;

    shippingLabelTextContainer.appendChild(shippingLabelCustomerName);

    shippingLabelTextContainer.appendChild(shippingLabelCustomerAddr);
    shippingLabelTextContainer.appendChild(shippingLabelOrderConfirmation);


    label_container.appendChild(shippingLabelTextContainer);

    // name addr city state zip

    invoice.appendChild(order_back_container);
    invoice.appendChild(packing_list_container);
    invoice.appendChild(invoice_container);
    invoice.appendChild(label_container);

    let d = document.createElement('div');
    d.className = "flex justify-center items-end"
    invoice.appendChild(d);
    let markDoneButton = document.createElement('button');
    markDoneButton.className = "mt-4 px-4 py-2 bg-green-500  mx-auto text-white rounded-md hover:bg-green-600 self-center";
    markDoneButton.innerText = "Mark as Fulfilled";
    d.appendChild(markDoneButton);

    order_back_container.appendChild(order_number_container);
    order_back_container.appendChild(back_container);
    order_number_container.appendChild(order_number);

    back_container.appendChild(back);

    back.addEventListener("click", function() {
      dim.parentElement.removeChild(dim);
      invoice.parentElement.removeChild(invoice);
    });
    
    markDoneButton.addEventListener("click", () => {
      const id = el.parentNode
                    .previousElementSibling
                    .childNodes[1]
                    .innerText
                    .substring(10);
    
      fetch(window.location.pathname, {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded"
        },
        body: `action=mark_fulfilled&orderID=${encodeURIComponent(id)}`
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) {
          dim.remove();
          invoice.remove();
          window.location.href = './warehouseorders.php';
        } else {
          alert("Failed to mark as fulfilled: " + data.error);
        }
      })
      .catch(err => {
        console.error(err);
        alert("Network error");
      });
    });
    
  
  }
</script>

</body>
</html>
