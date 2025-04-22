import {createSingleItem, initializeCart, removeCart, showCart} from "./cart.js";
export var brackets = [
    [ [0,5], 5],
    [ [5, Infinity], 10 ]
];

export function updateBrackets(lb,price) {
    let idx = 0;
    let max = brackets[0][0][0];
    let found = false;
    for (let i=0; i<brackets.length && !found; ++i) {
        let interval = brackets[i][0];
        if (interval[0] == lb) {
            found = true;
        }
        if (interval[0] < lb) {
            idx = i;
            max = interval[0];
        }
    }
    if (found) {
        console.log("already exists");
        return;
    }
    let tmp = brackets[idx][0][1]
    brackets[idx][0][1] = lb;
    brackets.splice(idx, 0, [[lb, tmp],price]);
}

// Base handling fee
export var c0 = 5;
// Weight threshold between light and heavy
export var wt = 2;
// Per‑kg rate for “light” packages
export var r1 = 3;
// Per-kg rate for "heavy" packages
export var r2 = 2;

export function calculateShipping(weight, base=c0, threshold=wt, light=r1, heavy=r2) {
    for (let i=0; i<brackets.length; ++i) {
        if (weight >= brackets[i][0][0] && weight <= brackets[i][0][1]) {
            return brackets[i][1];
        }
    }
}

export function setCartCounter() {
    let cartCounter = document.getElementById('cart-counter');
    let usersCart = JSON.parse(sessionStorage.getItem('usersCart') || '[]');
    cartCounter.innerHTML = usersCart.length;
}

export function incrementCartCounter() {
    let cartCounter = document.getElementById('cart-counter');
    let count = parseInt(cartCounter.innerText);
    cartCounter.innerText = count + 1;
}

export function addNewItemEffectToElement(el) {
        el.classList.add('new-item-effect');
        setTimeout(() => el.classList.remove('new-item-effect'), 1000); 
}
export function addQuantityUpdatedEffect(el) {
        el.classList.add('bg-lime-500');
        setTimeout(() => el.classList.remove('bg-lime-500'), 1000); 
}

export function showUsersCartPopUp(time = 1500, itemToAnimate = null, id = null) {
        let popUp = showCart();
        if (id) {
            var item = popUp.querySelector(`[id="${id}"]`);
            item = item.querySelector('.item-qty');
        } else {
            var item =  popUp.querySelectorAll('.bagItemContainer')[0];
        }
        (id) ? addQuantityUpdatedEffect(item) : addNewItemEffectToElement(itemToAnimate ? itemToAnimate : item);
        setTimeout(() => { removeCart(popUp); }, time);
}

export function addToOpenCartPopUp(id,item) {
    let cartPopUpItemContainer = document.getElementById('cart-pop-up');
    let children = cartPopUpItemContainer.childNodes;
    if (children.length == 1) {
        initializeCart(cartPopUpItemContainer);
        cartPopUpItemContainer.querySelector('#empty-bag').remove();
    }
    var first = cartPopUpItemContainer.firstChild;
    let newItem = createSingleItem(id,item);
    first.prepend(newItem);
    addNewItemEffectToElement(newItem);
}

export function addQuantityListeners() {
    const quantityDiv = document.querySelectorAll('.qty-box');

    quantityDiv.forEach(el => {
        const quantityInput = el.querySelector(".qty-input");
        const incrementElement = el.querySelector(".plus-qty");
        const decrementElement = el.querySelector(".minus-qty");

        incrementElement.addEventListener('click', () => {
            quantityInput.value = parseInt(quantityInput.value) + 1;
        });
        decrementElement.addEventListener('click', () => {
            quantityInput.value = Math.max(parseInt(quantityInput.value)-1, 0);
        });
    });
}

export function addBounceAnimationToElement(el) {
    el.classList.add("animate-bounce-once");
    setTimeout(() => {
        el.classList.remove("animate-bounce-once");
    }, 1300);

}

export function findCartItem(usersCart, id) {
    for (let i = 0; i < usersCart.length; ++i) {
        if (usersCart[i].id === id) {
            return i;
        }
    }
    return -1;
}

export function IsAlreadyInCart(usersCart, id) {
    var index = findCartItem(usersCart, id);
    return index >= 0 ? true : false;
}

export function UpdateQuantity(usersCart, id, newQty) {
    var index = findCartItem(usersCart, id);

    if (index == -1) return;
    if (usersCart[index].item[5] == newQty) return;

    usersCart[index].item[5] = newQty;
    sessionStorage.setItem('usersCart', JSON.stringify(usersCart));

    let cartPopUp = document.getElementById('cart-pop-up')  
    if (!cartPopUp) {
        showUsersCartPopUp(1500,null,id); 
    }
    else {
        let item = cartPopUp.querySelector(`[id="${id}"]`).querySelector('.item-qty');
        item.innerText = `Quantity: ${newQty}`;
        addQuantityUpdatedEffect(item);
    }
}

export function isValidAmount(amount) {
    return (amount > 0);
}


export function pushToSessionStorage(id, item) {
    // item object
    let currentItem = {
        id: id,
        item: item
    };

    // array of item objects
    var usersCart = [];

    // Retrieve the users cart from sessionStorage if it exists.
    // JSON.parse will convert the string at sessionStorage['usersCart'] to the original type before being converted to a string with JSON.stringify. (Since sessionStorage can only store strings).
    // So JSON.parse is converting the string back to an array of objects.
    if (sessionStorage.getItem('usersCart')) {
        usersCart = JSON.parse(sessionStorage.getItem('usersCart'));
    }

    if (IsAlreadyInCart(usersCart, id)) {
        UpdateQuantity(usersCart, id, item[5]);
        return;
    }

    usersCart.push(currentItem);

    // Replaces the old stringifed array with the new one.
    sessionStorage.setItem('usersCart', JSON.stringify(usersCart));

    return true;

}

export function addToCart(el) {
    const id = el.id;

    let addToCartContainer = el;
    while (addToCartContainer && !addToCartContainer.className.includes('add-to-cart')) {
        addToCartContainer = addToCartContainer.parentNode;
    }
    let inputElement = addToCartContainer.querySelector(".qty-input");

    let amount = parseInt(inputElement.value);

    if (!isValidAmount(amount)) {
        let AmountBox = addToCartContainer.querySelector('.qty-box');
        addBounceAnimationToElement(AmountBox);
        return;
    }
    let _max = el.dataset.max;
    let values = [
        el.dataset.id, 
        el.dataset.desc,
        el.dataset.price,
        el.dataset.weight,
        el.dataset.img,
        amount,
        _max
    ];

    let addedItem = pushToSessionStorage(id, values);
    if (addedItem) {
        incrementCartCounter();
        document.getElementById('cart-pop-up') ? addToOpenCartPopUp(id,values) :  showUsersCartPopUp(); 
    }

}

// Module scopes the addToCart function to this file . 
// This makes it global scope. (for onclick in the html).
window.addToCart = addToCart;