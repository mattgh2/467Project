<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
session_start();

require_once("dbconnect.php"); // $conn should be initialized here
require_once("utils.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["newqty"])) {
        update_quantity($pdoInventory, $_POST['newqty'], $_POST['productID'] );
         header("Location: " . $_SERVER['REQUEST_URI']);
         exit();
    }
  }
$parts = [];

try {
    $stmt = $pdoLegacy->prepare("SELECT number, description, price, weight, pictureURL FROM parts");
    $stmt->execute();
    $parts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $partQuantities = getPartQuantities($pdoInventory);

    for ($i = 0; $i < sizeof($parts); $i++) {
      $parts[$i]["quantity"] = $partQuantities[$i]['quantity'];
    }

} catch (PDOException $e) {   
    echo "Database error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Receiving Parts | Lite Up Ur Lyfe Auto Parts</title>
  <link rel="stylesheet" href="./public/css/output.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body class="bg-gradient-to-br from-blue-50 via-blue-100 to-blue-50 min-h-screen font-sans">

<!-- Navbar -->
<nav class="fixed top-0 left-0 z-50 w-full shadow-md">

<nav id="nav-bar" class="fixed top-0 left-0 z-50 w-full">
  <div class="flex items-center justify-between px-6 h-16 bg-gradient-to-bl from-[#9dd8f8] via-[#55baf2] to-[#9dd8f8]">
    <a href="./" class="text-white text-2xl">
      <i class="fa fa-home"></i>
    </a>
    <ul class="flex gap-6 text-white text-lg">
      <li class="group relative">
        <a href="./admin.php" class="cursor-pointer">
          <i class="pb-1 inline-block relative"></i> Admin
          <span class="absolute left-1/2 bottom-0 h-0.5 w-0 bg-white transition-all group-hover:w-full group-hover:left-0"></span>
        </a>
      </li>
      <li class="group relative">
        <a href="./warehouseorders.php" class="cursor-pointer">
          <i class="pb-1 inline-block relative"></i> Warehouse Orders
          <span class="absolute left-1/2 bottom-0 h-0.5 w-0 bg-white transition-all group-hover:w-full group-hover:left-0"></span>
        </a>
    </ul>
  </div>
</nav>
</nav>

  <!-- Page Content -->
<main class="pt-24 px-4 max-w-5xl mx-auto">
  <h1 class="text-4xl font-bold text-center text-blue-500 mb-10">Receiving Parts</h1>

  <!-- Catalog-style Search Bar -->
  <div class="w-2/3 max-w-2xl h-12 mx-auto flex justify-center mb-6">
    <input id="search-bar" type="text" 
      class="w-full h-full px-4 text-black bg-white placeholder-[#a0a2a3] focus:outline-none outline-sky-300 rounded-l-full" 
      placeholder="Filter by description or part number...">
    <button id="search-button"
      class="w-12 h-full flex justify-center items-center text-white bg-[#55baf2] rounded-r-full hover:opacity-80">
      <i class="fa fa-search" aria-hidden="true"></i>
    </button>
  </div>

  <!-- Parts List -->
  <section id="parts-container" class="space-y-4">
    <?php foreach ($parts as $part): ?>
      <div class="part-item bg-white rounded-xl shadow-md flex flex-row p-4 gap-6"
           data-description="<?php echo htmlspecialchars($part['description']); ?>"
           data-number="<?php echo htmlspecialchars($part['number']); ?>">
        <img src="<?php echo htmlspecialchars($part['pictureURL']); ?>" alt="<?php echo htmlspecialchars($part['description']); ?>" class="w-32 h-20 object-contain">
        <div class="flex flex-col justify-between w-full">
          <div>
            <p class="text-lg font-semibold text-blue-500"><?php echo htmlspecialchars($part['description']); ?></p>
            <p class="text-gray-700">
              $<?php echo number_format($part['price'], 2); ?> - <?php echo $part['weight']; ?> lbs
            </p>
            <p class='text-gray-700'> <?php echo "Quantity: " . $part['quantity']; ?> </p>
            <p class="text-sm text-gray-500">Part Number: <?php echo $part['number']; ?></p>
          </div>
          <div class="flex items-center gap-2 justify-end">
            <form action="" method="POST">
                <input type=hidden name=productID value=<?php echo $part['number']; ?> >
                <input type="number" min="0" name='newqty' value="0" class="w-20 p-2 border border-gray-300 rounded">
                <button type=submit class="px-4 py-2 bg-blue-400 text-white rounded-lg hover:bg-green-500 transition-colors duration-200">Update Quantity</button>
            </form>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </section>
</main>


  <!-- JS Filter Script -->
  <script>
    const searchInput = document.getElementById('search-bar');
    const partItems = document.querySelectorAll('.part-item');

    searchInput.addEventListener('input', () => {
      const term = searchInput.value.toLowerCase();

      partItems.forEach(item => {
        const desc = item.getAttribute('data-description').toLowerCase();
        const number = item.getAttribute('data-number').toLowerCase();
        const matches = desc.includes(term) || number.includes(term);
        item.style.display = matches ? 'flex' : 'none';
      });
    });
  </script>
</body>
</html>
