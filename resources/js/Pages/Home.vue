<template>
    <Head title="Lingerie féminine séduisante, élégante et irrésistible en côte d'ivoire" />
    <div class="">
        <div class="top-0 left-0 flex sticky justify-center z-10 items-center w-full">
            <div class="flex justify-between p-2 border-b w-full bg-slate-100">
                <div class="basis-4/6 w-full flex items-center">
                    <!--                <a href="" class="px-2">-->
                    <!--                    <i class="fa-solid fa-2x fa-bars"></i>-->
                    <!--                </a>-->
                    <img src="/assets/img/logo_red.png" alt="Logo SOIE Sexy" class="h-8">
                    <a href="" class="text-lg uppercase ml-2 font-bold">Soie Sexy</a>
                </div>
                <div class="basis-2/6 flex justify-end text-right space-x-6 items-center">

                    <Link :href="route('card')" class="relative">
                        <i class="fa-solid fa-cart-shopping text-md"></i>
                        <span v-if="cartItemCount > 0" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">{{ cartItemCount }}</span>
                    </Link>
                    <Link :href="route('wishlist')" class="relative">
                        <i class="fa-regular fa-heart text-md"></i>
                        <span v-if="wishlistItemCount > 0" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">{{ wishlistItemCount }}</span>
                    </Link>
                    <a href="https://wa.me/2250798690325" target="_blank"
                       class="items-center px-2 py-1 bg-green-600 text-white rounded-full shadow hover:bg-green-700">
                        <i class="fa-brands fa-whatsapp "></i>
                    </a>
                </div>
            </div>
        </div>

<!--        <div class="flex mt-2 w-full">-->
<!--            <div class="w-full px-3 h-12">-->
<!--                <label class="input input-bordered flex items-center gap-2 w-full">-->
<!--                    <i class="fa-solid fa-magnifying-glass"></i>-->
<!--                    <input type="text" class="input w-full" placeholder="Chercher un article" />-->
<!--                </label>-->
<!--            </div>-->
<!--        </div>-->
        <div class="flex  bg-amber-400 h-48 mt-2 border-b mb-1">
            <div class="basis-4/6 p-3 ">
                <h3 class="text-lg font-semibold">{{ top_prod.name }}</h3>
                <div class="flex justify-between mt-2">
                    <div class="">
                        <h4 class="text-lg font-semibold">Promo</h4>
                        <h3 class="font-bold">{{ formatPrice(top_prod.price) }}F</h3>
                    </div>
                    <div class="">
                        <h4 class="text-lg font-semibold">Taille</h4>
                        <div class="flex text-sm items-center justify-between text-slate-950 space-x-2">
                            <div v-for="pro in top_prod.tailles.slice(0,2)" class="w-10 p-2 text-center h-10 text-slate-950 rounded-full bg-white">
                                {{ pro.name }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex">
                    <Link :href="route('show',top_prod.slug)" class="p-2 rounded-md shadow-lg bg-white border">Voir plus</Link>
                </div>
            </div>
            <div class="basis-2/6">
                <img
                    :src="`/storage/${top_prod.images[0].image_path}`"
                    alt="" class="h-48 w-full object-cover">
            </div>
        </div>
        <div class="w-full bg-gradient-to-r from-pink-600 to-red-600
        text-white py-3 px-2 flex items-center gap-3 animate-pulse shadow-lg">
            <span class="inline-flex items-center justify-center w-6 h-6 bg-white text-red-600 font-bold rounded-full">
                !
            </span>
            <p class="text-sm sm:text-base font-semibold">
                2 articles achétés livraion gratuite à <strong class="text-orange-50">Abidjan</strong>
            </p>
        </div>
        <div class="flex bg-white">
            <h3 class="p-2 text-lg font-semibold">Nos spécialités</h3>
        </div>
        <div class="w-full overflow-x-scroll bg-white">
            <div class="flex  p-2 space-x-2">
                <Link :href="route('shop','category='+cat.id)" v-for="cat in categories" href="">
                    <div class="min-w-32  p-1 rounded shadow-2xl border">
                        <img :src="`/storage/${cat.image}`" alt="image categorie" class="  h-28 w-28 rounded-full object-cover">
                        <h2 class="text-nowrap text-center bg-red-100 m-1 p-1 rounded">{{ cat.name }} </h2>
                    </div>
                </Link>
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
                Precedent
            </Link>
            <div v-else></div>
            <Link v-if="products.next_page_url" :href="products.next_page_url" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                Suivant
            </Link>
        </div>

    </div>

</template>

<script setup>
import ItemProduct from "@/Layouts/ItemProduct.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import {Head, Link} from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';
import {getCart, getWishlist, formatPrice} from "@/helpers.js"; // Import ref, computed, watch

defineOptions({layout : AppLayout})

const prosps = defineProps({
    products: Object,
    categories: Array,
});

const top_prod = computed(() => {
   return  prosps.products.data[0];
})
// Cart and Wishlist counts
const cart = ref(getCart());
const wishlist = ref(getWishlist());

const cartItemCount = computed(() => {
   return cart.value.reduce((sum, item) => sum + item.quantity, 0);
});

const wishlistItemCount = computed(() => {
    return wishlist.value.length;
});
</script>

<style scoped>

</style>
