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


    <link rel="stylesheet" href="./src/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <meta http-equiv="refresh" content="3">
    <title>Lite Up Ur Lyfe Auto Parts</title>
    
</head>

<body class="w-screen min-h-screen m-0 bg-white">

<?php // Functions
?>
    <div class="w-full bg-[#55baf2] h-[7%] flex shadow-xl">
        <div class="w-[5%] h-full flex justify-center items-center">
            <a id='home-page' href="./" class="text-3xl"> <i class="fa fa-home" aria-hidden="true"></i> </a>
        </div>
        <div class="w-full h-full  flex justify-end items-center mr-[2%]"> 
                <ul class="flex h-full items-center justify-center gap-10">
                <li class=""> <a href="./catalog.php" class="text-white text-xl transform transition-transform duration-100 ease-in-out hover:text-shadow-lg/20"> Catalog </a> </li>
                <li> <a class="text-white text-xl cursor-pointer hover:text-shadow-lg/20"> <i class="fa fa-lock" aria-hidden="true"></i> Warehouse </a> </li>
                <li class=""> <a class="text-white text-xl cursor-pointer hover:text-shadow-lg/20"> <i class="fa fa-lock" aria-hidden="true"></i> Admin </a> </li>
                <li class="text-2xl"> <a class="text-white text-xl cursor-pointer hover:text-shadow-lg/20"> <i class="fa fa-shopping-bag" aria-hidden="true"></i> </a> </li>
            </ul>
        </div>
    </div>
    <section class="w-full bg-red-100 h-[70vh] bg-cover bg-center bg-no-repeat bg-[url(https://i.imgur.com/qhzr0GB.jpeg)]">
        <div>
            <div class="w-1/2 mx-auto text-center bg-blue-200 ">
            <h1>djhfdsfh</h1>
            <h2>djhfdsfh</h2>
            </div>
      </div>
 
    </section>
</body> </html> 