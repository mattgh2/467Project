<?php // Error stuff
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
?>
<?php // Includes
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

<body class="w-screen min-h-screen m-0 bg-gray-800 overflow-hidden">
    <nav id="nav-bar">
        <div class="w-full bg-[#55baf2] h-[7%] flex shadow-xl justify-between">
            <div class="w-[5%] h-full flex justify-center items-center">
                <a id='home-page' href="./" class="text-3xl text-white drop-shadow-lg"> <i class="fa fa-home" aria-hidden="true"></i> </a>
            </div>
            <div class="max-w-md h-full flex mr-[2%]">
                <ul class="flex h-full items-center justify-center gap-10">
                    <li class=""> <a href="./catalog.php" class="text-white text-xl transform transition-transform duration-100 ease-in-out hover:text-shadow-lg/20"> Catalog </a> </li>
                    <li> <a class="text-white text-xl cursor-pointer hover:text-shadow-lg/20"> <i class="fa fa-lock" aria-hidden="true"></i> Warehouse </a> </li>
                    <li class=""> <a class="text-white text-xl cursor-pointer hover:text-shadow-lg/20"> <i class="fa fa-lock" aria-hidden="true"></i> Admin </a> </li>
                    <li class="text-2xl"> <a id='cart' class="text-white text-xl cursor-pointer hover:text-shadow-lg/20"> <i class="fa fa-shopping-bag" aria-hidden="true"></i> </a> </li>
                </ul>
            </div>
        </div>
    </nav>
    <section class="w-full bg-red-100 h-[70vh]  bg-cover bg-no-repeat" style="background-image: url(./cat.png)">
        <div>
            <div class="w-1/2 mx-auto text-center bg-indigo-500">
                <h1>sameple text1</h1>
                <h2>sample text2</h2>
            </div>
        </div>
    </section>

<script src="./cart.js"></script>
</body>

</html>