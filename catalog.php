<?php // Error stuff
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    session_start();
?>
<?php
require_once("dbconnect.php");
require_once('utils.php');
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

<body class="w-screen h-screen m-0 bg-gray-200">
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


<?php
    echo "<div class=\"h-screen grid 2xl:grid-cols-5  grid-cols-3 gap-4 gap-x-10 p-6 auto-rows-[40vh] mt-48 \">";
        foreach ($parts as $part) echo createProductCard($part);
    echo "</div>";
?>

<script defer>

    let qtyBox = document.querySelectorAll('.qty-box');
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
        let amount = quantities[parseInt(id)-1];

        if (amount == 0) {
            let AmountBox = qtyBox[parseInt(id-1)];
            AmountBox.classList.add("animate-bounce-once");
            setTimeout(() => {
                AmountBox.classList.remove("animate-bounce-once");
            }, 1300);
            return;
        }

        if (!sessionStorage.getItem(id)) {
            let count = parseInt(cartCounter.innerHTML);
            cartCounter.innerHTML = count + 1;
        };

        const product = <?php echo json_encode($parts); ?>;
        const _qty = <?php echo json_encode($quantities) ?>;
         
        let obj = product[id-1];
        let values = Object.values(obj);
        let maxQty = _qty[id];
        values.push(amount);
        values.push(maxQty);

        sessionStorage.setItem(`${id}`, values);

        for (let [key,value] of Object.entries(sessionStorage)) {
            console.log(key,value);
        }
    }
</script>
<script src="./cart.js"></script>

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
