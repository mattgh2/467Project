<?php
    $hostLegacy = "blitz.cs.niu.edu";
    $dbnameLegacy = "csci467";
    $usernameLegacy = "student";
    $passwordLegacy = "student";

    try {
        $dsnLegacy = "mysql:host=$hostLegacy;dbname=$dbnameLegacy";
        $pdoLegacy = new pdo($dsnLegacy,$usernameLegacy,$passwordLegacy);
    }
    catch (PDOException $e) {
        echo "failed to connect to the database. " . $e->getMessage();
    }

    $hostInventory = "65.38.96.193";
    $dbInventory = "InventoryOrders";
    $usernameInventory = "tux";
    $passwordInventory = "123";

    try {
        $dsnInventory = "mysql:host=$hostInventory;dbname=$dbInventory";
        $pdoInventory = new pdo($dsnInventory,$usernameInventory,$passwordInventory);
    }
    catch (PDOException $e) {
        echo "failed to connect to the database. " . $e->getMessage();
    }

?>