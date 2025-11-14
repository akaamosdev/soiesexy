import {reactive, ref} from 'vue';

const storedCart = JSON.parse(localStorage.getItem('cart') || '[]');
const addressLivraison = JSON.parse(localStorage.getItem('adresse_livraison') || '{}');
const carts = ref(Array.isArray(storedCart) ? storedCart : [storedCart]);

const state = reactive({
    visible: false,
    message: '',
    timeoutMs: 3000
});

let hideTimer = null;

export function showToast(message, durationMs = 3000) {
    state.message = message;
    state.timeoutMs = durationMs;
    state.visible = true;

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
   return Number(price).toLocaleString('fr-FR', { minimumFractionDigits: 0 })
}
export function getCart() {
    return carts;
}
export function getAddressLivraison() {
    return addressLivraison;
}
