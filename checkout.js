import {calculateShipping} from "./utils.js";

let cartCounter = document.getElementById("cart-counter");
cartCounter.innerHTML = sessionStorage.length;


// Div for all cart items
let cartItems = document.getElementById("cart-items");

var weightTotal = 0;
// For each part in cart
for (let [key, value] of Object.entries(sessionStorage)) {
  // Get information about part
  let v = value.split(",");
  let id = v[0];
  let desc = v[1];
  var price = v[2];
  let weight = v[3];
  let _url = v[4];
  var quantity = v[5];
  let max_qty = v[6];

  weightTotal+=weight*quantity;
  console.log(weightTotal);
  var shippingCost = calculateShipping(weightTotal);

  // Div for all information
  let all = document.createElement("div");
  all.id = key;
  all.className = "all w-full h-[30%] border-l-0 border-r-0 border-t-2 border-b-2  bg-white shadow-2xl border-grey-50 flex flex-col wrap bg-white/80";
  cartItems.appendChild(all);

  let blackBox = document.createElement("div");
  blackBox.className = "w-full h-full ";

  // Top box
  let topBox = document.createElement("div");
  topBox.className = "w-full h-[80%]  flex wrap";

  // Bottom box
  let bottomAll = document.createElement("div");
  bottomAll.className = "w-full h-[20%]  flex";

  // Add top box and bottom box to html tree
  all.appendChild(blackBox);
  blackBox.appendChild(topBox);
  blackBox.appendChild(bottomAll);

  // Image for part
  let topImage = document.createElement("div");
  topImage.className = "w-[30%] h-full bg-no-repeat bg-contain bg-center";
  topImage.style.backgroundImage = `url(${_url})`;

  // Description div and p tag
  let topDesc = document.createElement("div");
  topDesc.className = "w-[30%] h-full ";
  let topDescP = document.createElement("p");
  topDescP.innerText = desc;
  topDescP.className =
    "ml-[5%] mt-[2%] p-2 font-semibold xl:text-lg text-sm capitalize";
  topDesc.appendChild(topDescP);

  // Price for one part
  let topEach = document.createElement("div");
  topEach.className = "w-[15%] h-full ";

  let topEachText = document.createElement("p");
  topEachText.className = "xl:text-lg text-sm mt-[10%]";
  topEachText.innerText = "Each";

  let topEachPrice = document.createElement("p");
  topEachPrice.className = "xl:text-lg text-sm";
  let _eachPrice = parseFloat(price).toFixed(2);
  topEachPrice.innerText = "$" + _eachPrice;

  let topEachWeight = document.createElement("p");
  topEachWeight.className = "xl:text-lg text-sm";
  topEachWeight.innerText = parseFloat(weight).toFixed(2) + "lbs";

  topEach.appendChild(topEachText);
  topEach.appendChild(topEachPrice);
  topEach.appendChild(topEachWeight);

  // Quantity in cart
  let topQuantity = document.createElement("div");
  topQuantity.className = "w-[10%] h-full xl:text-lg text-sm mt-[1.5%]";

  let topQuantityText = document.createElement("p");
  topQuantityText.className = "xl:text-lg text-sm mt-[10%]";
  topQuantity.innerText = "Quantity";

  var topQuantitySelect = document.createElement("select");
  topQuantitySelect.className = "border-2 px-4 border-opacity-50";
  for (let i = 1; i <= max_qty; ++i) {
    var selectOpt = document.createElement("option");
    selectOpt.innerText = i;
    if (i == quantity) {
      selectOpt.selected = true;
    }
    topQuantitySelect.appendChild(selectOpt);
  }
  topQuantitySelect.addEventListener("change",()=>{
    weightTotal-=(weight*quantity);
    let newQuantity = topQuantitySelect.value;
    let newWeight = newQuantity * weight;
    weightTotal+=newWeight;
      console.log(weightTotal);
    quantity=newQuantity;

    //price = topTotalPrice.innerText;
    topTotalPrice.innerText = "$" +  (_eachPrice * parseInt(quantity)).toFixed(2);
    topTotalWeight.innerText = parseFloat(quantity * weight).toFixed(2) + " lbs";
      shippingCostPrice.innerText = '$' + calculateShipping(weightTotal).toFixed(2);
      taxPrice.innerText = '$' + (0.05 * (parseFloat(price)* parseInt(quantity))).toFixed(2);
  });

  topQuantity.appendChild(topQuantityText);
  topQuantity.appendChild(topQuantitySelect);

  // Total price
  let topTotal = document.createElement("div");
  topTotal.className = "w-[15%] h-full flex flex-col items-end wrap";

  let topTotalText = document.createElement("p");
  topTotalText.innerText = "Total";
  topTotalText.className = "mr-[5%] mt-[10%] xl:text-lg text-sm";

  let topTotalPrice = document.createElement("p");
  topTotalPrice.innerText = "$" + (price * quantity).toFixed(2);
  topTotalPrice.className = "mr-[5%]";

  let topTotalWeight = document.createElement("p");
  topTotalWeight.className = "xl:text-lg text-sm";
  topTotalWeight.innerText = parseFloat(weight * quantity).toFixed(2) + "lbs";

  topTotal.appendChild(topTotalText);
  topTotal.appendChild(topTotalPrice);
  topTotal.appendChild(topTotalWeight);

  // Add to tree
  topBox.appendChild(topImage);
  topBox.appendChild(topDesc);
  topBox.appendChild(topEach);
  topBox.appendChild(topQuantity);
  topBox.appendChild(topTotal);

  // Bottom padding
  let bottomPad = document.createElement("div");
  bottomPad.className = "w-[30%] h-full ";

  // rest of bottom
  let bottomRest = document.createElement("div");
  bottomRest.className = "w-[70%] h-full ";

  let bottomText = document.createElement("a");
  bottomText.className =
    "underline cursor-pointer hover:text-red-500 transition-colors px-2";
  bottomText.href = "";
  bottomText.innerText = "Remove";

  bottomText.addEventListener("click", () => {
    let current = bottomText;
    while (current && !current.className.includes("all")) {
      current = current.parentNode;
    }
    let id = current.id;
    current.remove();
    sessionStorage.removeItem(id);
  });

  bottomRest.appendChild(bottomText);

  // Add to tree
  bottomAll.appendChild(bottomPad);
  bottomAll.appendChild(bottomRest);
}

