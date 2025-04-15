<?php // Error stuff
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
?>
<?php // Includes
    include "dbconnect.php";
?>

<html>
<head>
    <link rel="stylesheet" href="./src/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <meta http-equiv="refresh" content="1">
    <title>Home</title>
</head>

<body class="w-100 h-100 bg-gray-100">

<?php // Functions
?>
<?php
    echo <<<END
        <div w-64 bg-green-200>
            <ul>
                <li> Home </li>
                <li> Catalog </li>
                <li> Warehouse </li>
                <li> Admin </li>
                </i> <i class="fa fa-shopping-cart" aria-hidden="true"></i> </li>
            </ul>
        </div>
    END;
?>

</body> </html>