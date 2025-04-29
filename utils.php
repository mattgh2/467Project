<?php
include "dbconnect.php";

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
function getPartQuantities($pdo) : array {
    return $pdo->query("select * from Product")->fetchAll(PDO::FETCH_ASSOC);
}

function queryItemQuantity($pdo,$id) : string {
    $query = $pdo->prepare("select quantity from Product where productID = :id");
    $prepared = $query->execute(['id' => $id]);
    return $query->fetch()[0];
}
function getAllWeightBrackets($pdo) {
    return $pdo->query("select * from weightBrackets")->fetchALL(PDO::FETCH_ASSOC); 
}
function createBracketsArray($pdo) : array {
    $brackets = getAllWeightBrackets($pdo);
    $arr = array();
    // [LeftBound Rightbound Price]
    foreach($brackets as $bracket) {
        $arr[] = [$bracket["LeftBound"], $bracket["RightBound"], $bracket["Price"]];
    }
    return $arr;
}

function delete_from_DB($pdo, $lb, $rb) {
    $brackets = createBracketsArray($pdo);
    $rightBound = -1;
    $leftBound = -1;
    foreach ($brackets as $bracket) { 
        if ($rb == 100000 && $bracket[1] == $lb) {
            $leftBound = $bracket[0];
        }
        else if ($bracket[0] == $rb) {
            $rightBound = $bracket[1];
        }
    }
    if ($leftBound >= 0) {
        $pdo->exec("update weightBrackets set RightBound = 100000 where LeftBound = $leftBound and RightBound = $lb");
    }
    else {
        $pdo->exec("update weightBrackets set LeftBound = $lb where LeftBound = $rb and RightBound = $rightBound");
    }
    $pdo->exec("DELETE FROM weightBrackets WHERE LeftBound=$lb AND RightBound=$rb");
}

function check_no_brackets($pdo) {
    $q = $pdo->query("SELECT * FROM weightBrackets")->fetchALL(PDO::FETCH_ASSOC);

    if (!sizeof($q)) {
        $pdo->exec("INSERT INTO weightBrackets (LeftBound, RightBound, Price) VALUES (0, 100000, 5)");
    }
}

function get_orders($pdo) {
    $query = "SELECT * FROM Orders;";
    $prepare = $pdo->prepare($query);
    $success = $prepare->execute();

    return $prepare->fetchAll(PDO::FETCH_ASSOC);
}

function complete_order($pdo, $order_id) {
    $pdo->exec("DELETE FROM OrderProduct WHERE orderID=$order_id");
    $pdo->exec("DELETE FROM Orders WHERE orderID=$order_id");
}

function get_products_from_orders($pdo, $order_id) {
    $query = "SELECT productName FROM OrderProduct, Orders, Product WHERE OrderProduct.orderID = Orders.orderID AND OrderProduct.orderID = :id AND Product.productID = OrderProduct.productID;";
    $prepare = $pdo->prepare($query);

    $success = $prepare->execute(array(":id" => $order_id));
    $tmp = $prepare->fetchAll(PDO::FETCH_ASSOC);
    $product_list = array();
    foreach($tmp as $product) {
        $product_list[] = $product['productName'];
    }
    return $product_list;
}

function get_quantity_list_from_order_id($pdo, $order_id) {
    $query = "SELECT qty FROM OrderProduct, Orders, Product WHERE OrderProduct.orderID = Orders.orderID AND OrderProduct.orderID = :id AND Product.productID = OrderProduct.productID;";
    $prepare = $pdo->prepare($query);
    $success = $prepare->execute(array(":id" => $order_id));
    $tmp = $prepare->fetchAll(PDO::FETCH_ASSOC);
    $quantity_list = array();
    foreach($tmp as $quantity) {
        $quantity_list[] = $quantity['qty'];
    }
    return $quantity_list;
}

function get_name_qty_and_price($pdo, $order_id) {
    $query = "SELECT productName, qty, price FROM Product, OrderProduct WHERE OrderProduct.productID = Product.productID AND OrderProduct.orderID = :id";
    $prepare = $pdo->prepare($query);
    $success = $prepare->execute(array(":id" => $order_id));
    return $prepare->fetchAll(PDO::FETCH_ASSOC);
}

function changeBrackets($pdo, $lb, $price) {
    $brackets = createBracketsArray($pdo);
    $idx = 0;
    $max = $brackets[0][0];
    $found = false;

    $i = 0;
    foreach($brackets as $bracket) {
        if ($bracket[0] == $lb) {
            $found = true;
        } else if ($bracket[0] < $lb) {
            $idx = $i;
            $max = $bracket[0];
        }
        $i++;
    }

    

    $left = $brackets[$idx][0];
    $right = $brackets[$idx][1];
    $p = $brackets[$idx][2];

    if ($found) {
        $pdo->exec("UPDATE weightBrackets SET Price=$price WHERE LeftBound = $lb");
        return;
    }

    $update = "update weightBrackets set RightBound = $lb where LeftBound = $left and RightBound = $right";
    $insert = "INSERT INTO weightBrackets (LeftBound, RightBound, Price) VALUES ($lb, $right, $price)";
    $pdo->exec($update);
    $pdo->exec($insert);
}

