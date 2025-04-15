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

    $hostInventory = "blitz.cs.niu.edu";
    $dbInventory = "csci467";
    $usernameInventory = "student";
    $passwordInventory = "student";

    try {
        $dsnInventory = "mysql:host=$hostInventory;dbname=$dbInventory";
        $pdoInventory = new pdo($dsnLegacy,$usernameInventory,$passwordInventory);
    }
    catch (PDOException $e) {
        echo "failed to connect to the database. " . $e->getMessage();
    }

?>