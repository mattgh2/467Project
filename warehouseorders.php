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
      <button class='px-4 py-2 bg-blue-400 text-white rounded-lg hover:bg-green-500 transition-colors duration-200'>Complete Order</button>
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

</body>
</html>
