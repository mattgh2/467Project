<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
session_start();

require_once("dbconnect.php");
require_once("utils.php");

$parts = getAllParts();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Receiving Parts | Lite Up Ur Lyfe Auto Parts</title>
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
  <main class="pt-24 px-4 max-w-5xl mx-auto">
    <h1 class="text-4xl font-bold text-center text-blue-500 mb-10">Receiving Parts</h1>

    <input type="text" placeholder="Filter by Part Description or Part Number" class="w-full p-3 border border-gray-300 rounded mb-6 shadow">

    <section class="space-y-4">
      <?php foreach ($parts as $part): ?>
        <div class="bg-white rounded-xl shadow-md flex flex-row p-4 gap-6">
          <img src="<?php echo $part['image_url']; ?>" alt="<?php echo htmlspecialchars($part['description']); ?>" class="w-32 h-20 object-contain">
          <div class="flex flex-col justify-between w-full">
            <div>
              <p class="text-lg font-semibold text-blue-500"><?php echo htmlspecialchars($part['description']); ?></p>
              <p class="text-gray-700">
                $<?php echo number_format($part['price'], 2); ?> - <?php echo $part['weight']; ?>lbs
              </p>
              <p class="text-sm text-gray-500">quantity on hand: <?php echo $part['quantity']; ?></p>
            </div>
            <div class="flex items-center gap-2 justify-end">
              <input type="number" min="0" value="0" class="w-20 p-2 border border-gray-300 rounded">
              <button class="px-4 py-2 bg-blue-400 text-white rounded-lg hover:bg-green-500 transition-colors duration-200">Update Quantity</button>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </section>
  </main>
</body>
</html>