function insert_customer_data($pdo, $name, $email, $address, $city, $state, $zip) : string {
    $prepared = $pdo->prepare("select customerId from Customer where customerName = :name and email = :email");
    $res = $prepared->execute([":name" => $name, ":email" => $email]);

    $res = $prepared->fetchAll(PDO::FETCH_ASSOC);
    if (sizeof($res)) return $res[0]['customerId'];

    $query = "INSERT INTO Customer (customerName, email, addr, City, State, Zip) VALUES (:name, :email, :address, :city, :state, :zip);";
    $prepare = $pdo->prepare($query);
    $success = $prepare->execute(array(":name" => $name, ":email" => $email, ":address" => $address, ":city" => $city, "state" => $state, "zip" => $zip));

    $prepared = $pdo->prepare("select customerID from Customer where customerName = :name and email = :email");
    $success = $prepared->execute(['name' => $name, 'email' => $email]);
    $res = $prepared->fetchAll(PDO::FETCH_ASSOC);
    return $res[0]["customerID"];
}

function getProductFromID($pdo, $productID) : string {
    $prepare = $pdo->prepare("select description from parts where number = :productID");
    $success = $prepare->execute([":productID" => $productID]);
    return $prepare->fetch(PDO::FETCH_ASSOC)['description'];
}

function insert_order($pdo, $customer_id, $amount, $shipping_cost,  $status="Authorized") {
    $date = date('Y-m-d');

    $query = "INSERT INTO Orders (customerID, orderStatus, orderDate, amount, ShippingCost) VALUES (:id, :status, :orderDate, :amount, :shipping_cost);";

    $prepare = $pdo->prepare($query);
    $success = $prepare->execute(array(":id" => $customer_id, ":status" => $status, ":orderDate" => $date, ":amount" => $amount, ":shipping_cost" => $shipping_cost));
    $res = $prepare->fetchAll(PDO::FETCH_ASSOC);

    $prepare = $pdo->prepare("select orderID from Orders where customerID = :customerID");
    return $pdo->lastInsertId();
}

function set_shipped($pdo, $order_id) {
    $query = "UPDATE Orders SET orderStatus = Shipped WHERE orderID = :id";
    $prepare = $pdo->prepare($query);
    $success = $prepare->execute(array(":id" => $order_id));
}

function insert_order_product($pdo, $order_number, $product_id, $qty, $price) {
    $query = "INSERT INTO OrderProduct (orderID, productID, qty, Price) VALUES (:order_number, :product_id, :qty, :price);";
    $prepare = $pdo->prepare($query);
    $success = $prepare->execute(array(":order_number" => $order_number, ":product_id" => $product_id, ":qty" => $qty, ":price" => $price));

    if ($success) {
        $pdo->exec("UPDATE Product SET quantity=quantity-$qty WHERE productID=$product_id");
    }
}
function getCustomerIDfromOrderId($pdo, $orderID) : string {
    $prepare = $pdo->prepare("select customerID from Orders where orderID = :orderid");
    $succ = $prepare->execute(["orderid" => $orderID]);
    $tmp = $prepare->fetch(PDO::FETCH_NUM)[0];
    return "$tmp";
} 

function getCustomerInfo($pdo, $customerID) {
    $prepare = $pdo->prepare("select * from Customer where customerID = :id");
    $success = $prepare->execute([":id" => $customerID]);
    return $prepare->fetch(PDO::FETCH_ASSOC);
}

function update_quantity($pdo, $qty, $id) {
    $query = "UPDATE Product SET quantity=quantity+:qty WHERE productID=:id";
    $prepare = $pdo->prepare($query);
    $success = $prepare->execute(array(":qty" => $qty, ":id" => $id));
}

function createProductCard($part) : string {
    global $pdoInventory;
    $partDescription = ucwords($part["description"], "( ");
    $partID = $part['number'];
    $maxQuantity = queryItemQuantity($pdoInventory, $partID);

    return <<<EOT
    <div class="product-card bg-white rounded-3xl shadow-2xl p-5">
        <!-- Image -->
        <div class="w-full h-[50%] bg-center bg-no-repeat bg-contain" style="background-image: url('$part[pictureURL]')"></div>

        <!-- Description -->
        <div class="w-full h-[10%] mt-[2%] flex">
            <p class="desc self-center mx-auto mt-4 drop-shadow-md tracking-wide text-xl italic"> $partDescription </p>
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
            <div class="qty-box w-[30%] h-2/3 flex items-center justify-around bg-[#55baf2] rounded-2xl self-center">
                <!-- Left box -- for minus -->
                <div class="minus-qty pl-[10%] cursor-pointer text-white">
                    <i class="fa fa-minus" aria-hidden="true"></i>
                </div>
                <!-- Input box -->
                <div>
                    <input type="number" placeholder="0" value="0" min="0" class="qty-input w-full placeholder-white no-spin h-full bg-[#55baf2] border-none outline-none text-center text-white text-xl">
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
                    class="cursor-pointer rounded-2xl h-2/3 bg-[#55baf2] shadow-lg w-full drop-shadow-2xl tracking-wide text-white hover:bg-green-500 text-xl transition-colors duration-200 ease-in-out active:scale-95"
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
    $brackets = getAllWeightBrackets($pdoInventory);
    // changeBrackets($pdoInventory);
?>