<?php
function  query_parts() : array {
    global $pdoLegacy;
    return $pdoLegacy->query("select * from parts")->fetchAll(PDO::FETCH_ASSOC);
}

function query_quantities($pdo) : array {

    $query = "SELECT productID, quantity FROM Product;";
    $prepare = $pdo->prepare($query);

    $succ = $prepare->execute(); 
    $full =  $prepare->fetchALL(PDO::FETCH_ASSOC);
    $ret = array();

    foreach($full as $arr) {
        $ret += [$arr['productID'] => $arr['quantity']];
    }    
    return $ret;
}
function queryItemQuantity($pdo,$id) : string {
    $query = $pdo->prepare("select quantity from Product where productID = :id");
    $prepared = $query->execute(['id' => $id]);
    return $query->fetch()[0];
}

function createProductCard($part) : string {
    global $pdoInventory;
    $partDescription = ucwords($part["description"], "( ");
    $partID = $part['number'];
    $maxQuantity = queryItemQuantity($pdoInventory, $partID);

    return <<<EOT
    <div class="bg-white rounded-3xl shadow-2xl p-5">
        <!-- Image -->
        <div class="w-full h-[50%] bg-center bg-no-repeat bg-contain" style="background-image: url('$part[pictureURL]')"></div>

        <!-- Description -->
        <div class="w-full h-[10%] mt-[2%] flex">
            <p class="self-center mx-auto mt-4 drop-shadow-md tracking-wide text-xl italic"> $partDescription </p>
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
        <div class="add-to-cart w-full h-[20%] flex gap-5">
            <!-- Quantity -->
            <div class="qty-box w-[30%] h-2/3 flex items-center justify-around bg-gray-900 rounded-2xl self-center">
                <!-- Left box -- for minus -->
                <div class="minus-qty pl-[10%] cursor-pointer text-white">
                    <i class="fa fa-minus" aria-hidden="true"></i>
                </div>
                <!-- Input box -->
                <div>
                    <input type="number" placeholder="0" value="0" min="0" class="qty-input w-full placeholder-white no-spin h-full bg-gray-900 border-none outline-none text-center text-white text-xl">
                </div>
                <!-- Right box for plus -->
                <div class="plus-qty cursor-pointer pr-[10%] text-white">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                </div>
            </div>
            <!-- Add to cart button -->
            <div class="w-[70%] h-full flex justify-center items-center">
                <button 
                    id='$partID' onclick="addToCart(this)" 
                    class="cursor-pointer rounded-2xl h-2/3 bg-gray-900 shadow-lg w-full drop-shadow-2xl tracking-wide text-white hover:bg-green-500 text-xl transition-colors duration-200 ease-in-out active:scale-95"
                    data-id='$partID'
                    data-desc='$partDescription'
                    data-img='$part[pictureURL]'
                    data-price='$part[price]'
                    data-weight='$part[weight]'
                    data-max='$maxQuantity'
                    >
                    Add To Cart </button>
            </div>
        </div>
    </div>
    EOT;
}
?>

<?php 
    $parts = query_parts($pdoLegacy);
    $quantities = query_quantities($pdoInventory);
?>
