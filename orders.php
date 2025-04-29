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
  <style>
    .order-popup {
      max-width: 90vw;
      max-height: 90vh;
      overflow-y: auto;
    }

    .order-items-container {
      max-height: 200px;
      overflow-y: auto;
      border: 1px solid #ccc;
      padding: 10px;
      background-color: #f9f9f9;
      border-radius: 6px;
      margin-top: 10px;
    }

    .popup-header {
      position: sticky;
      top: 0;
      background: white;
      z-index: 10;
      padding-bottom: 10px;
      border-bottom: 1px solid #ddd;
      margin-bottom: 10px;
    }
  </style>
</head>

<body class="w-screen h-screen m-0 bg-gradient-to-br from-blue-50 via-blue-100 to-blue-50 min-h-screen font-sans">

<!-- Navbar -->
<nav class="fixed top-0 left-0 z-50 w-full shadow-md">

<nav id="nav-bar" class="fixed top-0 left-0 z-50 w-full">
  <div class="flex items-center justify-between px-6 h-16 bg-gradient-to-bl from-[#9dd8f8] via-[#55baf2] to-[#9dd8f8]">
    <a href="./" class="text-white text-2xl">
      <i class="fa fa-home"></i>
    </a>
    <ul class="flex gap-6 text-white text-lg">
      <li class="group relative">
        <a href="warehouse.php" class="cursor-pointer">
          <i class="pb-1 inline-block relative"></i> Warehouse
          <span class="absolute left-1/2 bottom-0 h-0.5 w-0 bg-white transition-all group-hover:w-full group-hover:left-0"></span>
        </a>
      </li>
      <li class="group relative">
        <a href="weights.php" class="cursor-pointer">
          <i class="pb-1 inline-block relative"></i> View and Set Weight Brackets
          <span class="absolute left-1/2 bottom-0 h-0.5 w-0 bg-white transition-all group-hover:w-full group-hover:left-0"></span>
        </a>
      </li>
    </ul>
  </div>
</nav>
</nav>

<div class="pt-24 px-4 flex flex-col items-center gap-10">

  <!-- Filter Form -->
  <form id="filterForm" class="flex flex-wrap justify-center gap-4 mb-6 bg-white p-4 rounded shadow-md">
    <div><label>Date from: <input type="date" id="startDate" class="border rounded p-1"></label></div>
    <div><label>Date to: <input type="date" id="endDate" class="border rounded p-1"></label></div>
    <div>
      <label>Status:
        <select id="statusFilter" class="border rounded p-1">
          <option value="All">All</option>
          <option value="Authorized">Open</option>
          <option value="Shipped">Filled</option>
        </select>
      </label>
    </div>
    <div class="relative">
      <label>
        Price from:
        <span class="absolute left-22 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none">$</span>
        <input type="number" id="minPrice" class="pl-6 border rounded p-1" value="0" min="0" />
      </label>
    </div>
    <div class="relative">
      <label>
        to:
        <span class="absolute left-8 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none">$</span>
        <input type="number" id="maxPrice" class="pl-6 border rounded p-1" value="99999" min="0" />
      </label>
    </div>
    <div>
      <button type="button" onclick="applyFilters()" class="bg-blue-400 text-white px-4 py-1 rounded hover:bg-green-500">Filter</button>
    </div>
  </form>

  <!-- Orders Table -->
  <div class="w-[90%] bg-white rounded-xl shadow-lg overflow-x-auto">
    <table class="w-full table-auto">
      <thead class="bg-blue-300 text-left text-gray-800">
        <tr>
          <th class="px-6 py-4 text-center">Order ID</th>
          <th class="px-12 py-4 text-center whitespace-nowrap">Customer ID</th>
          <th class="px-6 py-4 text-center">Product list</th>
          <th class="px-6 py-4 text-center">Amount</th>
          <th class="px-6 py-4 text-center">Date</th>
          <th class="px-6 py-4 text-center">Status</th>
          <th class="px-6 py-4 text-center">Action</th>
        </tr>
      </thead>
      <tbody class="text-gray-700">
        <?php 
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["orderID"])) {
          complete_order($pdoInventory, $_POST["orderID"]);
        }

        $orders = get_orders($pdoInventory);
        foreach($orders as $order) {
          $product_list = get_products_from_orders($pdoInventory, $order['orderID']);
          $quantity_list = get_quantity_list_from_order_id($pdoInventory, $order['orderID']);
          $productDisplay = "($quantity_list[0]) $product_list[0]";
          for ($i = 1; $i < count($product_list); $i++) {
            $productDisplay .= ", ($quantity_list[$i]) $product_list[$i]";
          }

          echo "<tr class='border-t' data-date='{$order['orderDate']}' data-status='{$order['orderStatus']}' data-amount='{$order['amount']}'>";
          echo "<td class='px-6 py-4 text-center'>{$order['orderID']}</td>";
          echo "<td class='px-6 py-4 text-center'>{$order['customerID']}</td>";
          echo "<td class='px-6 py-4 text-center'>{$productDisplay}</td>";
          echo "<td class='px-6 py-4 text-center'>\$" . $order['amount'] . "</td>";
          echo "<td class='px-6 py-4 text-center'>{$order['orderDate']}</td>";
          echo "<td class='px-6 py-4 text-center'>{$order['orderStatus']}</td>";
          echo "<td class='px-6 py-4 text-center'>";
          echo "<button class='bg-gray-300 px-3 py-1 rounded hover:bg-gray-400' onclick='viewDetails({$order['orderID']})'>detail</button>";
          echo "</td>";
          echo "</tr>";
        }
        ?>
      </tbody>
    </table>
  </div>

