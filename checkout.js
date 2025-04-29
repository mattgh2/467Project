import {calculateShipping, setCartCounter} from "./utils.js";

setCartCounter();
function EmptyCartDisplay() {

    let checkoutContainer = document.getElementById('checkout-container');

    let container = document.createElement('div');
    container.className = "flex w-full flex-col gap-12";
    checkoutContainer.appendChild(container);

    let cartSVG = document.createElement('img');
    cartSVG.src = "./assets/cart.svg";
    cartSVG.className = "w-1/4 h-1/4 mt-10 self-center";
    container.appendChild(cartSVG);

    let emptyCartMessage = document.createElement('p');
    emptyCartMessage.innerText = "Your Cart is Currently Empty!";
    emptyCartMessage.className = "text-4xl md:text-5xl font-semibold text-gray-700 tracking-wide text-center leading-snug ml-10";
    container.appendChild(emptyCartMessage); 
    let returnToCatalogButton = document.createElement('button');

    returnToCatalogButton.className = "px-8 h-20 bg-blue-500 text-white font-bold text-lg tracking-tight shadow-md rounded-2xl self-center cursor-pointer ml-14 mt-5 transition-colors transform ease-in-out duration-300 hover:bg-blue-700";
    returnToCatalogButton.innerText = "Return To Catalog";
    returnToCatalogButton.addEventListener('click', ()=>{ window.location.href = "./catalog.php"; });
    container.appendChild(returnToCatalogButton);

}

// Div for all cart items
let cartItems = document.getElementById("cart-items");
let _brackets = JSON.parse(sessionStorage.getItem("brackets"));

var weightTotal = 0;
var priceTotal = 0;

// Changed how we are storing the users cart in sessionStorage.
// its  now a stringified array of objects with id property and item property (item is the array of stuff).
// its key in sessionStorage is "usersCart".

let usersCart = JSON.parse(sessionStorage.getItem("usersCart"));
if (usersCart == null) usersCart = [];

let itemMap = {};

