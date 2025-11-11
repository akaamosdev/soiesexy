<template>
    <div class="">
        <div class="flex justify-between p-2 border-b bg-white shadow-lg sticky top-0 z-10">
            <div class="">
                <h3 class="text-lg font-semibold">Mes préférés</h3>
                <h4> <span class="font-semibold">{{ wishlistItemCount }}</span> Produits
                    <span class="font-bold text-xl">.</span> Total :
                    <span class="font-semibold">{{ wishlistTotal }} F CFA</span></h4>
            </div>
<!--            <div class="flex items-center px-1">-->
<!--                <button class="bg-amber-300 px-4 py-3 rounded-full"><i class="fa-solid fa-magnifying-glass"></i></button>-->
<!--            </div>-->
        </div>
<!--        <div class="flex max-h-16 px-3 py-4 justify-start items-center space-x-3 border-b border-slate-600 mb-3">-->
<!--            <button class="p-2 bg-white text-slate-950 rounded-full border border-amber-400 shadow">Tous</button>-->
<!--            <button class="p-2 bg-white text-slate-950 rounded-full border border-amber-400 ">Soustiens-gorge</button>-->
<!--            <button class="p-2 bg-white text-slate-950 rounded-full border border-amber-400 ">Slip</button>-->
<!--            <button class="p-2 bg-white text-slate-950 rounded-full border border-amber-400 ">Nuisette</button>-->
<!--        </div>-->

        <div class="grid grid-cols-2 gap-3 mt-4">
            <div v-if="wishlistItemCount === 0" class="col-span-2 text-center py-10 text-gray-500">
                Your wishlist is empty.
            </div>
            <div v-for="item in wishlist" :key="item.id" class="bg-white rounded-2xl text-center relative border border-slate-50">
                <div class="wishlist absolute right-0 px-3 py-1 bg-red-100 rounded-full cursor-pointer" @click="removeItem(item.id)">
                    <i class="fa-solid text-red-500 cursor-pointer fa-xmark"></i>
                </div>
                <div class="img bg-white rounded-xl ">
                    <img v-if="item.image" :src="`/storage/${item.image}`" :alt="item.name" class="h-48 w-full object-cover rounded-xl">
                    <img v-else src="/assets/img/no-image.jpg" :alt="item.name" class="h-48 w-full object-cover rounded-xl">
                </div>
                <h1 class="text-md ">{{ item.name }}</h1>
                <h1 class="text-md font-bold text-amber-800">{{ item.price }} FCFA</h1>
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
                <button @click="addToCart(item)" class="w-full">
                    <div class="px-3 py-1 mt-2 bg-slate-950 text-white w-full rounded-se-2xl rounded-es-2xl">
                        <i class="fa-solid fa-cart-plus"></i> Ajouter au panier
                    </div>
                </button>
            </div>
        </div>
    </div>
</template>
<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref, computed, watch } from 'vue';

defineOptions({ layout:AppLayout });

const wishlist = ref(JSON.parse(localStorage.getItem('wishlist')) || {});
const cart = ref(JSON.parse(localStorage.getItem('cart')) || {}); // Needed for addToCart

const saveWishlist = () => {
    localStorage.setItem('wishlist', JSON.stringify(wishlist.value));
};

const saveCart = () => {
    localStorage.setItem('cart', JSON.stringify(cart.value));
};

const wishlistItemCount = computed(() => {
    return Object.keys(wishlist.value).length;
});

const wishlistTotal = computed(() => {
    return  Object.values(wishlist.value).reduce((sum, item) => sum + Number(item.price), 0).toFixed(2);
});

const removeItem = (id) => {
    if (confirm('Are you sure you want to remove this item from your wishlist?')) {
        delete wishlist.value[id];
        saveWishlist();
    }
};

const addToCart = (product) => {
    // This is a simplified addToCart for wishlist items.
    // In a real scenario, you'd need to handle variants properly.
    const variantId = `product-${product.id}`; // Use product ID as key for simplicity
    const item = cart.value[variantId];

    if (item) {
        item.quantity++;
    } else {
        cart.value[variantId] = {
            id: variantId,
            product_id: product.id,
            name: product.name,
            price: product.price,
            image: product.image, // Use image from wishlist item
            quantity: 1,
        };
    }
    saveCart();
    alert(`${product.name} a été ajouté dans votre panier!`);
};

// Watch for changes in localStorage from other tabs/windows
window.addEventListener('storage', (event) => {
    if (event.key === 'wishlist') {
        wishlist.value = JSON.parse(event.newValue || '{}');
    }
    if (event.key === 'cart') { // Also watch cart for addToCart from wishlist
        cart.value = JSON.parse(event.newValue || '{}');
    }
});
</script>
<style scoped>

</style>
