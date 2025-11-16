
<script setup>
import {Head, Link, router, useForm} from "@inertiajs/vue3";
import {ref, watch} from "vue";
import ItemProduct from "@/Layouts/ItemProduct.vue";
import AppLayout from "@/Layouts/AppLayout.vue";

defineOptions({ layout:AppLayout })
const isFilter= ref(false);
const props = defineProps({
    products:Array,
    categories:Array,
    tailles:Array,
    colors:Array
})
const form = useForm({
    category_id:0,
    taille_id:0,
    min_price:0,
    max_price:0,
    search: null,
    orderBy:null,
})
const changeCatId = (catId) => {
  form.category_id = catId;
}
const changeTaille = (tailleId) => {
    form.taille_id = tailleId;
}
watch(form,(value)=>{
    router.get(route('shop'),{
        params:value
    },{
        preserveState:true,
    })
})
const orderByPrice = () => {
  if (form.orderBy==null||form.orderBy==="DESC") {
      form.orderBy="ASC";
  }else{
      form.orderBy="DESC";
  }
}
</script>
<template>
    <Head title="Lingerie sexy à bas prix" />
    <div class="relative">
        <div class="flex justify-start items-center p-2 border-b bg-white shadow-lg sticky top-0 z-10">
            <Link :href="route('home')" class="px-2 ">
                <i class="fa-solid fa-chevron-left"></i>
            </Link>
            <div class="flex justify-start w-full">
                <input type="text" v-model="form.search" class="input input-bordered w-full" placeholder="Trouver votre lingerie sexy ici">
            </div>
            <div class="flex justify-start">
                <button class=" p-3 w-full text-gray-700 font-semibold text-center" @click="orderByPrice">
                    <i class="fa-solid fa-arrow-down-wide-short"></i>
                </button>
                <button id="show-filter" @click="(()=> isFilter=!isFilter)" class="p-3  w-full text-gray-700 font-semibold text-center">
                    <i class="fa-solid fa-filter"></i> </button>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-2 px-2 mt-2">
            <ItemProduct v-for="product in products" :product="product" />
        </div>

        <div class="fixed opacity-100 filter-show bottom-0 left-0 right-0 mx-auto bg-red-100 w-full mb-16
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
                <button v-for="cat in categories" :key="cat.id" @click="changeCatId(cat.id)" :disabled="form.category_id===cat.id"
                        class="p-2 bg-white text-slate-950 disabled:bg-orange-600 rounded-lg border border-red-400 shadow">
                    {{ cat.name }}
                </button>
            </div>
            <hr class="mb-3">
            <h3 class="font-semibold text-lg">Tailles:</h3>
            <div class="grid grid-cols-4 px-0 py-4 gap-2 mb-1 text-md border-b border-slate-50">
                <button v-for="siz in tailles" :key="siz.id" @click="changeTaille(siz.id)" :disabled="form.taille_id===siz.id"  class="p-2 bg-white text-slate-950 rounded-lg
                border border-red-400 shadow disabled:bg-orange-600">{{ siz.name }}</button>

            </div>
            <hr class="mb-2">
            <h3 class="font-semibold text-lg mb-1">Prix:</h3>
            <div class="flex justify-between">
                <div class="mr-3">
                    <input type="number" v-model="form.min_price" class="input w-full bordered">
                </div>
                <div class="divider divider-horizontal">-</div>
                <div class="">
                    <input type="number" v-model="form.max_price" class="input w-full">
                </div>
            </div>
            <hr>
            <div class="flex mt-2 w-full justify-center space-x-2 font-semibold">
                <button class="px-3 py-2 bg-white rounded-full w-full" @click="(()=>form.reset())">Effacer</button>
                <button class="px-3 py-3 bg-amber-900 text-white w-full rounded-full " @click="">Appliquer</button>
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
