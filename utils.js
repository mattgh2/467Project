// Base handling fee
export var c0 = 5;
// Weight threshold between light and heavy
export var wt = 2;
// Per‑kg rate for “light” packages
export var r1 = 3;
// Per-kg rate for "heavy" packages
export var r2 = 2;

export function calculateShipping(weight, base=c0, threshold=wt, light=r1, heavy=r2) {
    if (weight > 0 && weight <= wt) {
        return r1 * weight;        
    } else {
        return r1 * weight + r2 * (weight - wt);
    }
}
export function setCartCounter() {
    let cartCounter = document.getElementById('cart-counter');
    let usersCart = JSON.parse(sessionStorage.getItem('usersCart') || '[]');
    cartCounter.innerHTML = usersCart.length;
}
export function updateCartCounter() {
    let cartCounter = document.getElementById('cart-counter');
    let count = parseInt(cartCounter.innerText);
    cartCounter.innerText = count + 1;
}