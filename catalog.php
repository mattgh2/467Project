<?php // Error stuff
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    session_start();
?>
<?php
include "dbconnect.php";
require_once('utils.php');
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
                <li class=""> <a href="./catalog.php" class="text-white  text-xl transform transition-transform duration-100 ease-in-out hover:text-shadow-lg/20"> Catalog </a> </li>
                <li> <a class="text-white text-xl cursor-pointer hover:text-shadow-lg/20"> <i class="fa fa-lock" aria-hidden="true"></i> Warehouse </a> </li>
                <li class=""> <a class="text-white text-xl cursor-pointer hover:text-shadow-lg/20"> <i class="fa fa-lock" aria-hidden="true"></i> Admin </a> </li>
                <div class=" flex flex-col w-10 relative">
                    <div class="w-5 h-5 bg-indigo-900 absolute  flex rounded-full right-0"> 
                    <p id="cart-counter" class="text-white self-center mx-auto">0</p>
                    </div>
                    <li class="text-2xl"> <a href="./checkout.php" id='cart' class="text-white text-3xl cursor-pointer hover:text-shadow-lg/20"> <i class="fa fa-shopping-bag" aria-hidden="true"></i> </a> </li>
                </div>
            </ul>
        </div>
    </div>
</nav>

<?php
    $parts = query_parts($pdoLegacy);
    echo "<div class=\"h-screen grid 2xl:grid-cols-5  grid-cols-3 gap-4 gap-x-10 p-6 auto-rows-[40vh]\">";
        foreach ($parts as $part) echo createProductCard($part);
    echo "</div>";
?>

<script defer>
    let incrementQty = document.querySelectorAll('.plus-qty');
    let decrementQty = document.querySelectorAll('.minus-qty');
    let qty = document.querySelectorAll('[class*="qty-input"]');

    let n = qty.length;
    let quantities = new Array(n).fill(0);

    for (let i = 0; i < n; ++i) {
        incrementQty[i].addEventListener('click', ()=> {
            ++quantities[i];
            qty[i].value = quantities[i];    
        });
        decrementQty[i].addEventListener('click', ()=> {
            --quantities[i];
            quantities[i] = Math.max(quantities[i], 0);
            qty[i].value = quantities[i];    
        });
    }

    let cartCounter = document.getElementById('cart-counter');
    cartCounter.innerHTML = sessionStorage.length;

    function addToCart(el) {
        const id = el.id;

        if (!sessionStorage.getItem(id)) {
            let count = parseInt(cartCounter.innerHTML);
            cartCounter.innerHTML = count + 1;
        };

        let amount = quantities[parseInt(id)-1];

        const product = <?php echo json_encode($parts); ?>;

        let obj = product[id-1];
        let values = Object.values(obj);
        values.push(amount);

        sessionStorage.setItem(`${id}`, values);

        for (let [key,value] of Object.entries(sessionStorage)) {
            console.log(key,value);
        }
    }
</script>

<?php 
 #   echo<<<END
 #   <div class="w-full h-1/2 grid grid-cols-3">
 #   END;

 #   echo "<div class=\"w-[50%] h-full bg-green-300 ml-[1%] rounded-3xl shadow-2xl flex justify-center\">";
 #       echo "<div class=\"w-[90%] h-[40%]  mt-[5%]\">";
 #           $parts = query_parts();
 #           $parts_0_url = $parts[0]['pictureURL'];
 #           echo "<img src=\"$parts_0_url\" class='w-full h-full rounded-3xl'></a>";
 #       echo "</div>";
 #   echo "</div>";


 #   echo <<<END
 #       <div class="w-[50%] h-full bg-green-300 ml-[1%] rounded-3xl shadow-2xl">
 #       </div> 

 #       <div class="w-[50%] h-full bg-green-300 ml-[1%] rounded-3xl shadow-2xl">
 #       </div>

 #       <div class="w-[50%] h-full bg-green-300 ml-[1%] mr-[1%] rounded-3xl shadow-2xl">
 #       </div>    

 #       <div class="w-[50%] h-full bg-green-300 ml-[1%] rounded-3xl shadow-2xl">
 #       </div>
 # 
 #       <div class="w-[50%] h-full bg-green-300 ml-[1%] rounded-3xl shadow-2xl">
 #       </div> 

 #       <div class="w-[50%] h-full bg-green-300 ml-[1%] rounded-3xl shadow-2xl">
 #       </div>

 #       <div class="w-[50%] h-full bg-green-300 ml-[1%] mr-[1%] rounded-3xl shadow-2xl">
 #       </div>    

 #   </div> 
 #   END;
?>

</body> </html>
