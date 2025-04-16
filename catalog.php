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
?>

<html>
<head>
    <link rel="stylesheet" href="./src/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- <meta http-equiv="refresh" content="1"> -->
    <title>Lite Up Ur Lyfe Auto Parts</title>
</head>

<body class="w-screen h-screen m-0 bg-pink-100">

<?php // functions
function createProductCard($part)  {
      echo "<div class=\"bg-red-200 rounded-3xl shadow-2xl p-5\">";
            // Image
            echo "<div class='w-full h-[50%] shadow-sm bg-center bg-[url($part[pictureURL])] bg-no-repeat bg-contain'>";
            echo "</div>"; 

            // Description
            echo "<div class='w-full h-[10%] mt-[2%]'>";
                echo "<p class='text-center italic drop-shadow-md tracking-wide font-bold text-md'> $part[description] </p>";
            echo "</div>";
            
            // Price and weight
            echo "<div class='w-full h-[20%] mt-[2%]  flex'>";
                // Price
                echo "<div class='w-[50%] h-full flex items-center justify-center'>";
                    echo "<p class='text-center'> $$part[price] </p>";
                echo "</div>";

                // Weight
                echo "<div class='w-[50%] h-full  flex items-center justify-center'>";
                    echo "<p class='text-center'> $part[weight] lbs </p>";
                echo "</div>";
            echo "</div>";

            // Add to cart button
            echo "<div class='w-full h-[20%]  flex'>";
                // Quantity
                    echo "<div class='w-[30%] h-2/3 flex items-center justify-around bg-red-300 rounded-md self-center'>"; 
                // left box -- for plus
                    echo "<div id='plus-qty'class='pl-[10%] cursor-pointer'><i class='fa fa-plus' aria-hidden=true'></i></div>";
                // input box
                    echo "<div><input type='number' id='qty' placeholder=0 min=0 class='w-full  placeholder-black no-spin h-full bg-red-300 border-none outline-none text-center text-black'></div>";
                // right box for minus
                    echo "<div id='minus-qty' class='cursor-pointer pr-[10%]'><i class='fa fa-minus' aria-hidden='true'></i></div>";

                echo "</div>";

                // Add to cart button
                echo "<div class='w-[70%] h-full flex justify-center  items-center'>";
                    echo "<button class='rounded-md h-2/3 bg-red-600 shadow-lg px-10 text-white hover:bg-red-700 text-lg'>Add To Cart</button>";
                echo "</div>";
            echo "</div>";
    
        echo "</div>";
}
?>
    <style>
        .no-spin::-webkit-inner-spin-button,
        .no-spin::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        .no-spin {
            -moz-appearance: textfield;
        }
    </style>

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
    $first = query_first($pdoLegacy);
    $parts = query_parts($pdoLegacy);
    echo "<div class=\"h-screen grid xl:grid-cols-5  grid-cols-3 gap-4 gap-x-10 p-6 auto-rows-[40vh]\">";
        foreach ($parts as $part) {
           createProductCard($part);
        }
        
    echo "</div>";
?>
<script defer>
    let counter = 0;
    let incrementQty = document.getElementById('plus-qty');
    let decrementQty = document.getElementById('minus-qty');
    let qty = document.getElementById('qty');

    incrementQty.addEventListener('click', ()=> {
        ++counter;
        qty.value = counter;    
    });
    decrementQty.addEventListener('click', ()=> {
        --counter;
        if (counter < 0) {
            counter = 0;
        }
        qty.value = counter; 
    });
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
