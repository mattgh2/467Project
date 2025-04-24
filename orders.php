<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
session_start();
require_once("dbconnect.php");
require_once('utils.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lite Up Ur Lyfe Auto Parts</title>
  <link rel="icon" href="assets/favicon.ico" type="image/x-icon" />
  <link rel="stylesheet" href="./public/css/output.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body class="w-screen h-screen m-0 bg-gradient-to-br from-blue-50 via-blue-100 to-blue-50 min-h-screen font-sans">

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
  <div class="pt-24 px-4 flex flex-col items-center gap-10">

  <div class="w-[60%] bg-white rounded-xl shadow-lg overflow-hidden">

  <table class="w-full table-auto">
  <thead class="bg-blue-300 text-left text-gray-800">
    <tr>
      <th class="px-6 py-4 text-center">Order ID</th>
      <th class="px-12 py-4 text-center whitespace-nowrap">Customer ID</th>
      <th class="px-6 py-4 text-center">Product list</th>
      <th class="px-6 py-4 text-center">Date</th>
      <th class="px-6 py-4 text-center">Status</th>
      <th class='px-6 py-4 text-center'> Action </th>
    </tr>
  </thead>
  <tbody class="text-gray-700">
        <?php 
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                if (isset($_POST["orderID"])) {
                    complete_order($pdoInventory, $_POST["orderID"]);
                }
            }
            $orders = get_orders($pdoInventory);
            foreach($orders as $order) {
                echo "<tr class='border-t'>";

                echo "<td class='px-6 py-4 text-center'>";
                echo $order['orderID'];
                echo "</td>";

                echo "<td class='px-6 py-4 text-center'>";
                echo $order['customerID'];
                echo "</td>";

                $product_list = get_products_from_orders($pdoInventory, $order['orderID']);
                $quantity_list = get_quantity_list_from_order_id($pdoInventory, $order['orderID']);

                echo "<td class='px-6 py-4 text-center'>";
                    echo "($quantity_list[0]) " . "$product_list[0]";
                    for ($i = 1; $i < sizeof($product_list); $i++) {
                        echo ', ' . "($quantity_list[$i]) " . "$product_list[$i]";
                    }
                echo "</td>";

                echo "<td class='px-6 py-4 text-center'>";
                echo $order['orderDate'];
                echo "</td>";

                echo "<td class='px-6 py-4 text-center'>";
                echo $order['orderStatus'];
                echo "</td>";

                echo "<td class='px-6 py-4 text-center'>";
                    echo "<form action='' method='POST' class='inline'>";
                    echo "<input type='hidden' name='orderID' value='{$order['orderID']}'>";
                    echo "<button type='submit' name='delete' class='text-purple-400 hover:text-red-600 cursor-pointer'>Remove</button>";
                    echo "</form>";
                echo "</td>";
                echo "</tr>";
            }   
        ?>
    </tbody>
    </table>
  </div>

  </div>
  
</body>
</html>
