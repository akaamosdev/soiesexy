<template>
    <div class="relative h-screen">
        <div class="flex justify-start items-center px-2 py-3 border-b bg-white shadow-lg sticky top-0 z-10">
            <Link :href="route('home')" class="px-2 ">
                <i class="fa-solid fa-chevron-left"></i>
            </Link>
            <div class="flex justify-start w-full">
                <h3>Lieu de livraison</h3>
            </div>
            <Link :href="route('card')" class="px-3">
                <i class="fa-solid fa-cart-shopping  text-md"></i>
            </Link>

        </div>
        <div class="grid grid-cols-1 gap-3 p-3">
            <div class="flex  justify-center mb-3">
<!--               <img src="/assets/logo-1.png" alt="" class="rounded-full object-contain h-48 border border-red-200">-->
                <div class=" mt-5">
                    <i class="fa-solid fa-2x fa-location-dot"></i>
                </div>
            </div>
            <div class="grid-cols-1 grid">
                <label class="font-semibold">
                    Votre prénoms ou nom
                </label>
                <input type="text" class="input shadow-md" placeholder="">
            </div>
            <div class="grid-cols-1 grid">
                <label class="font-semibold">Votre numéro</label>
                <input type="text" class="input shadow-md" placeholder="">
            </div>
            <div class="grid-cols-1 grid">
                <label class="font-semibold">Votre Email (facultatif)</label>
                <input type="text" class="input shadow-md" placeholder="">
            </div>
            <div class="grid-cols-1 grid">
                <label class="font-semibold">Ville</label>
                <input type="text" class="input shadow-md" placeholder="">
            </div>
            <div class="grid-cols-1 grid">
                <label class="font-semibold">Votre quartier ou rue</label>
                <input type="text" class="input shadow-md" placeholder="">
            </div>
            <Link :href="route('checkout')" class="text-center py-4 rounded-full bg-amber-800 text-white font-semibold">
                Suivant <i class="fa-solid fa-arrow-right"></i>
            </Link>

        </div>

    </div>
</template>

<script setup>
    import {Link} from "@inertiajs/vue3";
    import AppLayout from "@/Layouts/AppLayout.vue";

    defineOptions({ layout:AppLayout })
</script>

<style scoped>

</style>
