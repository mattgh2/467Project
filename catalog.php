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

?>

<html>
<head>
    <link rel="stylesheet" href="./src/output.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://cdn.tailwindcss.com"></script>
    <meta http-equiv="refresh" content="1">
    <title>Lite Up Ur Lyfe Auto Parts</title>
</head>

<body class="w-screen h-screen m-0 bg-pink-100">

<?php // functions
?>
<?php
    echo <<<END
    <div class="w-full bg-white h-[7%] flex shadow-xl mb-[2%]">
        <div class="w-[10%] h-full flex justify-center items-center">
             <h1 class="flex justify-center items-center  ml-[1%]"> <a id='home-page' href="./index.php"> Home </a> </h1>
        </div>
        <div class="w-full h-full flex justify-end items-center mr-[2%]"> 
            <ul class="flex h-full items-center justify-center gap-10">
            <li class=""> <a href="./catalog.php" class="hover:text-green-500 cursor-pointer"> Catalog </a> </li>
            <li> <a> <i class="fa fa-lock" aria-hidden="true"></i> Warehouse </a> </li>
            <li> <a> <i class="fa fa-lock" aria-hidden="true"></i> Admin </a> </li>
            <li class="text-2xl"> <a> <i class="fa fa-shopping-bag" aria-hidden="true"></i> </a> </li>
        </ul>
        </div>
    </div>
    END;
?>
<?php 
    echo<<<END
    <div class="w-full h-1/2 flex">
    END;

    echo "<div class=\"w-[25%] h-full bg-green-300 ml-[1%] rounded-3xl shadow-2xl flex justify-center\">";
        echo "<div class=\"w-[90%] h-[40%]  mt-[5%]\">";
            $parts = query_parts();
            $parts_0_url = $parts[0]['pictureURL'];
            echo "<img src=\"$parts_0_url\" class='w-full h-full rounded-3xl'></a>";
        echo "</div>";
    echo "</div>";


    echo <<<END
        <div class="w-[25%] h-full bg-green-300 ml-[1%] rounded-3xl shadow-2xl">
        </div> 
    END;

    echo <<<END
        <div class="w-[25%] h-full bg-green-300 ml-[1%] rounded-3xl shadow-2xl">
        </div>
    END;

    echo <<<END
        <div class="w-[25%] h-full bg-green-300 ml-[1%] mr-[1%] rounded-3xl shadow-2xl">
        </div>    
    </div>    
    END;

    echo <<<END
    <div class="w-full h-1/2 flex mt-[2%]">
        <div class="w-[25%] h-full bg-green-300 ml-[1%] rounded-3xl shadow-2xl">
        </div>
  
        <div class="w-[25%] h-full bg-green-300 ml-[1%] rounded-3xl shadow-2xl">
        </div> 

        <div class="w-[25%] h-full bg-green-300 ml-[1%] rounded-3xl shadow-2xl">
        </div>

        <div class="w-[25%] h-full bg-green-300 ml-[1%] mr-[1%] rounded-3xl shadow-2xl">
        </div>    
    END;

    echo <<<END
    </div> 
    END;
?>

</body> </html>