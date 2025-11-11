<template>
    <div class="">
        <div class="flex justify-between p-2 border-b bg-white">
            <div class="basis-4/6 w-full flex items-center">
                <a href="" class="px-2">
                    <i class="fa-solid fa-2x fa-bars"></i>
                </a>
                <img src="/assets/logo-1.png" alt="Logo SOIE RAVISSANTE" class="w-8">
                <a href="" class="text-lg uppercase ml-2 font-bold">Soie Sexy</a>
            </div>
            <div class="basis-2/6 flex justify-end text-right space-x-6">
                <a href="" class="">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </a>
                <a href="" class="relative">
                    <i class="fa-solid fa-cart-shopping text-md"></i>
                    <span v-if="cartItemCount > 0" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">{{ cartItemCount }}</span>
                </a>
                <a href="" class="relative">
                    <i class="fa-regular fa-heart text-md"></i>
                    <span v-if="wishlistItemCount > 0" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">{{ wishlistItemCount }}</span>
                </a>
            </div>
        </div>

        <div class="flex mt-2 w-full">
            <div class="w-full px-3 h-12">
                <label class="input input-bordered flex items-center gap-2 w-full">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" class="input w-full" placeholder="Chercher un article" />
                </label>
            </div>
        </div>
        <div class="flex  bg-amber-400 h-48 mt-2 border-b mb-1">
            <div class="basis-4/6 p-3 ">
                <h3 class="text-lg font-semibold">Soutien-gorge de marque Bynny's</h3>
                <div class="flex justify-between mt-2">
                    <div class="">
                        <h4 class="text-lg font-semibold">Prix</h4>
                        <h3 class="">4 500F</h3>
                    </div>
                    <div class="">
                        <h4 class="text-lg font-semibold">Taille</h4>
                        <div class="flex text-sm  justify-between text-slate-950">
                            <div class="w-10 p-2 text-center h-10 text-slate-50 rounded-full bg-amber-800">
                                M
                            </div>
                            <div class="w-10 p-2 text-center h-10  rounded-full bg-slate-50">
                                XL
                            </div> <div class="w-10 p-2 text-center h-10 rounded-full bg-slate-50">
                            XXL
                        </div>
                        </div>
                    </div>
                </div>
                <div class="flex">
                    <a href="" class="p-2 rounded-md shadow-lg bg-white border">Voir plus</a>
                </div>
            </div>
            <div class="basis-2/6">
                <img
                    src="/assets/img/21146800_M.webp"
                    alt="" class="h-48 w-full object-cover">
            </div>
        </div>
        <div class="flex bg-white">
            <h3 class="p-2 text-lg font-semibold">Nos spécialités</h3>
        </div>
        <div class="w-full overflow-x-scroll bg-white">
            <div class="flex  p-2 space-x-2">
                <a v-for="n in 10" href="">
                    <div class="min-w-32  p-1 rounded-lg shadow-2xl border">
                        <img src="/assets/img/21159700_M.webp" alt="image categorie" class="  h-32 w-32 rounded-full object-cover">
                        <h2 class=" text-center bg-red-100 m-1 p-1 rounded-full">Soutiens </h2>
                    </div>
                </a>
            </div>
        </div>
        <div class="flex mt-2">
            <h3 class="p-2 text-lg font-semibold">Nouveaux Arrivages</h3>
        </div>
        <div class="grid grid-cols-2 p-2 gap-3">
            <ItemProduct v-for="product in products.data" :key="product.id" :product="product" />
        </div>
        <!-- Pagination -->
        <div class="mt-4 flex justify-between p-2">
            <Link v-if="products.prev_page_url" :href="products.prev_page_url" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                Previous
            </Link>
            <div v-else></div>
            <Link v-if="products.next_page_url" :href="products.next_page_url" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                Next
            </Link>
        </div>

    </div>

</template>

<script setup>
import ItemProduct from "@/Layouts/ItemProduct.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue'; // Import ref, computed, watch

defineOptions({layout : AppLayout})

defineProps({
    products: Object,
});

// Cart and Wishlist counts
const cart = ref(JSON.parse(localStorage.getItem('cart')) || {});
const wishlist = ref(JSON.parse(localStorage.getItem('wishlist')) || {});

const cartItemCount = computed(() => {
    return Object.values(cart.value).reduce((sum, item) => sum + item.quantity, 0);
});

const wishlistItemCount = computed(() => {
    return Object.keys(wishlist.value).length;
});

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
