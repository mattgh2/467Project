<?php
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    session_start();
?>
<?php
require_once("dbconnect.php");
require_once('utils.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Favicon links -->
    <link rel="icon" href="assets/favicon.ico" type="image/x-icon" />
    <link rel="icon" type="image/png" href="assets/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="assets/favicon-16x16.png" sizes="16x16" />

    <link rel="stylesheet" href="./public/css/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lite Up Ur Lyfe Auto Parts</title>
</head>

<body class="w-screen h-screen m-0 bg-gradient-to-br from-[#1d1d1d] via-[#2e2e2e] to-[#3f3f3f] overflow-x-hidden">

<!-- Navbar -->
<nav id="nav-bar" class="fixed top-0 left-0 z-50 w-full">
  <div class="flex h-[75px] w-full justify-between bg-gradient-to-bl from-[#9dd8f8] via-[#55baf2] to-[#9dd8f8]">
    <div class="flex h-full w-[5%] items-center justify-center">
      <a id="home-page" href="./" class="text-3xl text-white">
        <i class="fa fa-home" aria-hidden="true"></i>
      </a>
    </div>

    <div class="mr-[2%] flex h-full max-w-md">
      <ul class="flex h-full items-center justify-center gap-10">
        <li>
          <a href="signin.php" class="group relative cursor-pointer text-xl text-white transition-all duration-300">
            <span class="pb-1 inline-block relative">
              Admin
              <span class="absolute left-1/2 bottom-0 h-0.5 w-0 bg-white transition-all duration-300 ease-in-out transform -translate-x-1/2 group-hover:w-1/2 group-hover:translate-x-0"></span>
              <span class="absolute right-1/2 bottom-0 h-0.5 w-0 bg-white transition-all duration-300 ease-in-out transform -translate-x-1/2 group-hover:w-1/2 group-hover:translate-x-0"></span>
            </span>
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>

  <!-- Main Content -->
  <main class="flex-grow flex items-center justify-center pt-32">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-16 px-8">

      <!-- View Orders Card -->
      <div id="orders" class="group bg-white text-gray-800 rounded-2xl shadow-lg hover:shadow-2xl p-12 min-w-[300px] h-[220px] flex flex-col items-center justify-center transform hover:-translate-y-2 transition-all duration-300 cursor-pointer hover:bg-blue-100">
        <i class="fa fa-hand-o-down text-5xl mb-4 group-hover:text-blue-600"></i>
        <a href="./warehousereceiving.php" class="text-2xl font-semibold text-center">Warehouse Receiving</a>
      </div>

      <!-- View and Set Weights Card -->
      <div id="weights" class="group bg-white text-gray-800 rounded-2xl shadow-lg hover:shadow-2xl p-12 min-w-[300px] h-[220px] flex flex-col items-center justify-center transform hover:-translate-y-2 transition-all duration-300 cursor-pointer hover:bg-blue-100">
        <i class="fa fa-truck text-5xl mb-4 group-hover:text-blue-600"></i>
        <a href="./warehouseorders.php" class="text-2xl font-semibold text-center">Order Fulfillment</a>
      </div>

    </div>
  </main>

  <script>
    document.getElementById("orders").addEventListener("click", () => {
      window.location.href = "./warehousereceiving.php";
    });
    document.getElementById("weights").addEventListener("click", () => {
      window.location.href = "./warehouseorders.php";
    });
  </script>

</body>
</html>
