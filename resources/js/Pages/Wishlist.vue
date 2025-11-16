<template>
    <Head title="Mes lingerie préférées" />
    <div class="">
        <div class="flex justify-between p-2 border-b bg-white shadow-lg sticky top-0 z-10">
            <div class="">
                <h3 class="text-lg font-semibold">Mes préférés</h3>
                <h4> <span class="font-semibold">{{ formatPrice(wishlistItemCount) }}</span> Produits
                    <span class="font-bold text-xl">.</span> Total :
                    <span class="font-semibold">{{ formatPrice(wishlistTotal) }} F CFA</span></h4>
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
                Aucun produit favori
            </div>
            <div v-for="item in wishlist" :key="item.id" class="bg-white rounded-2xl text-center relative border border-rose-50">
                <div class="wishlist absolute right-0 px-3 py-1 bg-red-100 rounded-full cursor-pointer" @click="removeItem(item.id)">
                    <i class="fa-solid text-red-500 cursor-pointer fa-xmark"></i>
                </div>
                <div class="img bg-white rounded-xl ">
                    <img v-if="item.image" :src="`/storage/${item.image}`" :alt="item.name" class="h-48 w-full object-cover rounded-xl">
                    <img v-else src="/assets/img/no-image.jpg" :alt="item.name" class="h-48 w-full object-cover rounded-xl">
                </div>
                <h1 class="text-sm ">{{ item.name }}</h1>
                <h1 class="text-md font-bold text-amber-800">{{ formatPrice(item.price) }} FCFA</h1>
                <Link :href="route('show',item.slug)">
                    <div class="px-3 py-1 mt-2 bg-slate-950 text-white w-full rounded-se-2xl rounded-es-2xl">
                        <i class="fa-solid fa-cart-plus"></i> Ajouter au panier
                    </div>
                </Link>
            </div>
        </div>
    </div>
</template>
<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import {ref, computed, watch, onMounted} from 'vue';
import {formatPrice, getWishlist} from "../helpers.js";
import {Head, Link} from "@inertiajs/vue3";

defineOptions({ layout:AppLayout });

const wishlist = ref(getWishlist())

const wishlistItemCount = computed(() => {
    return wishlist.value.length;
});

const wishlistTotal = computed(() => {

    return wishlist.value.reduce((sum, item) => sum + Number(item.price), 0).toFixed(2);
});

const removeItem = (id) => {
   var index= wishlist.value.indexOf(id);
   wishlist.value.splice(index,1);
   localStorage.setItem("wishlist",JSON.stringify(wishlist.value));
};

const addToCart = (product) => {
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


</script>
<style scoped>

</style>
