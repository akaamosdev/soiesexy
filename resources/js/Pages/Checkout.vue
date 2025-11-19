<script setup>
import {Head, Link, router} from "@inertiajs/vue3";
    import AppLayout from "@/Layouts/AppLayout.vue";
    import {computed, onMounted, ref} from "vue";
    import {formatPrice, getAddressLivraison, getCart} from "../helpers.js";
    defineOptions({ layout:AppLayout })
    const cart = ref(getCart());
    const adresse= ref(getAddressLivraison());
    const loading = ref(false);

    const montantLivraison = ref(adresse.value.frais); // Example: 1000 FCFA delivery fee

    const totalCommande = computed(() => {
        const totalProduits = cart.value.reduce((acc, item) => {
            return acc + (Number(item.price) * Number(item.quantity));
        }, 0);

        return totalProduits + Number(montantLivraison.value);
    });
    const storeOrders = () => {
        loading.value = true;
        axios.post(route('orders.store'), {
            name:adresse.value.name,
            phone: adresse.value.phone,
            address: adresse.value.address,
            frais: montantLivraison.value,
            montant:totalCommande.value,
            items:cart.value
        },).then(response => {
            localStorage.removeItem('cart');
            window.location.href = route("orders.success");
            router.get();
        }).catch(error => {
            loading.value = false;
        })


    }

onMounted(() => {
    if (localStorage.getItem('adresse_livraison')==null) {
        window.location.href = route('adresse.create');
    }
})
</script>
<template>
    <Head title="Détails commandes" />
    <div class="flex flex-col justify-start h-screen relative">
        <div class="">
            <div class="flex justify-start items-center px-2 py-3 border-b bg-white shadow-lg sticky top-0 z-10">
                <Link :href="route('home')" class="px-2 ">
                    <i class="fa-solid fa-chevron-left"></i>
                </Link>
                <div class="flex justify-start w-full">
                    <h3>Détail commande</h3>
                </div>
                <a href="" class="px-3">
                    <i class="fa-solid fa-cart-shopping  text-md"></i>
                </a>
            </div>
            <div class="flex flex-col justify-between">
                <div class="">
                    <Link :href="route('adresse.create')" class="px-2 py-3 flex shadow-md items-center justify-between">
                        <div class="py-2 px-4 bg-rose-900 rounded-lg text-white"><i class="fa-solid fa-location-dot"></i></div>
                        <div class="ml-3 text-left w-full">
                            <h3 class="font-semibold flex justify-between ">Lieu de livraison</h3>
                            <h4 class="text-sm">{{ adresse.address }}</h4>
                        </div>
                        <div class="">
                            <h3 class="font-semibold">Téléphone</h3>
                            <h4 class="text-sm text-red-600">{{ adresse.phone}}</h4>
                        </div>
                    </Link>
                </div>

            </div>
        </div>
        <div class="">
            <div class="grid grid-cols-1 gap-1">
                <div v-for="ca in cart" class="flex justify-between px-3 py-2 bg-white border rounded-md">
                    <h4 class="">{{ ca.name }} </h4>
                    <h4 class="">{{ ca.quantity }} x {{  formatPrice(ca.price) }} </h4>
                </div>

                <div class="flex justify-between px-3 py-2 text-red-600 font-semibold ">
                    <h4 class="">Frais livraison </h4>
                    <h4 class="">{{ formatPrice(montantLivraison)}}</h4>
                </div>
                <div class="border border-black bg-black my-2 max-w-md w-full"></div>
                <div class="flex justify-between px-3 py-2 text-black text-lg font-semibold ">
                    <h4 class="">Total commande : </h4>
                    <h4 class="">{{ formatPrice(totalCommande) }} </h4>
                </div>
            </div>
            <div class="flex justify-center bg-white px-6 py-4">
                <button @click="storeOrders" :disabled="loading"
                        class="btn bg-rose-500 hover:bg-rose-600 disabled:opacity-50
                         w-full font-semibold uppercase rounded-xl text-white">
                    <span v-if="loading" class="loading loading-spinner text-secondary"></span>
                    Commandez maintenant</button>
            </div>
        </div>


    </div>
</template>

<style scoped>
footer{
    display: none;
}
</style>
