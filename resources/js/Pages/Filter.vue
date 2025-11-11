
<script setup>
import {Link} from "@inertiajs/vue3";
import {ref} from "vue";
import ItemProduct from "@/Layouts/ItemProduct.vue";
import AppLayout from "@/Layouts/AppLayout.vue";

defineOptions({ layout:AppLayout })
const isFilter= ref(false);
</script>
<template>
    <div class="relative">
        <div class="flex justify-start items-center p-2 border-b bg-white shadow-lg sticky top-0 z-10">
            <Link :href="route('home')" class="px-2 ">
                <i class="fa-solid fa-chevron-left"></i>
            </Link>
            <div class="flex justify-start w-full">
                <input type="text" class="input input-bordered w-full" placeholder="Trouver votre lingerie sexy ici">
            </div>
            <a href="" class="px-3">
                <i class="fa-solid fa-cart-shopping  text-md"></i>
            </a>
        </div>
        <div class="grid grid-cols-2 gap-2 px-2 mt-2">
            <ItemProduct v-for="n in 10" />
        </div>

        <div class="fixed bottom-0 bg-white w-full h-16 pb-2  px-2 pt-2
    rounded-l-lg rounded-r-lg max-w-md  rounded-full  z-10 ">
            <div class="flex justify-between space-x-0">
                <button class=" p-3 w-full text-gray-700 font-semibold text-center">
                    <i class="fa-solid fa-arrow-down-wide-short"></i> Prix
                </button>
                <button id="show-filter" @click="(()=> isFilter=!isFilter)" class="p-3  w-full text-gray-700 border-l border-gray-700 font-semibold text-center">
                    <i class="fa-solid fa-filter"></i> Categories</button>
            </div>
        </div>

        <div class="fixed opacity-100 hidden filter-show bottom-0 bg-red-100 w-full max-w-md mb-16
     max-w-md border border-gray-700 z-10 rounded-lg min-h-[500px] p-3" v-if="isFilter">
            <div class="flex justify-between mb-2">
                <div class="font-semibold"><h2 class="">Filtrer</h2></div>
                <div class="">
                    <button class="text-black rounded-full"><i class="fa-solid fa-filter"></i></button>
                </div>
            </div>
            <hr class="mb-3">
            <h3 class="font-semibold text-lg">Categorie:</h3>
            <div class="grid grid-cols-2 px-0 py-4 gap-2 mb-1 text-md border-b border-slate-50">
                <button class="p-2 bg-white text-slate-950 rounded-lg border border-red-400 shadow">Tous</button>
                <button class="p-2 bg-white text-slate-950 rounded-lg border border-red-400 ">Soustiens-gorge</button>
                <button class="p-2 bg-white text-slate-950 rounded-lg border border-red-400 ">Slip</button>
                <button class="p-2 bg-white text-slate-950 rounded-lg border border-red-400 ">Nuisette</button>
                <button class="p-2 bg-white text-slate-950 rounded-lg border border-red-400 ">Nuit de miel</button>
            </div>
            <hr class="mb-3">
            <h3 class="font-semibold text-lg">Tailles:</h3>
            <div class="grid grid-cols-4 px-0 py-4 gap-2 mb-1 text-md border-b border-slate-50">
                <button class="p-2 bg-white text-slate-950 rounded-lg border border-red-400 shadow">Tous</button>
                <button class="p-2 bg-white text-slate-950 rounded-lg border border-red-400 ">Standard</button>
                <button class="p-2 bg-white text-slate-950 rounded-lg border border-red-400 ">S</button>
                <button class="p-2 bg-white text-slate-950 rounded-lg border border-red-400 ">M</button>
                <button class="p-2 bg-white text-slate-950 rounded-lg border border-red-400 ">XL</button>
                <button class="p-2 bg-white text-slate-950 rounded-lg border border-red-400 ">XXL</button>
                <button class="p-2 bg-white text-slate-950 rounded-lg border border-red-400 ">3XL</button>
                <button class="p-2 bg-white text-slate-950 rounded-lg border border-red-400 ">4XL</button>
            </div>
            <hr class="mb-2">
            <h3 class="font-semibold text-lg mb-1">Prix:</h3>
            <div class="flex justify-between">
                <div class="mr-3">
                    <input type="number" class="input w-full bordered">
                </div>
                <div class="divider divider-horizontal">-</div>
                <div class="">
                    <input type="number" class="input w-full">
                </div>
            </div>
            <hr>
            <div class="flex mt-2 w-full justify-center space-x-2 font-semibold">
                <button class="px-3 py-2 bg-white rounded-full w-full">Effacer</button>
                <button class="px-3 py-3 bg-amber-900 text-white w-full rounded-full ">Appliquer</button>
            </div>
        </div>
        <div class="mb-4"></div>
    </div>
</template>

<style scoped>
footer{
    display: none;
}
</style>
