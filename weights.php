<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
session_start();
require_once("dbconnect.php");
require_once('utils.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lite Up Ur Lyfe Auto Parts</title>
  <link rel="icon" href="assets/favicon.ico" type="image/x-icon" />
  <link rel="stylesheet" href="./public/css/output.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body class="w-screen h-screen m-0 bg-gradient-to-br from-blue-50 via-blue-100 to-blue-50 min-h-screen font-sans">

  <!-- Navbar -->
  <nav class="fixed top-0 left-0 z-50 w-full shadow-md">
    <div class="flex items-center justify-between px-6 h-16 bg-gradient-to-bl from-[#9dd8f8] via-[#55baf2] to-[#9dd8f8]">
      <a href="./" class="text-white text-2xl">
        <i class="fa fa-home"></i>
      </a>
      <ul class="flex gap-6 text-white text-lg">
        <li class="group relative">
          <a class="cursor-pointer">
            <i class="fa fa-lock"></i> Warehouse
            <span class="absolute left-1/2 bottom-0 h-0.5 w-0 bg-white transition-all group-hover:w-full group-hover:left-0"></span>
          </a>
        </li>
      </ul>
    </div>
  </nav>

  <!-- Page Content -->
  <div class="pt-24 px-4 flex flex-col items-center gap-10">

    <!-- Add Bracket Form -->
    <form action="./weights.php" method="POST" class="flex flex-col md:flex-row gap-4 w-full max-w-3xl bg-white p-6 rounded-xl shadow-lg">
      <input required type="number" name="leftBound" placeholder="Lower Bound"
        class="flex-1 px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400" min="0">
      <input required type="number" name="price" placeholder="Price"
        class="flex-1 px-4 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400" min="0">
      <input type="submit" value="Add Bracket"
        class="bg-blue-400 text-white px-6 py-2 rounded-md shadow-md hover:bg-green-500 transition-colors cursor-pointer">
    </form>

    <!-- Brackets Table -->
    <div class="w-full max-w-3xl bg-white rounded-xl shadow-lg overflow-hidden">
      <table class="w-full table-auto">
        <thead class="bg-blue-300 text-left text-gray-800">
          <tr>
            <th class="px-6 py-4">Left Bound</th>
            <th class="px-12 py-4 whitespace-nowrap">Right Bound</th>
            <th class="px-6 py-4">Price</th>
            <th class="px-6 py-4 text-center">Action</th>
          </tr>
        </thead>
        <tbody class="text-gray-700">
          <?php
          if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (isset($_POST["leftBound"], $_POST["price"])) {
              changeBrackets($pdoInventory, $_POST["leftBound"], $_POST["price"]);
            }
            if (isset($_POST['delete'])) {
              $leftBound = $_POST['LeftBound'];
              $rightBound = $_POST['RightBound'];
              delete_from_DB($pdoInventory, $leftBound, $rightBound);
              check_no_brackets($pdoInventory);
            }
          }

          $_brackets = createBracketsArray($pdoInventory);
          foreach ($_brackets as $bracket) {
            echo "<tr class='border-t'>";
            echo "<td class='px-6 py-4'>{$bracket[0]}</td>";
            echo "<td class='px-6 py-4'>{$bracket[1]}</td>";
            echo "<td class='px-6 py-4'>$" . $bracket[2] . "</td>";
            echo "<td class='px-6 py-4 text-center'>";
            echo "<form action='' method='POST' class='inline'>";
            echo "<input type='hidden' name='LeftBound' value='{$bracket[0]}'>";
            echo "<input type='hidden' name='RightBound' value='{$bracket[1]}'>";
            echo "<button type='submit' name='delete' class='text-red-600 hover:underline'>Remove</button>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
          }
          ?>
        </tbody>
      </table>
    </div>

  </div>

</body>
</html>
