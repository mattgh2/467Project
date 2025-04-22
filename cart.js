cart.addEventListener("click", () => {
  showCart();
});

export function removeCart(cartPopUp) {
    if (cartPopUp) {
      cartPopUp.classList.replace("translate-x-0", "translate-x-full");
      setTimeout(() => {
        cartPopUp.remove();
      }, 300);
    }
}
function emptyBagMsg () {
  let emptyBag = document.createElement("h1");
  emptyBag.innerHTML = "Your Shopping Cart is empty.";
  emptyBag.id = "empty-bag";
  emptyBag.className = "text-center text-gray-500 font-semibold tracking-wide uppercase p-6";
  return emptyBag;
}
export function createSingleItem(id,part) {
        let bagItemContainer = document.createElement("div");
        let bagItemImage = document.createElement("div");
        let bagItemInfo = document.createElement("div");

        let removeButton = document.createElement("button");
        removeButton.className = "bg-red-600 hover:bg-red-800 w-8 h-8 absolute top-2 right-2 text-lg rounded-lg shadow-md text-white cursor-pointer";
        removeButton.innerHTML = "<i class='fa fa-trash'aria-hidden='true'></i>";

        removeButton.onclick = () => {
            let remove = removeButton;
            
            while (remove && !remove.className.includes("bagItemContainer")) {
                remove = remove.parentNode;
            }

            let currentCart = JSON.parse(sessionStorage.getItem('usersCart'));
            currentCart = currentCart.filter(item => item.id !== remove.id);
            sessionStorage.setItem('usersCart', JSON.stringify(currentCart));

            remove.remove();
            let itemInCheckout = document.querySelectorAll(".all");

            for (let i = 0; i < itemInCheckout.length; ++i) {
                if (itemInCheckout[i].id == remove.id) {
                    itemInCheckout[i].remove();
                    break;
                }
            }

            let cartCounter = document.getElementById("cart-counter");
            let currentCount = cartCounter.innerHTML;
            cartCounter.innerHTML = parseInt(currentCount) - 1;

            if (parseInt(cartCounter.innerHTML) == 0) {
              let cartPopUp = document.getElementById('cart-pop-up');
              for (let childElement = cartPopUp.firstChild; cartPopUp.firstChild; childElement = cartPopUp.firstChild) {
                childElement.remove();
              }
                document.getElementById('cart-pop-up').appendChild(emptyBagMsg());
                document.getElementById("empty-bag").classList.replace("text-center","mx-auto");
            }
        };

        bagItemInfo.appendChild(removeButton);

        bagItemContainer.className = "bagItemContainer shadow-md  h-32 w-full mb-3 flex gap-1 rounded-lg border-b-1 border-t-1 border-gray-300";
        bagItemContainer.id = id;
        bagItemImage.className = "w-1/3 h-full bg-center bg-contain bg-no-repeat";

        let bagItemImageVertBar = document.createElement("div");
        bagItemImageVertBar.className = "w-[1px] h-4/5 bg-gray-300 self-center mx-2";

        bagItemInfo.className = "w-full h-full relative";

        let itemName = document.createElement("p");
        itemName.innerHTML = part[1];
        itemName.className = "text-sm mt-3 ml-2 capitalize  text-gray-800 font-semibold";

        let itemQty = document.createElement("p");
        let span = document.createElement("span");
        span.className = "item-qty";
        itemQty.appendChild(span);
        itemQty.className = "text-sm mt-1 ml-2";
        span.innerText = "Quantity: " + part[5];

        let itemWeight = document.createElement("p");
        itemWeight.className = "text-sm mt-1 ml-2";
        let weight = (parseFloat(part[3]) * parseInt(part[5])).toFixed(2);
        itemWeight.innerHTML = "Weight: " + weight + " lbs";

        let itemTotal = document.createElement("p");
        itemTotal.className = "text-sm mt-1 ml-2";
        let total = (parseFloat(part[2]) * parseInt(part[5])).toFixed(2);
        itemTotal.innerHTML = "Total: " + "$" + total;

        bagItemInfo.appendChild(itemName);
        bagItemInfo.appendChild(itemQty);
        bagItemInfo.appendChild(itemWeight);
        bagItemInfo.appendChild(itemTotal);

        bagItemImage.style.backgroundImage = `url(${part[4]})`;

        bagItemContainer.appendChild(bagItemImage);
        bagItemContainer.appendChild(bagItemImageVertBar);
        bagItemContainer.appendChild(bagItemInfo);

        return bagItemContainer;

}
export function initializeCart(cartPopUp) {
      let itemContainer = document.createElement("div");
      itemContainer.className = "xl:w-[500px] w-[400px] max-h-[400px] overflow-auto";

      let checkoutContainer = document.createElement("div");
      let checkoutButtonPopUp = document.createElement("button");

      checkoutButtonPopUp.className = "bg-black w-3/4 py-3 shadow-lg text-white mx-auto self-end mb-3  tracking-wide drop-shadow-lg hover:bg-gray-800 cursor-pointer active:scale-95";
      checkoutButtonPopUp.innerHTML = "Checkout";
      checkoutButtonPopUp.id = "checkout-button";
      checkoutButtonPopUp.onclick = () => {
        window.location.href = "./checkout.php";
      };

      checkoutContainer.className = "w-full h-[150px] flex";
      checkoutContainer.appendChild(checkoutButtonPopUp);

      cartPopUp.appendChild(itemContainer);
      cartPopUp.appendChild(checkoutContainer);

      return itemContainer;
}

export function showCart() {
  let navBar = document.getElementById("nav-bar");
  let cart = document.getElementById("cart");

  let usersCart = (sessionStorage.getItem('usersCart')) ? JSON.parse(sessionStorage.getItem('usersCart')) : [] ;
  let cartPopUp = document.getElementById("cart-pop-up");

  if (cartPopUp) removeCart(cartPopUp);
  else {
    cartPopUp = document.createElement("div");
    cartPopUp.id = "cart-pop-up";
    cartPopUp.className = "bg-white  absolute right-0 shadow-xl rounded-md transition-transform ease-in-out duration-300 translate-x-full  mt-1 mr-1";
    navBar.appendChild(cartPopUp);
    setTimeout(() => {
      cartPopUp.classList.replace("translate-x-full", "translate-x-0");
    }, 100);

    if (usersCart.length == 0) {
      cartPopUp.appendChild(emptyBagMsg());
    } else {
      let itemContainer = initializeCart(cartPopUp);

      for (let i = 0; i < usersCart.length; ++i) {
        console.log(usersCart[i].id);
      }
      for (let i = usersCart.length - 1 ; i >= 0; --i) {
        let id = usersCart[i].id; let part = usersCart[i].item;
        let bagItemContainer = createSingleItem(id,part);
        itemContainer.appendChild(bagItemContainer);
      }
    }
  }
  return cartPopUp;
}
