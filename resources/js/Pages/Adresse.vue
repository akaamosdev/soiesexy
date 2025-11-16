<template>
    <Head title="Votre adresse de livraion" />
    <div class="relative h-screen">
        <div class="flex justify-start items-center px-2 py-3 border-b bg-white shadow-lg sticky top-0 z-10">
            <Link :href="route('home')" class="px-2 ">
                <i class="fa-solid fa-chevron-left"></i>
            </Link>
            <div class="flex justify-start w-full">
                <h3>Information de livraison</h3>
            </div>
        </div>
        <form @submit.prevent="storeAdresse">
            <div class="grid grid-cols-1 gap-3 p-3">
                <div class="flex  justify-center mb-3">
                    <img src="/assets/img/delivery.avif" alt="" class="rounded-full object-contain h-32 border border-red-200">
                </div>
                <div class="grid-cols-1 grid">
                    <label class="font-semibold">
                        Votre nom
                    </label>
                    <input type="text" v-model="form_delivery.name" required class="input shadow-md font-semibold bg-rose-50" placeholder="">
                </div>
                <div class="grid-cols-1 grid">
                    <label class="font-semibold">Votre numéro</label>
                    <input type="text" v-model="form_delivery.phone" required class="input shadow-md font-semibold bg-rose-50" placeholder="">
                </div>
                <div class="grid-cols-1 grid">
                    <label class="font-semibold">Lieu de livraison</label>
                    <input type="text" v-model="form_delivery.address" required class="input shadow-md font-semibold bg-rose-50" placeholder="">
                </div>
                <div class="">
                    <h3 class="font-semibold mb-3">Mode de livraison</h3>
                  <div class="bg-gray-100 p-2 rounded-md">
                      <div class="flex justify-between items-center mb-2">
                          <label for=""><input type="radio" required v-model="form_delivery.frais" value="1500" > Abidjan</label>
                          <label for="" class="font-semibold">1 500 F CFA</label>
                      </div>
                      <div class="flex justify-between items-center">
                          <label for=""><input type="radio" v-model="form_delivery.frais" value="2500" > Hors Abidjan</label>
                          <label for="">2 500 F CFA</label>
                      </div>
                  </div>

                </div>
                <button type="submit" class="text-center py-4 rounded-full bg-rose-600 text-white font-semibold">
                    Suivant <i class="fa-solid fa-arrow-right"></i>
                </button>

            </div>
        </form>

    </div>
</template>

<script setup>
import {Head, Link, router} from "@inertiajs/vue3";
    import AppLayout from "@/Layouts/AppLayout.vue";
    import {reactive, ref} from "vue";
    import {getAddressLivraison} from "@/helpers.js";

    defineOptions({ layout:AppLayout });
    const last_adresse= ref(getAddressLivraison());
    const form_delivery= reactive({
        name:last_adresse.value.name,
        phone:last_adresse.value.phone??"+225",
        address:last_adresse.value.address,
        frais:last_adresse.value.frais??1500,
    })
    const storeAdresse = () => {
        localStorage.setItem("adresse_livraison",JSON.stringify(form_delivery));
        router.get(route("checkout"));
    }
</script>

<style scoped>

</style>
