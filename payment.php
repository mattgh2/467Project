<?php
include "dbconnect.php";
require_once("utils.php");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Favicon links -->
    <link rel="icon" href="assets/favicon.ico" type="image/x-icon" />
    <link
      rel="icon"
      type="image/png"
      href="assets/favicon-32x32.png"
      sizes="32x32"
    />
    <link
      rel="icon"
      type="image/png"
      href="assets/favicon-16x16.png"
      sizes="16x16"
    />

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./public/css/output.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <title>Secure Payment | Lite Up Ur Lyfe</title>
  </head>
  <body class="m-0 p-0 min-h-screen w-screen overflow-x-hidden bg-[#ffffff]">
    <!-- Nav -->
    <?php include "navbar.php"; ?>

    <!-- Payment Form Section -->
    <section
      class="pt-[100px] pb-20 px-6 bg-[#f0f8ff] min-h-screen flex justify-center items-start"
    >
    <!-- Faded background image with gradient overlay -->
    <div
    class="absolute min-h-screen pt-[65%] pb-[65%] px-[50%] flex justify-center items-start overflow-x-hidden bg-[url('https://cdn.discordapp.com/attachments/1361911348401012816/1362920988282716323/cb4dd127a356da089419fcf622862a86.png?ex=68042695&is=6802d515&hm=5d9c1a0c63ffc42992fab2712806948f4bed27a6db5a32ff6bf3c7c4829b82b0&')] bg-cover bg-center opacity-55"
    >
    <div class="w-full h-full bg-gradient-to-b  from-white/80 via-white/80 to-white/80"></div>
    </div>
        
      <div class="w-full max-w-2xl bg-white rounded-xl shadow-md p-8">
        <h2 class="text-3xl font-bold text-[#55baf2] mb-6 text-center">
          Payment Information
        </h2>

        <form action="process_payment.php" method="POST" class="space-y-6">
          <!-- Name -->
          <div>
            <label class="block text-gray-700 font-semibold mb-1" for="name"
              >Full Name</label
            >
            <input
              type="text"
              id="name"
              name="name"
              autocomplete="name"
              required
              class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#55baf2]"
            />
          </div>

          <!-- Email -->
          <div>
            <label class="block text-gray-700 font-semibold mb-1" for="email"
              >Email</label
            >
            <input
              type="email"
              id="email"
              name="email"
              autocomplete="email"
              required
              class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#55baf2]"
            />
          </div>

          <!-- Shipping Address -->
          <h3 class="text-lg font-semibold text-[#55baf2] mt-4">
            Shipping Address
          </h3>

          <div>
            <label class="block text-gray-700 font-semibold mb-1" for="address"
              >Street Address</label
            >
            <input
              type="text"
              id="address"
              name="address"
              autocomplete="shipping street-address"
              required
              class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#55baf2]"
            />
          </div>

          <div class="flex gap-4">
            <div class="w-1/2">
              <label class="block text-gray-700 font-semibold mb-1" for="city"
                >City</label
              >
              <input
                type="text"
                id="city"
                name="city"
                autocomplete="shipping address-level2"
                required
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#55baf2]"
              />
            </div>
            <div class="w-1/2">
              <label class="block text-gray-700 font-semibold mb-1" for="state"
                >State</label
              >
              <input
                type="text"
                id="state"
                name="state"
                autocomplete="shipping address-level1"
                required
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#55baf2]"
              />
            </div>
          </div>

          <div class="flex gap-4">
            <div class="w-1/2">
              <label class="block text-gray-700 font-semibold mb-1" for="zip"
                >ZIP Code</label
              >
              <input
                type="text"
                id="zip"
                name="zip"
                autocomplete="shipping postal-code"
                required
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#55baf2]"
              />
            </div>
            <div class="w-1/2">
              <label
                class="block text-gray-700 font-semibold mb-1"
                for="country"
                >Country</label
              >
              <input
                type="text"
                id="country"
                name="country"
                autocomplete="shipping country-name"
                required
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#55baf2]"
              />
            </div>
          </div>

          <!-- Billing Checkbox -->
          <div class="flex items-center">
            <input
              type="checkbox"
              id="same-as-shipping"
              name="same_as_shipping"
              class="mr-2 h-4 w-4 text-[#55baf2] border-gray-300 rounded"
            />
            <label for="same-as-shipping" class="text-gray-700"
              >Billing address is the same as shipping</label
            >
          </div>

          <!-- Billing Address -->
          <div id="billing-fields" class="space-y-4">
            <h3 class="text-lg font-semibold text-[#55baf2] mt-4">
              Billing Address
            </h3>

            <div>
              <label
                class="block text-gray-700 font-semibold mb-1"
                for="billing_address"
                >Street Address</label
              >
              <input
                type="text"
                id="billing_address"
                name="billing_address"
                autocomplete="billing street-address"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#55baf2]"
              />
            </div>

            <div class="flex gap-4">
              <div class="w-1/2">
                <label
                  class="block text-gray-700 font-semibold mb-1"
                  for="billing_city"
                  >City</label
                >
                <input
                  type="text"
                  id="billing_city"
                  name="billing_city"
                  autocomplete="billing address-level2"
                  class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#55baf2]"
                />
              </div>
              <div class="w-1/2">
                <label
                  class="block text-gray-700 font-semibold mb-1"
                  for="billing_state"
                  >State</label
                >
                <input
                  type="text"
                  id="billing_state"
                  name="billing_state"
                  autocomplete="billing address-level1"
                  class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#55baf2]"
                />
              </div>
            </div>

            <div class="flex gap-4">
              <div class="w-1/2">
                <label
                  class="block text-gray-700 font-semibold mb-1"
                  for="billing_zip"
                  >ZIP Code</label
                >
                <input
                  type="text"
                  id="billing_zip"
                  name="billing_zip"
                  autocomplete="billing postal-code"
                  class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#55baf2]"
                />
              </div>
              <div class="w-1/2">
                <label
                  class="block text-gray-700 font-semibold mb-1"
                  for="billing_country"
                  >Country</label
                >
                <input
                  type="text"
                  id="billing_country"
                  name="billing_country"
                  autocomplete="billing country-name"
                  class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#55baf2]"
                />
              </div>
            </div>
          </div>

          <!-- Credit Card Number -->
          <div>
            <label
              class="block text-gray-700 font-semibold mb-1"
              for="cc-number"
              >Card Number</label
            >
            <div class="flex items-center border border-gray-300 rounded-md">
              <input
                type="text"
                id="cc-number"
                name="cc_number"
                inputmode="numeric"
                pattern="[0-9\s]{13,19}"
                maxlength="19"
                autocomplete="cc-number"
                placeholder="1234 5678 9012 3456"
                required
                class="w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#55baf2]"
              />
              <!-- Card icons -->
              <div class="ml-4 flex space-x-2 p-2">
                <i class="fa fa-cc-visa text-xl text-blue-500"></i>
                <i class="fa fa-cc-mastercard text-xl text-red-500"></i>
                <i class="fa fa-cc-amex text-xl text-blue-700"></i>
                <i class="fa fa-cc-discover text-xl text-orange-600"></i>
              </div>
            </div>
          </div>

          <!-- Expiration -->
          <div class="flex gap-4">
            <div class="w-1/2">
              <label class="block text-gray-700 font-semibold mb-1" for="cc-exp"
                >Exp Date (MM/YY)</label
              >
              <input
                type="text"
                id="cc-exp"
                name="cc_exp"
                placeholder="MM/YY"
                autocomplete="cc-exp"
                required
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#55baf2]"
              />
            </div>
            <div class="w-1/2">
              <label class="block text-gray-700 font-semibold mb-1" for="cc-cvc"
                >CVC</label
              >
              <input
                type="text"
                id="cc-cvc"
                name="cc_cvc"
                inputmode="numeric"
                autocomplete="cc-csc"
                required
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#55baf2]"
              />
            </div>
          </div>

          <!-- Submit Button -->
          <div class="text-center">
            <button
              type="submit"
              class="w-full bg-[#55baf2] hover:bg-green-600 text-white font-bold py-4 px-10 text-lg rounded-lg transition-all duration-300"
            >
              Complete Payment
            </button>
          </div>
        </form>
      </div>
    </section>

    <footer class="w-full bg-[#151515] text-white py-15 px-6">
      <div
        class="max-w-5xl mx-auto flex flex-col md:flex-row md:items-start md:justify-between space-y-6"
      >
        <div class="flex items-start gap-4">
          <img
            src="assets/logo.png"
            alt="Logo"
            class="w-16 h-13 object-contain"
          />
          <div class="text-sm text-gray-300">
            <p class="font-bold">Lite Up Ur Lyfe Auto Parts</p>
            <p>
              Your go-to for bold, bright, and budget-friendly auto lighting.
            </p>
          </div>
        </div>

        <div class="text-sm text-gray-400">
          <p>Email: support@liteupartz.com</p>
          <p>Phone: (123) 456-7890</p>
        </div>

        <div class="flex justify-center space-x-6 pt-4">
          <i class="fa fa-facebook-official text-xl hover:text-[#55baf2]"></i>
          <i class="fa fa-twitter text-xl hover:text-[#55baf2]"></i>
          <i class="fa fa-instagram text-xl hover:text-[#55baf2]"></i>
          <i class="fa fa-linkedin text-xl hover:text-[#55baf2]"></i>
        </div>
      </div>
    </footer>

    <!-- JS for billing address toggle -->
    <script>
      const checkbox = document.getElementById("same-as-shipping");
      const billingFields = document.getElementById("billing-fields");

      checkbox.addEventListener("change", () => {
        billingFields.style.display = checkbox.checked ? "none" : "block";
      });

      window.addEventListener("DOMContentLoaded", () => {
        billingFields.style.display = checkbox.checked ? "none" : "block";
      });
    </script>
  </body>
</html>