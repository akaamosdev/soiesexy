
<script setup>
import {Head, Link} from "@inertiajs/vue3";
    import AppLayout from "@/Layouts/AppLayout.vue";
    defineOptions({ layout:AppLayout })
</script>
<template>
    <Head title="Espace client " />
    <div class="flex flex-col justify-between h-screen relative">
        <div class="">
            <div class="flex justify-start items-center px-2 py-3 border-b bg-white shadow-lg sticky top-0 z-10">
                <Link :href="route('home')" class="px-2 ">
                    <i class="fa-solid fa-chevron-left"></i>
                </Link>
                <div class="flex justify-start w-full ml-2">
                    <h3 class="font-bold text-center ">Qui sommes nous </h3>
                </div>
                <a href="" class="px-3">
                    <i class="fa-solid fa-cart-shopping  text-md"></i>
                </a>
            </div>
            <div class="flex flex-column items-center my-6 mx-3">
                <div class="">
                    <img src="/assets/img/img-02.jpg" alt="" class="border-2 border-white h-16 w-16 object-cover rounded-full">
                </div>
                <h2 class="text-2xl mx-2">Bonjour, <strong>Amos Aka</strong></h2>
            </div>
            <div class="grid grid-cols-2 gap-4 mx-4">
                <button class="px-2 py-4 border border-orange-800 font-bold shadow-lg rounded-full bg-white">
                    Vos commandes
                </button>
                <button class="px-2 py-4 border border-orange-800 font-bold shadow-lg rounded-full bg-white">
                    Mes favoris
                </button>
                <button class="px-2 py-4 border border-orange-800 font-bold shadow-lg rounded-full bg-white">
                    Suivi de commande
                </button>
            </div>
            <hr class="my-6">
            <div class="mx-3 ">
                <h3 class="font-semibold text-xl mt-1">Mon compte</h3>
                <div class="grid-cols-1 grid gap-4 text-lg divider">
                    <a href="" class="w-full flex justify-between">
                        <span class="text-left">Editer mon profile</span>
                        <span class="text-right"><i class="fa-solid fa-chevron-right"></i></span>
                    </a>
                    <a href="" class="w-full flex justify-between">
                        <span class="text-left">Notez nos articles</span>
                        <span class="text-right"><i class="fa-solid fa-chevron-right"></i></span>
                    </a>
                    <a href="" class="w-full flex justify-between">
                        <span class="text-left">Question/Reponse</span>
                        <span class="text-right"><i class="fa-solid fa-chevron-right"></i></span>
                    </a>

                </div>
            </div>

        </div>
    </div>
</template>

<style scoped>

</style>
