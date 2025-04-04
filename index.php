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
    <title>Test...</title>
</head>

<body class="bg-indigo-500">
    <h1>changed this ....</h1>
</body>

</html>