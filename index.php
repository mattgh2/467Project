<?php
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    $host = "blitz.cs.niu.edu";
    $dbname = "csci467";
    $username = "student";
    $password = "student";

    try {
        $dsn = "mysql:host=$host;dbname=$dbname";
        $pdo = new pdo($dsn,$username,$password);
    }
    catch (PDOException $e) {
        echo "failed to connect to the database. " . $e->getMessage();
    }
?>

<html>
<head>
    <link rel="stylesheet" href="./src/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta http-equiv="refresh" content="1">
    <title>Test...</title>
</head>

<body class="bg-pink-200">
    <div class="flex w-full h-full justify-center items-center">
        <div class="bg-white h-50 w-100 self-center rounded-md shadow-md hover:scale-150 cursor-pointer hover:shadow-xl flex">
            <h1 class="self-center mx-auto"> center text </h1>
        </div>
    </div>
</body>

</html>