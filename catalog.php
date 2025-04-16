<?php // Error stuff
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
?>
<?php
include "dbconnect.php";

function  query_parts() : array {
    global $pdoLegacy;
    return $pdoLegacy->query("select * from parts")->fetchAll(PDO::FETCH_ASSOC);
}

function query_first($pdo) : array {
    $query = "SELECT * FROM parts LIMIT 1;";
    $prepare = $pdo->prepare($query);
    $success = $prepare->execute();
    
    return $prepare->fetchAll(PDO::FETCH_ASSOC)[0];
}

function createProductCard($part) : string {
    return <<<EOT
    <div class="bg-red-200 rounded-3xl shadow-2xl p-5">
        <!-- Image -->
        <div class="w-full h-[50%] shadow-sm bg-center bg-no-repeat bg-contain" style="background-image: url('$part[pictureURL]')"></div>

        <!-- Description -->
        <div class="w-full h-[10%] mt-[2%]">
            <p class="text-center italic drop-shadow-md tracking-wide font-bold text-md"> $part[description] </p>
        </div>

        <!-- Price and weight -->
        <div class="w-full h-[20%] mt-[2%] flex">
            <!-- Price -->
            <div class="w-[50%] h-full flex items-center justify-center">
                <p class="text-center"> $$part[price] </p>
            </div>
            <!-- Weight -->
            <div class="w-[50%] h-full flex items-center justify-center">
                <p class="text-center"> $part[weight] lbs </p>
            </div>
        </div>

        <!-- Add to cart button -->
        <div class="w-full h-[20%] flex">
            <!-- Quantity -->
            <div class="w-[30%] h-2/3 flex items-center justify-around bg-red-300 rounded-md self-center">
                <!-- Left box -- for plus -->
                <div class="minus-qty pl-[10%] cursor-pointer">
                    <i class="fa fa-minus" aria-hidden="true"></i>
                </div>
                <!-- Input box -->
                <div>
                    <input type="number"  placeholder="0" min="0" class=" qty-input w-full placeholder-black no-spin h-full bg-red-300 border-none outline-none text-center text-black">
                </div>
                <!-- Right box for minus -->
                <div class="plus-qty cursor-pointer pr-[10%]">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                </div>
            </div>
            <!-- Add to cart button -->
            <div class="w-[70%] h-full flex justify-center items-center">
                <button class="rounded-md h-2/3 bg-red-600 shadow-lg px-10 text-white hover:bg-red-700 text-lg">Add To Cart</button>
            </div>
        </div>
    </div>
    EOT;
}
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

<body class="w-screen h-screen m-0 bg-pink-100">
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
                <li class="text-2xl"> <a id='cart' class="text-white text-xl cursor-pointer hover:text-shadow-lg/20"> <i class="fa fa-shopping-bag" aria-hidden="true"></i> </a> </li>
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
    let incrementQty = document.querySelectorAll('[class*="plus-qty"]');
    let decrementQty = document.querySelectorAll('[class*="minus-qty"]');
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
