import {reactive, ref} from 'vue';

const storedCart = JSON.parse(localStorage.getItem('cart') || '[]');
const wishlist = JSON.parse(localStorage.getItem('wishlist') || '[]');
const addressLivraison = JSON.parse(localStorage.getItem('adresse_livraison') || '{}');
const carts = ref(Array.isArray(storedCart) ? storedCart : [storedCart]);

const state = reactive({
    visible: false,
    message: '',
    type:true,
    timeoutMs: 3000
});

let hideTimer = null;

export function showToast(message,type=true, durationMs = 3000) {
    state.message = message;
    state.timeoutMs = durationMs;
    state.visible = true;
    state.type = type;

    if (hideTimer) clearTimeout(hideTimer);
    hideTimer = setTimeout(() => {
        state.visible = false;
        hideTimer = null;
    }, durationMs);
}

export function hideToast() {
    state.visible = false;
    if (hideTimer) {
        clearTimeout(hideTimer);
        hideTimer = null;
    }
}
export function useToastStore() {
    return state;
}
export function formatPrice(price) {
   return Number(price).toLocaleString('fr-FR', { minimumFractionDigits: 0,maximumFractionDigits:0 })
}
export function getCart() {
    return carts;
}export function getWishlist() {
    return wishlist;
}
export function getAddressLivraison() {
    return addressLivraison;
}
export function addToCart(product,tailleId, colorId,quantity,carts) {
    let cart_c = {
        product_id: product.id,
        taille_id: tailleId,
        color_id: colorId,
        name: product.name,
        price: product.price,
        image: product.images.length > 0 ? product.images[0].image_path : null,
        quantity: quantity.value,
    };
    const existingItem = carts.value.find(item => item.product_id === cart_c.product_id);
    if (existingItem) {
        existingItem.quantity += quantity.value;
    } else {
        carts.value.push(cart_c);
    }
    localStorage.setItem('cart', JSON.stringify(carts.value));
    return true;
}
export function addToWishlist(product,wishlist) {
    let wiq={
        id:product.id,
        name:product.name,
        price:product.price,
        slug:product.slug,
        image: product.images.length > 0 ? product.images[0].image_path : null,
    }
    const existingWishlist = wishlist.find(item => item.id === wiq.id);
    if (existingWishlist) {
        wishlist.splice(wishlist.indexOf(existingWishlist), 1);
    }else{
        wishlist.push(wiq);
        localStorage.setItem('wishlist', JSON.stringify(wishlist));
    }

}
