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
    <link rel="stylesheet" href="./src/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <meta http-equiv="refresh" content="1">
    <title>Lite Up Ur Lyfe Auto Parts</title>
</head>

<body class="w-screen h-screen m-0 bg-gray-800"></body>

<?php // Functions
?>
<?php
    echo <<<END
        <div class="w-full bg-white h-[7%] flex shadow-xl">
            <div class="w-[10%] h-full flex justify-center items-center">
                 <h1 class="flex justify-center items-center  ml-[1%]"> <a id='home-page' href="./"> Home </a> </h1>
            </div>
            <div class="w-full h-full flex justify-end items-center mr-[2%]"> 
                <ul class="flex h-full items-center justify-center gap-10">
                <li class=""> <a href="./catalog.php" class="hover:text-green-500 cursor-pointer"> Catalog </a> </li>
                <li> <a> <i class="fa fa-lock" aria-hidden="true"></i> Warehouse </a> </li>
                <li> <a> <i class="fa fa-lock" aria-hidden="true"></i> Admin </a> </li>
                <li class="text-2xl"> <a> <i class="fa fa-shopping-bag" aria-hidden="true"></i> </a> </li>
            </ul>
            </div>
        <div>
        
    END;
?>

</body> </html> 