</div>

<!-- Popup -->
<div id="orderPopup" class="hidden fixed inset-0 bg-black bg-opacity-30 flex justify-center items-center z-50">
  <div class="order-popup bg-white p-6 rounded-xl shadow-2xl w-full max-w-2xl relative">
    <button onclick="closePopup()" class="absolute top-2 right-3 text-gray-600 text-xl hover:text-black">&times;</button>
    <div id="popupContent" class="text-gray-700">
      <div class="popup-header">
        <h2 class="text-2xl font-semibold mb-2">Order Details</h2>
        <p id="popupMeta"></p>
      </div>
      <div class="order-items-container" id="popupItems"></div>
    </div>
  </div>
</div>

<!-- JavaScript -->
<script>
  function applyFilters() {
    const startDate = new Date(document.getElementById("startDate").value || "2000-01-01");
    const endDate = new Date(document.getElementById("endDate").value || "2100-01-01");
    const status = document.getElementById("statusFilter").value;
    const minPrice = parseFloat(document.getElementById("minPrice").value);
    const maxPrice = parseFloat(document.getElementById("maxPrice").value);

    const rows = document.querySelectorAll("tbody tr");

    rows.forEach(row => {
      const rowDate = new Date(row.dataset.date);
      const rowStatus = row.dataset.status.toLowerCase();
      const rowAmount = parseFloat(row.dataset.amount);

      const matchDate = rowDate >= startDate && rowDate <= endDate;
      const matchStatus = (status === "All") || rowStatus.includes(status.toLowerCase());
      const matchPrice = rowAmount >= minPrice && rowAmount <= maxPrice;

      row.style.display = (matchDate && matchStatus && matchPrice) ? "" : "none";
    });
  }

  function viewDetails(orderID) {
    const popup = document.getElementById("orderPopup");
    const popupContent = document.getElementById("popupContent");
    const orderDetails = getOrderDetails(orderID);

    document.getElementById("popupMeta").innerText = `Order ID: ${orderDetails.orderID}\nCustomer ID: ${orderDetails.customerID}`;
    document.getElementById("popupItems").innerHTML = generateOrderItemsList(orderDetails.items);

    popup.classList.remove("hidden");
  }

  function closePopup() {
    document.getElementById("orderPopup").classList.add("hidden");
  }

  function generateOrderItemsList(items) {
    return items.map(item => `<div>${item.quantity} x ${item.name} - $${item.price}</div>`).join('');
  }

  function getOrderDetails(orderID) {
    // Replace with actual logic to retrieve order details
    return {
      orderID: orderID,
      customerID: '12345',
      items: [
        { name: 'Part A', quantity: 2, price: 50 },
        { name: 'Part B', quantity: 1, price: 100 }
      ]
    };
  }
</script>

</body>
</html>
