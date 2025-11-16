<template>
    <Head title="Mon panier" />
    <div class="h-screen flex flex-col  justify-between">
        <div class="">
            <div class="flex justify-between p-2 border-b bg-white shadow-lg sticky top-0 z-10">
                <div class="">
                    <h3 class="text-lg font-semibold">Mon panier</h3>
                    <h4> <span class="font-semibold">{{ cartItemCount }}</span> Produits
                    </h4>
                </div>
                <div class="flex items-center px-0">
                    <Link :href="route('adresse.create')" class="bg-rose-600 text-white px-4 py-2 rounded-lg">
                        Commandez
                        <i class="fa-solid fa-arrow-right"></i>
                    </Link>
                </div>
            </div>
            <div class=" px-3 py-3 border-b border-slate-700 mb-3 bg-amber-50">
                <h3 class="text-xl">Total <span class="font-semibold">{{ Number(cartTotal).toLocaleString('fr-FR') }} F CFA</span></h3>
<!--                <h2 class="text-green-700">-->
<!--                    <i class="fa-solid fa-circle-check"></i>-->
<!--                    Livraison gratuite pour votre commande-->
<!--                </h2>-->
            </div>

            <div class="grid grid-cols-1 max-h-[75vh] overflow-auto">
                <div v-if="cartItemCount === 0" class="text-center py-10 text-gray-500">
                    Votre panier est vide.
                </div>
                <div v-for="(item,id) in cart" :key="id" class="flex relative border m-1 p-1 rounded-md">
                    <div class="basis-2/6">
                        <div class="img bg-white rounded-xl ">
                            <img :src="`/storage/${item.image}`" :alt="item.name" class="h-32 w-full object-contain rounded-xl">
                        </div>
                    </div>
                    <div class="px-4 py-1 basis-4/6">
                        <h1 class="text-md font-semibold">{{ item.name }}</h1>
                        <h1 class="text-lg text-amber-800 mt-2"><span class="font-bold">{{ item.price }} FCFA</span>
                        </h1>
                        <div class="flex justify-between mt-5">
                            <div class="basis-3/6">
                                <div class="flex justify-between">
                                    <button @click="updateQuantity(id, -1)" class="px-3 py-0 rounded-full bg-amber-950 text-white font-semibold text-xl">-</button>
                                    <span class=" text-xl">{{ item.quantity }}</span>
                                    <button @click="updateQuantity(id, 1)" class="px-2 py-0 rounded-full bg-amber-950 text-white font-semibold text-xl">+</button>
                                </div>
                            </div>
                            <div class="basis-3/6 text-right">
                                <button @click="removeItem(id)" class="text-red-500"><i class="fa-regular fa-trash-can"></i> Supprimer</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=" my-2 border-b border-red-600 " v-if="cartItemCount > 0">

                </div>
            </div>
        </div>
        <Link :href="route('shop')" class="p-3 mb-20 shadow-2xl bg-amber-600 bg-transparent/52 max-w-md w-full text-center
          bottom-0  text-white">
            Ajouter d'autres articles
        </Link>
    </div>

</template>

<script setup>
import {Head, Link} from "@inertiajs/vue3";
    import AppLayout from "@/Layouts/AppLayout.vue";
    import {ref, computed, watch, onMounted} from 'vue';
    import {getCart} from "@/helpers.js";

    defineOptions({ layout:AppLayout });

    const cart = ref(getCart());

    const saveCart = () => {
        localStorage.setItem('cart', JSON.stringify(cart.value));
    };

    const cartItemCount = computed(() => {
        return Object.values(cart.value).reduce((sum, item) => sum + item.quantity, 0);
    });

    const cartTotal = computed(() => {
        return Object.values(cart.value).reduce((sum, item) => sum + (item.price * item.quantity), 0).toFixed(2);
    });

    const updateQuantity = (id, change) => {
        const item = cart.value[id];
        if (item) {
            item.quantity += change;
            if (item.quantity <= 0) {
                delete cart.value.splice(id, 1);
            }
            saveCart();
        }
    };

    const removeItem = (id) => {
       delete cart.value.splice(id, 1);
       localStorage.setItem('cart', JSON.stringify(cart.value));
    };


</script>

<style scoped>

</style>
