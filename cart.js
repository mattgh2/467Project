let navBar = document.getElementById('nav-bar');
let cart = document.getElementById('cart');

function emptyBagMsg() {
    let emptyBag = document.createElement('h1');
    emptyBag.innerHTML = "Your Shopping Cart is empty.";
    emptyBag.className = "tracking-wide  text-lg uppercase px-5 mt-3";
    return emptyBag;
}
cart.addEventListener("click", () => {
    let cartPopUp = document.getElementById("cart-pop-up");
    if (cartPopUp) {
        cartPopUp.classList.replace("translate-x-0", "translate-x-full");
        setTimeout(() => {
            cartPopUp.remove();
        }, 300);
    }
    else {
        cartPopUp = document.createElement("div");
        cartPopUp.id = "cart-pop-up";
        cartPopUp.className = "bg-white max-h-[400px] h-[150px] absolute right-0 shadow-xl rounded-md transition-transform ease-out duration-300 translate-x-full  mt-1 mr-1";
        navBar.appendChild(cartPopUp);
        setTimeout(() => {
        cartPopUp.classList.replace("translate-x-full", "translate-x-0");
        }, 100);

        if (sessionStorage.length == 0) {
            cartPopUp.appendChild(emptyBagMsg());
        }
        else {

            let itemContainer = document.createElement('div'); 
            itemContainer.className = "bg-white xl:w-[500px] w-[400px] max-h-[400px] overflow-auto";
            cartPopUp.appendChild(itemContainer);

            let checkoutContainer = document.createElement("div");
            let checkoutButtonPopUp = document.createElement('button');

            checkoutButtonPopUp.className = "bg-black w-3/4 py-3 shadow-lg text-white mx-auto self-end mb-3  tracking-wide drop-shadow-lg hover:bg-gray-800 cursor-pointer active:scale-95";
            checkoutButtonPopUp.innerHTML = "Checkout";
            checkoutButtonPopUp.id = 'checkout-button';
            checkoutButtonPopUp.onclick = ()=> {
                window.location.href = "./checkout.php";
            };

            checkoutContainer.className = "w-full h-[150px] bg-white flex";
            checkoutContainer.appendChild(checkoutButtonPopUp);
            cartPopUp.appendChild(checkoutContainer);

            for (let i = 0; i < sessionStorage.length; ++i) { 
                let id = sessionStorage.key(i);
                let part = sessionStorage[id].split(',');

                let bagItemContainer = document.createElement('div');
                let bagItemImage = document.createElement('div');
                let bagItemInfo = document.createElement('div');

                let removeButton = document.createElement('button');
                removeButton.className = "bg-red-600 w-8 h-8 absolute top-2 right-2 text-lg rounded-lg shadow-md text-white cursor-pointer";
                removeButton.innerHTML = "<i class='fa fa-trash'aria-hidden='true'></i>";

                removeButton.onclick = ()=>{
                    let remove = removeButton.parentElement.parentElement;
                    remove.remove();
                    sessionStorage.removeItem(remove.id);
                    let cartCounter = document.getElementById("cart-counter");
                    let currentCount = cartCounter.innerHTML;
                    cartCounter.innerHTML = parseInt(currentCount) - 1;
                    if (parseInt(cartCounter.innerHTML) == 0) {
                        document.getElementById('checkout-button').remove();
                        checkoutContainer.appendChild(emptyBagMsg());
                    }
                };

                bagItemInfo.appendChild(removeButton);

                bagItemContainer.className = "shadow-md  h-32 w-full mb-6 flex gap-1";
                bagItemContainer.id = id;
                bagItemImage.className = "w-1/3 bg-white h-full bg-center bg-contain bg-no-repeat";

                let bagItemImageVertBar = document.createElement('div');
                bagItemImageVertBar.className = "w-[2px] h-4/5 ml-[5px] bg-black self-center opacity-30";

                bagItemInfo.className = "w-full bg-white h-full relative";

                let itemName = document.createElement('p');
                itemName.innerHTML = part[1];
                itemName.className = "text-sm mt-3 ml-2 capitalize";

                let itemQty = document.createElement('p');
                itemQty.className = "text-sm mt-1 ml-2";
                itemQty.innerHTML =  "Quantity: " + part[5];

                let itemWeight = document.createElement('p');
                itemWeight.className = "text-sm mt-1 ml-2";
                let weight = (parseFloat(part[3]) * parseInt(part[5])).toFixed(2);
                itemWeight.innerHTML =  "Weight: " + weight + " lbs";


                let itemTotal = document.createElement('p');
                itemTotal.className = "text-sm mt-1 ml-2";
                let total = (parseFloat(part[2]) * parseInt(part[5])).toFixed(2);
                itemTotal.innerHTML =  "Total: " + "$" + total;

                bagItemInfo.appendChild(itemName);
                bagItemInfo.appendChild(itemQty); 
                bagItemInfo.appendChild(itemWeight); 
                bagItemInfo.appendChild(itemTotal); 

                bagItemImage.style.backgroundImage = `url(${part[4]})`;

                bagItemContainer.appendChild(bagItemImage);
                bagItemContainer.appendChild(bagItemImageVertBar);
                bagItemContainer.appendChild(bagItemInfo);
 
                itemContainer.appendChild(bagItemContainer);


                console.log(part);
            }
        }

    }
});
