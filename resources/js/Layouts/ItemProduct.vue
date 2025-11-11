<template>
  <div class="bg-white rounded-2xl text-center relative border border-slate-300">
    <div class="wishlist absolute right-0 px-2 py-1 bg-red-100 rounded-full cursor-pointer" @click="toggleWishlist(product)">
      <i class="fa-regular fa-heart text-red-500" :class="{'fa-solid': isInWishlist(product.id)}"></i>
    </div>
    <div class="img bg-white rounded-xl ">
      <Link :href="route('show', product.slug)" class="">
        <img v-if="product.images.length > 0" :src="`/storage/${product.images[0].image_path}`" :alt="product.images[0].alt_text" class="h-48 w-full object-cover rounded-xl">
        <img v-else src="/assets/img/no-image.jpg" :alt="product.name" class="h-48 w-full object-cover rounded-xl">
      </Link>
    </div>
    <h1 class="text-md font-semibold">{{ product.name }}</h1>
    <h1 class="text-md font-bold text-amber-800">{{ product.price }} FCFA</h1>
    <h4 class="">
                <span>
                <i class="fa-solid fa-star text-amber-400"></i>
                <i class="fa-solid fa-star text-amber-400"></i>
                <i class="fa-solid fa-star text-amber-400"></i>
                <i class="fa-regular fa-star text-amber-400"></i>
                <i class="fa-regular fa-star text-amber-400"></i>
            <span class="text-slate-500">(2 avis)</span>
            </span>
    </h4>
    <button @click="addToCart(product)" class="w-full">
      <div class="px-2 py-1 mt-2 bg-slate-950 text-white w-full rounded-se-2xl rounded-es-2xl">
        <i class="fa-solid fa-cart-plus"></i> Ajouter au panier
      </div>
    </button>
  </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import { ref, watch } from 'vue';

const props = defineProps({
    product: Object,
});

// --- Cart Logic (LocalStorage) ---
const cart = ref(JSON.parse(localStorage.getItem('cart')) || {});

const saveCart = () => {
    localStorage.setItem('cart', JSON.stringify(cart.value));
};

const addToCart = (product) => {
    // For simplicity, adding the first variant if available, or the product itself
    // In a real scenario, you'd select a variant from the product page
    const variantId = product.variants.length > 0 ? product.variants[0].id : `product-${product.id}`; // Use variant ID or product ID as key
    const item = cart.value[variantId];

    if (item) {
        item.quantity++;
    } else {
        cart.value[variantId] = {
            id: variantId,
            product_id: product.id,
            name: product.name,
            price: product.price, // Use product base price for simplicity here
            image: product.images.length > 0 ? product.images[0].image_path : null,
            quantity: 1,
            // Add variant specific details if needed
            variant: product.variants.length > 0 ? product.variants[0] : null,
        };
    }
    saveCart();
    alert(`${product.name} added to cart!`);
};

// --- Wishlist Logic (LocalStorage) ---
const wishlist = ref(JSON.parse(localStorage.getItem('wishlist')) || {});

const saveWishlist = () => {
    localStorage.setItem('wishlist', JSON.stringify(wishlist.value));
};

const isInWishlist = (productId) => {
    return !!wishlist.value[productId];
};

const toggleWishlist = (product) => {
    if (isInWishlist(product.id)) {
        delete wishlist.value[product.id];
        alert(`${product.name} removed from wishlist!`);
    } else {
        wishlist.value[product.id] = {
            id: product.id,
            name: product.name,
            price: product.price,
            image: product.images.length > 0 ? product.images[0].image_path : null,
        };
        alert(`${product.name} added to wishlist!`);
    }
    saveWishlist();
};

// Watch for changes in localStorage from other tabs/windows
window.addEventListener('storage', (event) => {
    if (event.key === 'cart') {
        cart.value = JSON.parse(event.newValue || '{}');
    }
    if (event.key === 'wishlist') {
        wishlist.value = JSON.parse(event.newValue || '{}');
    }
});

</script>

<style scoped>

</style>