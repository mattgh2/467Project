<?php // Error stuff
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
?>
<?php
include "dbconnect.php";
?>

<html>
<head>
    <!-- Favicon links -->
    <link rel="icon" href="assets/favicon.ico" type="image/x-icon" />
    <link rel="icon" type="image/png" href="assets/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="assets/favicon-16x16.png" sizes="16x16" />


    
    <link rel="stylesheet" href="./public/css/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    <!-- <meta http-equiv="refresh" content="1"> -->
    <title>Lite Up Ur Lyfe Auto Parts</title>
</head>

<body class="w-screen m-0 bg-radial-layered min-h-screen">
  <!-- Navbar -->
  <nav id="nav-bar" class="fixed top-0 left-0 z-50 w-full">
    <div class="flex h-[75px] w-full justify-between bg-gradient-to-bl from-[#9dd8f8] from-5% via-[#55baf2] to-[#9dd8f8]">
      <div class="flex h-full w-[5%] items-center justify-center">
        <a id="home-page" href="./" class="text-3xl text-white">
          <i class="fa fa-home" aria-hidden="true"></i>
        </a>
      </div>
      <div class="mr-[2%] flex h-full max-w-md">
        <ul class="flex h-full items-center justify-center gap-10">
          <li>
            <a href="./catalog.php" class="group relative text-xl text-white transition-all duration-300">
              <span class="pb-1 inline-block relative">
                Catalog
                <!-- Left underline -->
                <span class="absolute left-1/2 bottom-0 h-0.5 w-0 bg-white transition-all duration-300 ease-in-out transform -translate-x-1/2 group-hover:w-1/2 group-hover:translate-x-0"></span>
                <!-- Right underline -->
                <span class="absolute right-1/2 bottom-0 h-0.5 w-0 bg-white transition-all duration-300 ease-in-out transform -translate-x-1/2 group-hover:w-1/2 group-hover:translate-x-0"></span>
              </span>
            </a>
          </li>
          <li>
            <a class="group relative cursor-pointer text-xl text-white transition-all duration-300">
              <span class="pb-1 inline-block relative">
                <i class="fa fa-lock" aria-hidden="true"></i> Warehouse
                <!-- Left underline -->
                <span class="absolute left-1/2 bottom-0 h-0.5 w-0 bg-white transition-all duration-300 ease-in-out transform -translate-x-1/2 group-hover:w-1/2 group-hover:translate-x-0"></span>
                <!-- Right underline -->
                <span class="absolute right-1/2 bottom-0 h-0.5 w-0 bg-white transition-all duration-300 ease-in-out transform -translate-x-1/2 group-hover:w-1/2 group-hover:translate-x-0"></span>
              </span>
            </a>
          </li>
          <li>
            <a class="group relative cursor-pointer text-xl text-white transition-all duration-300">
              <span class="pb-1 inline-block relative">
                <i class="fa fa-lock" aria-hidden="true"></i> Admin
                <!-- Left underline -->
                <span class="absolute left-1/2 bottom-0 h-0.5 w-0 bg-white transition-all duration-300 ease-in-out transform -translate-x-1/2 group-hover:w-1/2 group-hover:translate-x-0"></span>
                <!-- Right underline -->
                <span class="absolute right-1/2 bottom-0 h-0.5 w-0 bg-white transition-all duration-300 ease-in-out transform -translate-x-1/2 group-hover:w-1/2 group-hover:translate-x-0"></span>
              </span>
            </a>
          </li>
          <div class="relative flex flex-col w-10">
            <div class="absolute right-0 w-5 h-5 bg-indigo-900 flex rounded-full">
              <p id="cart-counter" class="text-white self-center mx-auto text-xs">0</p>
            </div>
            <li class="text-2xl">
              <a id="cart" class="text-white text-3xl cursor-pointer transition-all duration-300 hover:text-white">
                <i class="fa fa-shopping-bag" aria-hidden="true"></i>
              </a>
            </li>
          </div>
        </ul>
      </div>
    </div>
  </nav>

    <div class='w-full h-[10%] flex mt-[6%] mb-[2%] justify-center items-center bg-grey-200'>
        <p class='text-3xl'> <i class="fa fa-shopping-cart" aria-hidden="true"></i> </p>
        <h1 class='ml-[2%] text-2xl'> Shopping Cart </h1>
    </div>  
    <div id="checkout-container" class='w-full h-full flex gap-10'>
      <div id="cart-items" class='h-full w-1/2 flex flex-col gap-10 ml-[2%]'>

      </div>
    </div>  

    <script type="module" src="./cart.js"></script>
    <script type="module" src="./checkout.js"></script>

</body> </heade