// For each part in cart 
for (let i = 0; i < usersCart.length; ++i) {
  let key = usersCart[i].id;
  let v = usersCart[i].item;
  itemMap[key] = v; 

  // Get information about part
  let id = v[0];
  let desc = v[1];
  var price = v[2];
  let weight = v[3];
  let _url = v[4];
  var quantity = v[5];
  let max_qty = v[6];

  priceTotal+=price*quantity;
  weightTotal+=weight*quantity;
  // console.log(weightTotal);
  var shippingCost = calculateShipping(_brackets, weightTotal);

  // Div for all information
  let all = document.createElement("div");
  all.id = key;
  all.className = "all w-full h-[30%] border-l-0 border-r-0 border-t-2 border-b-2  bg-white shadow-lg border-gray-200 flex flex-col wrap bg-white/80";
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
  topDesc.className = "w-[30%] h-full";
  let topDescP = document.createElement("p");
  topDescP.innerText = desc;
  topDescP.className = "ml-2 mt-2 p-2 font-semibold text-gray-800 text-xs lg:text-md xl:text-lg capitalize tracking-wide";
  topDesc.appendChild(topDescP);

  // Price for one part
  let topEach = document.createElement("div");
  topEach.className = "w-[15%] h-full ";

  let topEachText = document.createElement("p");
  topEachText.className = "text-xs lg:text-md xl:text-lg font-medium  mt-2 pt-2";
  topEachText.innerText = "Each";

  let topEachPrice = document.createElement("p");
  topEachPrice.className = "text-base lg:text-md xl:text-lg  text-sm font-bold text-green-600";
  let _eachPrice = parseFloat(price).toFixed(2);
  topEachPrice.innerText = "$" + _eachPrice;

  let topEachWeight = document.createElement("p");
  topEachWeight.className = "text-xs lg:text-sm text-gray-500";
  topEachWeight.innerText = parseFloat(weight).toFixed(2) + " lbs";

  topEach.appendChild(topEachText);
  topEach.appendChild(topEachPrice);
  topEach.appendChild(topEachWeight);

  // Quantity in cart
  let topQuantity = document.createElement("div");
  topQuantity.className = "w-[10%] h-full xl:text-lg text-xs ml-3 mt-2 pt-2";

  let topQuantityText = document.createElement("p");
  topQuantityText.className = "xl:text-lg lg:text-md text-xs mt-[10%]";
  topQuantity.innerText = "Quantity";

  var topQuantitySelect = document.createElement("select");
  topQuantitySelect.className = "border border-gray-300 rounded-md text-sm lg:px-3 px-1 py-1 hover:border-black focus:outline-none";
  for (let i = 1; i <= max_qty; ++i) {
    var selectOpt = document.createElement("option");
    selectOpt.innerText = i;
    if (i == quantity) {
      selectOpt.selected = true;
    }
    topQuantitySelect.appendChild(selectOpt);
  }

  topQuantitySelect.addEventListener("change", function() {
    let current = this;

    while (current && !current.className.includes("all"))  {
      current = current.parentNode;
    }
    let currentItem = itemMap[current.id];
    weightTotal -= (currentItem[3] * currentItem[5]);
    priceTotal -= (currentItem[2] * currentItem[5]);

    let newQuantity = this.value;
    let newWeight = newQuantity * currentItem[3];
    let newPrice = currentItem[2] * newQuantity;

    weightTotal+=newWeight;
    currentItem[5] = newQuantity;
    priceTotal+=newPrice;

    for (let i = 0; i < usersCart.length; ++i) { 
      if (usersCart[i].id == current.id) {
        usersCart[i].item = currentItem;
      }
    }

    let _topTotal  = current.querySelector('.top-total');
    let _topTotalPrice = _topTotal.querySelector('.top-total-price');
    let _topTotalWeight = _topTotal.querySelector('.top-total-weight');

    sessionStorage.setItem("usersCart",JSON.stringify(usersCart));

    _topTotalPrice.innerText = "$" +  (currentItem[2] * parseInt(currentItem[5])).toFixed(2);
    _topTotalWeight.innerText = parseFloat(currentItem[5] * currentItem[3]).toFixed(2) + " lbs";
    shippingCostPrice.innerText = '$' + calculateShipping(_brackets, weightTotal).toFixed(2);
    let _estimatedTotalPriceNOTAX = (parseFloat(priceTotal) + parseFloat(shippingCostPrice.innerText.substring(1)) - parseFloat(discountPrice.innerText.substring(1))).toFixed(2);
    taxPrice.innerText =  '$' + (0.05 * _estimatedTotalPriceNOTAX).toFixed(2);
    _estimatedTotalPrice.innerText = '$' + (parseFloat(priceTotal) + parseFloat(shippingCostPrice.innerText.substring(1)) + parseFloat(taxPrice.innerText.substring(1)) - parseFloat(discountPrice.innerText.substring(1))).toFixed(2);
  });

  topQuantity.appendChild(topQuantityText);
  topQuantity.appendChild(topQuantitySelect);

  // Total price
  let topTotal = document.createElement("div");
  topTotal.className = "top-total w-[15%] h-full flex flex-col wrap ml-[10%]";

  let topTotalText = document.createElement("p");
  topTotalText.innerText = "Total";
  topTotalText.className = "mr-5 mt-2 pt-2 xl:text-lg text-xs lg:text-md";

  var topTotalPrice = document.createElement("p");
  topTotalPrice.innerText = "$" + (price * quantity).toFixed(2);
    topTotalPrice.className = "top-total-price mr-[5%] xl:text-lg text-xs";

  let topTotalWeight = document.createElement("p");
  topTotalWeight.className = "top-total-weight xl:text-lg text-xs mr-2";
  topTotalWeight.innerText = parseFloat(weight * quantity).toFixed(2) + " lbs";

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
  bottomText.className =  "text-red-500 hover:text-red-700 font-medium text-sm underline  ml-2 cursor-pointer" ;
  bottomText.innerText = "Remove";

  bottomText.addEventListener("click", () => {
    var current = bottomText;
    while (current && !current.className.includes("all")) {
      current = current.parentNode;
    }
    let id = current.id;
    current.remove();

    usersCart = JSON.parse(sessionStorage.getItem("usersCart")).filter(obj => obj.id !== id);
    sessionStorage.setItem("usersCart", JSON.stringify(usersCart));

    let cartCounter = document.getElementById("cart-counter");
    let currentCount = cartCounter.innerHTML;
    cartCounter.innerHTML = parseInt(currentCount) - 1;

    if (JSON.parse(sessionStorage.getItem('usersCart')).length == 0) {
    document.getElementById('cart-items').remove();
    document.getElementById('checkout-box').remove();
    EmptyCartDisplay();
    }
  });

  bottomRest.appendChild(bottomText);

  // Add to tree
  bottomAll.appendChild(bottomPad);
  bottomAll.appendChild(bottomRest);
}
 
