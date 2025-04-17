<?php
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

$count = 0;

function createProductCard($part) : string {
    global $count;
    ++$count;
    $partDescription = ucwords($part["description"], "( ");
    return <<<EOT
    <div class="bg-white rounded-3xl shadow-2xl p-5">
        <!-- Image -->
        <div class="w-full h-[50%]  bg-center bg-no-repeat bg-contain" style="background-image: url('$part[pictureURL]')"></div>

        <!-- Description -->
        <div class=" w-full h-[10%] mt-[2%] flex">
            <p class="self-center mx-auto mt-4 drop-shadow-md tracking-wide font-bold text-xl italic"> $partDescription </p>
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
        <div class="w-full h-[20%] flex gap-5">
            <!-- Quantity -->
            <div class="w-[30%] h-2/3 flex items-center justify-around bg-gray-900 rounded-2xl self-center">
                <!-- Left box -- for minus -->
                <div class="minus-qty pl-[10%] cursor-pointer font-bold text-white">
                    <i class="fa fa-minus" aria-hidden="true"></i>
                </div>
                <!-- Input box -->
                <div>
                    <input type="number"  placeholder="0" min="0" class=" qty-input w-full placeholder-white no-spin h-full bg-gray-900 border-none outline-none text-center text-white font-bold text-xl">
                </div>
                <!-- Right box for plus -->
                <div class="plus-qty cursor-pointer pr-[10%] text-white font-bold">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                </div>
            </div>
            <!-- Add to cart button -->
            <div class="w-[70%] h-full flex  justify-center items-center">
                <button id='$count' onclick="addToCart(this)" class=" cursor-pointer rounded-2xl h-2/3 bg-gray-900 shadow-lg w-full  drop-shadow-2xl font-bold tracking-wide text-white hover:bg-green-500 text-xl transition-all duration-300">Add To Cart</button>
            </div>
        </div>
    </div>
    EOT;
}
?>