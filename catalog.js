import * as util from "./utils.js";
util.setCartCounter();
util.addQuantityListeners();
window.addToCart = util.addToCart;

let lastSearch = "";
let hiddenElements = new Map();

document.getElementById('search-bar').addEventListener('input', function() {
    let products = document.body.querySelectorAll(".product-card");
    let match = this.value;

    if (match.length < lastSearch.length) {
        let unhide = hiddenElements.get(lastSearch);
        for (let i = 0; i < unhide.length; ++i) {
            unhide[i].classList.remove('hidden');
        }
    } else {
        products.forEach(el => {
            if (!el.querySelector('.desc').innerHTML.toLowerCase().includes(match.toLowerCase())) {
                if (!hiddenElements.has(match)) {
                    hiddenElements.set(match, []);
                }
                hiddenElements.get(match).push(el);
                el.classList.add('hidden');
            }
        });
    }
    lastSearch = match;
});