if (document.getElementById('cart-items').childNodes.length == 1) {
    document.getElementById('cart-items').remove();
    EmptyCartDisplay();
}

else {
var checkoutBox = document.createElement('div');
checkoutBox.className = 'w-1/2 h-[50%] mx-auto';
checkoutBox.id = "checkout-box";
document.getElementById('checkout-container').appendChild(checkoutBox);

var checkoutBoxPad = document.createElement("div");
checkoutBoxPad.className = 'w-full h-[30%]';

var shippingCostBox = document.createElement("div");
shippingCostBox.className = 'w-full h-[10%] flex';

var shippingCostText = document.createElement("div");
shippingCostText.className = 'w-[90%] h-full';
shippingCostText.innerText = 'Shipping Cost';

var shippingCostPrice = document.createElement("div");
shippingCostPrice.className = 'w-[10%] h-full'
shippingCostPrice.innerText = "$" + calculateShipping(_brackets,weightTotal).toFixed(2);

shippingCostBox.appendChild(shippingCostText);
shippingCostBox.appendChild(shippingCostPrice);

var discountBox = document.createElement("div");
discountBox.className = 'w-full h-[10%] flex';

var discountText = document.createElement("div");
discountText.className = 'w-[90%] h-full';
discountText.innerText = 'Discount';

var discountPrice = document.createElement("div");
discountPrice.className = 'w-[10%] h-full'
discountPrice.innerText = '$0.00';

discountBox.appendChild(discountText);
discountBox.appendChild(discountPrice);

var taxBox = document.createElement("div");
taxBox.className = 'w-full h-[10%] flex';

var taxText = document.createElement("div");
taxText.className = 'w-[90%] h-full';
taxText.innerText = 'Tax';

var taxPrice = document.createElement("div");
taxPrice.className = 'w-[10%] h-full';
taxPrice.innerText = '$' + (0.05 * (parseFloat(priceTotal))).toFixed(2);
 
taxBox.appendChild(taxText);
taxBox.appendChild(taxPrice);

var estimatedTotalBox = document.createElement("div");
estimatedTotalBox.className = 'w-full h-[10%] flex';

var estimatedTotalText = document.createElement("div");
estimatedTotalText.className = 'w-[90%] h-full';
estimatedTotalText.innerText = 'Estimated Total Price';

var _estimatedTotalPrice = document.createElement("div");
_estimatedTotalPrice.id = 'estimated';
_estimatedTotalPrice.className = 'w-[10%] h-full';
_estimatedTotalPrice.innerText = '$' + (parseFloat(priceTotal) + parseFloat(shippingCostPrice.innerText.substring(1)) + parseFloat(taxPrice.innerText.substr(1)) - parseFloat(discountPrice.innerText.substr(1))).toFixed(2);

estimatedTotalBox.appendChild(estimatedTotalText);
estimatedTotalBox.appendChild(_estimatedTotalPrice);

var checkoutButtonBox = document.createElement("div");

var checkoutButton = document.createElement("button");
checkoutButton.className = "bg-gradient-to-r from-yellow-300 to-yellow-200 hover:from-yellow-400 hover:to-yellow-300 h-12 xl:w-1/4 w-1/3 shadow-md text-black font-bold text-lg mb-4 self-end mx-auto cursor-pointer shadow hover:shadow-xl transition-transform transform hover:scale-105"; 

checkoutButton.innerText = "Checkout";

checkoutButton.addEventListener("click", () => {
    let cart = JSON.parse(sessionStorage.getItem('usersCart'));

    let str = "";
    for (let i = 0, count = 1; i < cart.length; ++i, ++count) {
        let amount = cart[i].item[5];
        let itemID = cart[i].id; 
        str += `&qty${count}=${amount}`;
        str += `&itemID${count}=${itemID}`;
        str += `&price${count}=${cart[i].item[2] * cart[i].item[5]}`;
    }
    window.location.href = `payment.php?amount=${_estimatedTotalPrice.innerText.substring(1)}${str}&shippingCost=${shippingCostPrice.innerText.substring(1)}`;
});
checkoutButtonBox.appendChild(checkoutButton);

checkoutButtonBox.className = 'w-full h-[30%] flex';

checkoutBox.appendChild(checkoutBoxPad);
checkoutBox.appendChild(shippingCostBox);
checkoutBox.appendChild(discountBox);
checkoutBox.appendChild(taxBox);
checkoutBox.appendChild(estimatedTotalBox);
checkoutBox.appendChild(checkoutButtonBox);

}