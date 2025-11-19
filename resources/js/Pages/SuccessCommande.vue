<template>
    <Head title="Succès commande "/>
    <div class="relative h-screen">
        <div class="flex justify-start items-center px-2 py-3 border-b bg-white shadow-lg sticky top-0 z-10">
            <Link :href="route('home')" class="px-2 ">
                <i class="fa-solid fa-chevron-left"></i>
            </Link>
            <div class="flex justify-start w-full">
                <h3>Succès commande</h3>
            </div>

        </div>
        <div class="grid grid-cols-1 gap-3 p-3 text-center">
            <div class="flex  justify-center mb-3">
                <img src="/assets/img/ok.gif" alt="" class="rounded-full object-contain h-32 border border-red-200">
            </div>
            <div class=" w-full text-center mt-10">
                <p class="mb-4 text-lg"><strong class="text-rose-600 font-semibold">Félicitation</strong>, nous avons bien reçu votre commande, vous serez contactez pour la livraison</p>
                 <a :href="route('home')" class="px-3 py-2 border-rose-600 rounded text-rose-700 border mt-3">Faire une autre commande</a>
            </div>

        </div>

    </div>
</template>

<script setup>
import {Head, Link} from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import {reactive, ref} from "vue";
import {getAddressLivraison} from "@/helpers.js";

defineOptions({ layout:AppLayout });
</script>

<style scoped>

</style>
