<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
session_start();
require_once("dbconnect.php");
require_once('utils.php');

// Handle AJAX for invoice data
if (isset($_GET['get_invoice_data'])) {
    $orderID = $_GET['get_invoice_data'];
  
    // Get customerID from order
    $customerStmt = $pdoInventory->prepare("SELECT customerID FROM Orders WHERE orderID = ?");
    $customerStmt->execute([$orderID]);
    $customerID = $customerStmt->fetchColumn();
  
    $address = "Address not found";
    if ($customerID) {
      $custStmt = $pdoInventory->prepare("SELECT addr, City, State, Zip FROM Customer WHERE customerID = ?");
      $custStmt->execute([$customerID]);
      $custData = $custStmt->fetch(PDO::FETCH_ASSOC);
      if ($custData) {
        $address = "{$custData['addr']}, {$custData['City']}, {$custData['State']} {$custData['Zip']}";
      }
    }
  
    // Fetch product details
    $stmt = $pdoInventory->prepare("SELECT op.productID, p.productName, op.qty, op.Price 
                                    FROM OrderProduct op 
                                    JOIN Product p ON op.productID = p.productID 
                                    WHERE op.orderID = ?");
    $stmt->execute([$orderID]);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
    $total = 0;
    foreach ($products as &$product) {
      $product['total_price'] = $product['qty'] * $product['Price'];
      $total += $product['total_price'];
    }
  
    echo json_encode([
      'address' => $address,
      'products' => $products,
      'total' => $total
    ]);
    exit;
  }
  

// Handle AJAX to mark as fulfilled
if (isset($_GET['mark_fulfilled'])) {
  $orderID = $_GET['mark_fulfilled'];
  $stmt = $pdoInventory->prepare("UPDATE Orders SET orderStatus = 'shipped' WHERE orderID = ?");
  $stmt->execute([$orderID]);
  echo "success";
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Order Fulfillment | Lite Up Ur Lyfe Auto Parts</title>
  <link rel="stylesheet" href="./public/css/output.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body class="bg-gradient-to-br from-blue-50 via-blue-100 to-blue-50 mi font-sans">

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

  <main class="pt-24 px-4 max-w-4xl mx-auto">
    <h1 class="text-4xl font-bold text-center text-blue-500 mb-10">Order Fulfillment</h1>

    <section class="space-y-4">
      <?php
      try {
        $stmt = $pdoInventory->query("SELECT * FROM Orders");
        while ($order = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $id = htmlspecialchars($order['orderID']);
          $date = htmlspecialchars($order['orderDate']);
          $status = htmlspecialchars($order['orderStatus']);
          $imageURL = "./public/images/box-icon.png";

          $productStmt = $pdoInventory->prepare("SELECT productID FROM OrderProduct WHERE orderID = :id LIMIT 1");
          $productStmt->execute(['id' => $id]);
          $productRow = $productStmt->fetch(PDO::FETCH_ASSOC);

          if ($productRow) {
            $productID = $productRow['productID'];
            $legacyStmt = $pdoLegacy->prepare("SELECT pictureURL FROM parts WHERE number = :num");
            $legacyStmt->execute(['num' => $productID]);
            $legacyRow = $legacyStmt->fetch(PDO::FETCH_ASSOC);
            if ($legacyRow && !empty($legacyRow['pictureURL'])) {
              $imageURL = htmlspecialchars($legacyRow['pictureURL']);
            }
          }

          echo "
<div class='bg-white rounded-xl shadow-md flex flex-row p-4 gap-6'>
  <div class='w-32 h-32 bg-center bg-contain bg-no-repeat' style='background-image: url(\"$imageURL\")'></div>
  <div class='flex flex-col justify-between w-full'>
    <div>
      <p class='text-lg font-semibold text-blue-500'>Order ID: {$id}</p>
      <p class='text-gray-700'>Order Date: {$date}</p>
      <p class='text-gray-700'>Status: {$status}</p>
    </div>
    <div class='flex justify-end'>
      <button onclick='printInvoice({$id})' class='px-4 py-2 bg-blue-400 text-white rounded-lg hover:bg-green-500 transition-colors duration-200'>Complete Order</button>
    </div>
  </div>
</div>";
        }
      } catch (PDOException $e) {
        echo "<p class='text-red-500'>Error fetching orders: " . $e->getMessage() . "</p>";
      }
      ?>
    </section>
  </main>

  <script>
  async function printInvoice(orderID) {
    const res = await fetch(`?get_invoice_data=${orderID}`);
    const data = await res.json();

    const dim = document.createElement('div');
    dim.className = "fixed inset-0 bg-black bg-opacity-50 opacity-60 z-40";
    document.body.appendChild(dim);

    const invoice = document.createElement('div');
    invoice.className = `
      fixed left-1/2 top-24 transform -translate-x-1/2 
      bg-white w-[600px] max-w-full max-h-[80vh] overflow-y-auto 
      rounded-md shadow-md z-50 p-6 flex flex-col gap-4
    `;
    document.body.appendChild(invoice);

    invoice.innerHTML = `
      <div class="w-8 h-8 bg-red-600 text-white text-center rounded-md shadow-md flex justify-center items-center absolute top-2 right-2 cursor-pointer" id="closeBtn">
        <i class="fa fa-times" aria-hidden="true"></i>
      </div>
      <h2 class="text-xl font-bold text-blue-600">Order Number: ${orderID}</h2>
      <p><strong>Shipping Address:</strong> ${data.address}</p>
      <h3 class="text-lg font-semibold mt-2">Packing List:</h3>
      <ul class="list-disc pl-5">
        ${data.products.map(p => `<li>${p.productName} (x${p.qty})</li>`).join('')}
      </ul>
      <p class="mt-4"><strong>Total Price:</strong> $${data.total.toFixed(2)}</p>
      <button id="markDone" class="mt-4 px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">Mark as Fulfilled</button>
    `;

    document.getElementById('closeBtn').onclick = () => {
      invoice.remove();
      dim.remove();
    };

    document.getElementById("markDone").onclick = async () => {
        await fetch(`?mark_fulfilled=${orderID}`);
        location.reload();
    };
  }
</script>
</body>
</html>