let checkoutBox = document.createElement('div');
checkoutBox.className = 'w-1/2 h-[50%] bg-pink-300 mx-auto ';
document.getElementById('checkout-container').appendChild(checkoutBox);

let checkoutBoxPad = document.createElement("div");
checkoutBoxPad.className = 'w-full h-[30%]';

let shippingCostBox = document.createElement("div");
shippingCostBox.className = 'w-full h-[10%] bg-purple-400 flex';

let shippingCostText = document.createElement("div");
shippingCostText.className = 'w-[90%] h-full bg-green-200';
shippingCostText.innerText = 'Shipping Cost';

let shippingCostPrice = document.createElement("div");
shippingCostPrice.className = 'w-[10%] h-full bg-blue-400'
shippingCostPrice.innerText = "$" + calculateShipping(weightTotal).toFixed(2);

shippingCostBox.appendChild(shippingCostText);
shippingCostBox.appendChild(shippingCostPrice);

let discountBox = document.createElement("div");
discountBox.className = 'w-full h-[10%] bg-red-300 flex';

let discountText = document.createElement("div");
discountText.className = 'w-[90%] h-full bg-yellow-200';
discountText.innerText = 'Discount';

let discountPrice = document.createElement("div");
discountPrice.className = 'w-[10%] h-full bg-orange-400'
discountPrice.innerText = '$0.00';

discountBox.appendChild(discountText);
discountBox.appendChild(discountPrice);

let taxBox = document.createElement("div");
taxBox.className = 'w-full h-[10%] bg-red-200 flex';

let taxText = document.createElement("div");
taxText.className = 'w-[90%] h-full bg-red-300';
taxText.innerText = 'Tax';

let taxPrice = document.createElement("div");
taxPrice.className = 'w-[10%] h-full bg-yellow-200';
taxPrice.innerText = '$' + (0.05 * (parseFloat(price)* parseInt(quantity))).toFixed(2);

taxBox.appendChild(taxText);
taxBox.appendChild(taxPrice);

let estimatedTotalBox = document.createElement("div");
estimatedTotalBox.className = 'w-full h-[10%] bg-green-200 flex';

let estimatedTotalText = document.createElement("div");
estimatedTotalText.className = 'w-[90%] h-full bg-blue-300';
estimatedTotalText.innerText = 'Estimated Total Price';

let _estimatedTotalPrice = document.createElement("div");
_estimatedTotalPrice.id = 'estimated';
_estimatedTotalPrice.className = 'w-[10%] h-full bg-red-400';
_estimatedTotalPrice.innerText = (parseFloat(topTotalPrice.innerText) + parseFloat(shippingCostPrice.innerText) + parseFloat(taxPrice.innerText) - parseFloat(discount.innerText)).toFixed(2);

estimatedTotalBox.appendChild(estimatedTotalText);
estimatedTotalBox.appendChild(_estimatedTotalPrice);

let checkoutButtonBox = document.createElement("div");

let checkoutButton = document.createElement("button");
checkoutButton.className = "bg-[linear-gradient(135deg,_#FFE93A,_#F1F78A)] h-12 xl:w-1/4 w-1/3 shadow-md text-black font-bold text-lg mb-4 self-end mx-auto cursor-pointer transition-all duration-300 ease-in-out hover:brightness-110 hover:shadow-lg hover:scale-105"; 
checkoutButton.innerText = "Checkout";
checkoutButtonBox.appendChild(checkoutButton);

checkoutButtonBox.className = 'w-full h-[30%] bg-blue-200 flex';

checkoutBox.appendChild(checkoutBoxPad);
checkoutBox.appendChild(shippingCostBox);
checkoutBox.appendChild(discountBox);
checkoutBox.appendChild(taxBox);
checkoutBox.appendChild(estimatedTotalBox);
checkoutBox.appendChild(checkoutButtonBox);



