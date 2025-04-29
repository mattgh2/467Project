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

<?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST["username"]) && isset($_POST["password"])) {
            $username = $_POST["username"];
            $password = $_POST["password"];
            if ($username === "warehouse" && $password === "password") {
                header('Location: ./warehouse.php');
                exit;
            } else {
                header('Location: signinwarehouse.php?error=1');
                exit;
            }
        }
    }
    $showErrorAlert = isset($_GET['error']);
?>

  <?php if ($showErrorAlert): ?>
    <script>
      alert('Error: This password is already used by starboy98. Try another');
    </script>
  <?php endif; ?>

<body> 
    
    <div class='w-full h-full bg-blue-200 flex justify-center items-center'>
        <div class = 'w-[35%] h-[60%] bg-white shadow-2xl rounded-2xl'>
            <div class='w-full h-[20%] flex justify-center items-center'>
                <h1 class='text-2xl italic'> Warehouse Sign In </h1>
            </div> 

            <div class='w-full h-[80%] '>
                <form action="" method="POST" class='flex justify-center items-center flex-col w-full h-full p-8'>
                    <input name=username required type=text placeholder="Username" class='bg-[#dedede] border-0 outline-0 p-4 rounded-2xl relative bottom-[10%] hover:bg-green-200'>
                    <input name=password required type=password placeholder="Password" class='bg-[#dedede] border-0 outline-0 p-4 rounded-2xl relative bottom-[5%] hover:bg-green-200'>
                    <input type=submit value="Login" class='bg-blue-200 border-0 outline-0 p-4 rounded-2xl w-[35%] hover:bg-green-200'>
                </form>
            </div>
        </div>
    </div>

</body></html>