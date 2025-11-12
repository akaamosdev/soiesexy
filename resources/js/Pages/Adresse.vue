<template>
    <div class="relative h-screen">
        <div class="flex justify-start items-center px-2 py-3 border-b bg-white shadow-lg sticky top-0 z-10">
            <Link :href="route('home')" class="px-2 ">
                <i class="fa-solid fa-chevron-left"></i>
            </Link>
            <div class="flex justify-start w-full">
                <h3>Information de livraison</h3>
            </div>
            <Link :href="route('card')" class="px-3">
                <i class="fa-solid fa-cart-shopping  text-md"></i>
            </Link>

        </div>
        <form @submit.prevent="storeAdresse">
            <div class="grid grid-cols-1 gap-3 p-3">
                <div class="flex  justify-center mb-3">
                    <img src="/assets/img/delivery.avif" alt="" class="rounded-full object-contain h-48 border border-red-200">
<!--                    <div class=" mt-5 bg-red-50 p-3 rounded-full">-->
<!--                        <i class="fa-solid fa-2x fa-location-dot"></i>-->
<!--                    </div>-->
                </div>
                <div class="grid-cols-1 grid">
                    <label class="font-semibold">
                        Votre Nom
                    </label>
                    <input type="text" v-model="form_delivery.name" required class="input shadow-md font-semibold bg-red-50" placeholder="">
                </div>
                <div class="grid-cols-1 grid">
                    <label class="font-semibold">Votre numéro</label>
                    <input type="text" v-model="form_delivery.phone" required class="input shadow-md font-semibold bg-red-50" placeholder="">
                </div>
                <div class="grid-cols-1 grid">
                    <label class="font-semibold">Lieu de livraison</label>
                    <input type="text" v-model="form_delivery.address" required class="input shadow-md font-semibold bg-red-50" placeholder="">
                </div>
                <button type="submit" class="text-center py-4 rounded-full bg-amber-800 text-white font-semibold">
                    Suivant <i class="fa-solid fa-arrow-right"></i>
                </button>

            </div>
        </form>

    </div>
</template>

<script setup>
    import {Link} from "@inertiajs/vue3";
    import AppLayout from "@/Layouts/AppLayout.vue";
    import {reactive} from "vue";

    defineOptions({ layout:AppLayout })
    const form_delivery= reactive({
        name:null,
        phone:null,
        address:null,
    })
    const storeAdresse = () => {
        localStorage.setItem("adresse_livraison",JSON.stringify(form_delivery));
        window.location.href=route("checkout");
    }
</script>

<style scoped>

</style>
