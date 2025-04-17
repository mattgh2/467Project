<?php // Error stuff
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
?>
<?php // Includes
include "dbconnect.php";
include "utils.php";
?>

<html>
  <head>
    <!-- Favicon links -->
    <link rel="icon" href="assets/favicon.ico" type="image/x-icon" />
    <link rel="icon" type="image/png" href="assets/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="assets/favicon-16x16.png" sizes="16x16" />

    <link rel="stylesheet" href="./public/css/output.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    <!-- <meta http-equiv="refresh" content="1"> -->
    <title>Lite Up Ur Lyfe Auto Parts</title>
  </head>

  <body class="m-0 p-0 min-h-screen w-screen overflow-x-hidden bg-[#ffffff]">
    <nav id="nav-bar" class="fixed top-0 left-0 z-50 w-full" >
      <div class="flex h-[75px] w-full justify-between bg-gradient-to-bl from-[#9dd8f8] from-5% via-[#55baf2] to-[#9dd8f8] shadow-xl">
        <div class="flex h-full w-[5%] items-center justify-center">
          <a id="home-page" href="./" class="text-3xl text-white drop-shadow-lg"> <i class="fa fa-home" aria-hidden="true"></i> </a>
        </div>
        <div class="mr-[2%] flex h-full max-w-md">
          <ul class="flex h-full items-center justify-center gap-10">
            <li class=""><a href="./catalog.php" class="transform text-xl text-white ease-in-out hover:underline hover:text-shadow-lg/20 transition-all duration-300"> Catalog </a></li>
            <li>
              <a class="cursor-pointer text-xl text-white hover:text-shadow-lg/20 transition-all duration-300"> <i class="fa fa-lock" aria-hidden="true"></i> Warehouse </a>
            </li>
            <li class="">
              <a class="cursor-pointer text-xl text-white hover:text-shadow-lg/20 transition-all duration-300"> <i class="fa fa-lock" aria-hidden="true"></i> Admin </a>
            </li>
            <li class="text-2xl">
              <a id="cart" class="cursor-pointer text-xl text-white hover:text-shadow-lg/20 "> <i class="fa fa-shopping-bag" aria-hidden="true"></i> </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Header Image w/ Catalog Button -->

    <section class="relative flex h-[65vh] w-full items-center justify-center bg-cover bg-no-repeat" style="background-image: url(./cat.png)">
      <div class="bg-black/50 p-6 text-center rounded-md shadow-xl">
        <h1 class="mb-4 text-4xl font-bold text-white">Lite Up Your Life Cuh</h1>
        <p class="mb-6 text-white">Check out our catalog for fresh parts and deals</p>
        <a href="./catalog.php" class="bg-[#55baf2] px-6 py-3 rounded-xl text-lg font-bold text-white transition-all duration-300 hover:bg-green-700 "> Go to Catalog → </a>
      </div>
    </section>

    <!-- About Us -->

    <section class="bg-white py-16 px-6 text-center">
    <h2 class="text-4xl font-bold mb-4">Why "Lite Up Ur Lyfe?"</h2>
    <p class="max-w-3xl mx-auto text-gray-700 text-lg">
    We bring brightness to your ride with affordable, high-quality auto parts. Whether you’re fixing up your whip or adding flair, we gotchu covered with parts that shine.
    </p>
    </section>

    <!-- Featured Items -->

    <section class="bg-[#f9f9f9] py-16 px-6 h-[200%]">
    <h2 class="text-4xl font-bold text-center mb-10">Featured Items</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 max-w-7xl mx-auto">
    
    <!-- product cards here -->
    <?= createProductCard($part1) ?>
   
    </div>
    </section>

    <!-- Meet the Woo -->

    <section class="bg-white py-16 px-6">
    <h2 class="text-4xl font-bold text-center mb-10">Meet the Gang</h2>
    <div class="flex flex-col md:flex-row items-center justify-center gap-10 max-w-5xl mx-auto">
    <div class="text-center">
      <img src="assets/team1.png" alt="Team member" class="rounded-full w-40 h-40 object-cover mx-auto mb-4" />
      <p class="font-semibold">Nate "Set"</p>
      <p class="text-sm text-gray-500">Head Mechanic</p>
    </div>
    <div class="text-center">
      <img src="assets/team2.png" alt="Team member" class="rounded-full w-40 h-40 object-cover mx-auto mb-4" />
      <p class="font-semibold">Dave "Soren"</p>
      <p class="text-sm text-gray-500">Warehouse Manager</p>
    </div>
    <div class="text-center">
      <img src="assets/team3.png" alt="Team member" class="rounded-full w-40 h-40 object-cover mx-auto mb-4" />
      <p class="font-semibold">Matt "Niccolo"</p>
      <p class="text-sm text-gray-500">Parts Manager</p>
    </div>
    </di>
    </section>

    <footer class="w-full bg-[#151515] text-white py-15 px-6">
        <div class="max-w-5xl mx-auto flex flex-col md:flex-row md:items-start md:justify-between space-y-6">
            <!-- Left Group: Logo + Text -->
            <div class="flex items-start gap-4">
                <img src="assets/logo.png" alt="Logo" class="w-16 h-13 object-contain" />
                <div class="text-sm text-gray-300">
                <p class="font-bold">Lite Up Ur Lyfe Auto Parts</p>
                <p>Your go-to for bold, bright, and budget-friendly auto lighting.</p>
                </div>
            </div>

            <!-- Right Group: Links / Icons / Whatever -->
            <div class="text-sm text-gray-400">
                <p>Email: support@liteupartz.com</p>
                <p>Phone: (123) 456-7890</p>
            </div>

            <!-- Social Icons -->
            <div class="flex justify-center space-x-6 pt-4">
                <i class="fa fa-facebook-official text-xl hover:text-[#55baf2]"></i>
                <i class="fa fa-twitter text-xl hover:text-[#55baf2]"></i>
                <i class="fa fa-instagram text-xl hover:text-[#55baf2]"></i>
                <i class="fa fa-linkedin text-xl hover:text-[#55baf2]"></i>
            </div>

        </div>

    </footer>

    <script src="./cart.js"></script>
  </body>
</html>
