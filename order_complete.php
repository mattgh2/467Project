<?php // Error stuff
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
?>
<?php // Includes
include "dbconnect.php";
require_once("utils.php");
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
    <div class="mt-40">
        <p class="text-5xl text-green-500 text-center tracking-wide font-semibold drop-shadow-md">
            🎉  Thank you for your order. 🎉 
        </p>
    </div>
        <p class="text-center mt-20">
            An email confirmation has been sent to <?=$_GET["email"]?>. 
        </p>

        <p class='text-center mt-10'>
            Confirmation code: <?=$_GET['confirmation']?>.
        </p>        
    <div>
    </div>

    <div class='flex justify-center items-center text-semibold tracking-wide'>
        <button class='w-[10%] h-[10%] p-4 bg-pink-200 mt-[2%] cursor-pointer transition-colors transform ease-in-out duration-300 hover:bg-pink-400 rounded-2xl ' onclick=_return()> Return to store </button>
    </div>


    </body></html>

<script>
    sessionStorage.clear();

    function _return() {
        window.location.href = './index.php';
    }
</script>