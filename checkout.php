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
    <link rel="stylesheet" href="./public/css/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    <!-- <meta http-equiv="refresh" content="1"> -->
    <title>Lite Up Ur Lyfe Auto Parts</title>
</head>

<body class="w-screen h-screen m-0 bg-red-300">
    <!-- Navbar -->
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
                <div class="flex flex-col">
                    <div class="w-5 h-5 bg-indigo-900 absolute  rounded-full"></div>
                    <p class="absolute text-2xl">1</p>
                    <li class="text-2xl"> <a href="./checkout.php" id='cart' class="text-white text-3xl  cursor-pointer  hover:text-shadow-lg/20"> <i class="fa fa-shopping-bag" aria-hidden="true"></i> </a> </li>
                </div>
            </ul>
        </div>
    </div>
</nav>
    <div class='w-full h-[10%] flex justify-center items-center bg-grey-200'>
        <p class='text-3xl'> <i class="fa fa-shopping-cart" aria-hidden="true"></i> </p>
        <h1 class='ml-[2%] text-2xl'> Shopping Cart </h1>
    </div>  
    <div id="cart-items" class='h-full w-1/2 bg-green-200 flex flex-col gap-10 ml-[2%]'>

    </div>


<?php
?>
    <script>
        let cartItems = document.getElementById('cart-items');
        console.dir(sessionStorage);
        for (let [key,value] of Object.entries(sessionStorage)) {
            let v = value.split(",");
            let id = v[0];
            let desc = v[1];
            let price = v[2];
            let weight = v[3];
            let _url = v[4];

            let all = document.createElement('div');
            all.className = "w-full h-[30%] border-l-0 border-r-0 border-t-2 border-b-2  bg-white shadow-lg border-grey-50";
            cartItems.appendChild(all);
            
            let topBox = document.createElement('div');
            topBox.className = 'w-full h-[80%] bg-blue-300 flex';

            let bottomAll = document.createElement('div');
            bottomAll.className = 'w-full h-[20%] bg-purple-300 flex';

            all.appendChild(topBox);
            all.appendChild(bottomAll);

            let topImage = document.createElement('div');
            topImage.className = 'w-[30%] h-full bg-no-repeat bg-contain';
            topImage.style.backgroundImage = `url(${_url})`;

            let topDesc = document.createElement('div');
            topDesc.className = 'w-[15%] h-full bg-pink-600';

            let topEach = document.createElement('div');
            topEach.className = 'w-[20%] h-full bg-green-600';

            let topQuantity = document.createElement('div');
            topQuantity.className = 'w-[15%] h-full bg-blue-600';

            let topTotal = document.createElement('div');
            topTotal.className = 'w-[20%] h-full bg-red-400';

            topBox.appendChild(topImage);
            topBox.appendChild(topDesc);
            topBox.appendChild(topEach);
            topBox.appendChild(topQuantity);
            topBox.appendChild(topTotal);

            let bottomPad = document.createElement('div');
            bottomPad.className = 'w-[30%] h-full bg-pink-300';

            let bottomRest = document.createElement('div');
            bottomRest.className = 'w-[70%] h-full bg-cyan-300'

            bottomAll.appendChild(bottomPad);
            bottomAll.appendChild(bottomRest);

        }


    </script>

</body> </head>