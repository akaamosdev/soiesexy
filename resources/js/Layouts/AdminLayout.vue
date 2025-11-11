<template>
    <div class="  md:px-[200px] w-full mx-auto  relative z-10 h-screen bg-slate-900 overflow-y-scroll  relative">
        <div class="flex justify-between">
            <div class="sidebar basis-1/4 bg-slate-800 h-screen sticky top-0">
                <div class="grid grid-cols-1 text-white gap-2  ">
                    <h1 class=" px-2 text-xl py-3 uppercase font-semibold">Soie ravissante </h1>
                    <hr>
                    <div class="py-3 grid-cols-1 grid gap-0">
                        <Link :href="route('admin.dashboard')" class="p-3 bg-slate-900 hover:bg-slate-800 font-semibold">Tableau de bord</Link>
                        <Link :href="route('products.index')" class="p-3 bg-slate-900 hover:bg-slate-800 font-semibold">Produits</Link>
                        <Link :href="route('categories.index')" class="p-3 bg-slate-900 hover:bg-slate-800 font-semibold">Categories</Link>
                        <Link :href="route('tailles.index')" class="p-3 bg-slate-900 hover:bg-slate-800 font-semibold">Tailles</Link>
                        <Link :href="route('colors.index')" class="p-3 bg-slate-900 hover:bg-slate-800 font-semibold">Couleurs</Link>
                        <Link :href="route('orders.index')" class="p-3 bg-slate-900 hover:bg-slate-800 font-semibold">Commandes</Link>
                        <Link :href="route('users.index')" class="p-3 bg-slate-900 hover:bg-slate-800 font-semibold">Clients</Link>
                    </div>
                </div>
            </div>
            <div class="bg-gray-200 w-full ">
                <div class="flex w-full justify-between bg-gray-100 py-3  px-3 shadow-md">
                    <div class="  sticky top-0">
                        <h3 class="text-lg font-bold">Espace Administrateur</h3>
                    </div>
                    <div class="">
                        <span></span>
                        <h3>{{ user.name }}</h3>
                    </div>
                </div>
                <slot />
            </div>
        </div>

    </div>
</template>

<script setup>
import {Link, usePage} from "@inertiajs/vue3";

const user = usePage().props.auth.user;
</script>

<style scoped>
body{
    background-color: black;
}
</style>
