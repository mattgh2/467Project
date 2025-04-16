let navBar = document.getElementById('nav-bar');
let cart = document.getElementById('cart');
let cartPopUp = document.createElement('div');

let hoveringCart = false, hoveringPopUp = false;
cart.addEventListener("mouseover", () => {
    cartPopUp.className = "bg-white w-1/6 h-1/5 absolute right-0 shadow-md rounded-md transition-transform ease-out duration-300 translate-x-full  mt-1 mr-1";
    navBar.appendChild(cartPopUp);
    setTimeout(() => {
        cartPopUp.classList.replace("translate-x-full", "translate-x-0")
    }, 100);

    hoveringCart = true;
});
cart.addEventListener("mouseout", () => {
    hoveringCart = false;
    setTimeout(() => {
        if (!hoveringCart && !hoveringPopUp) {
            cartPopUp.classList.replace("translate-x-0", "translate-x-full");
            setTimeout(() => { cartPopUp.remove() }, 300);
        }
    }, 300); 
});

cartPopUp.addEventListener("mouseover", () => {
    hoveringPopUp = true;
});

cartPopUp.addEventListener("mouseout", () => {
    cartPopUp.classList.replace("translate-x-0", "translate-x-full");
    setTimeout(() => { cartPopUp.remove()}, 310);
    hoveringPopUp = false;
});