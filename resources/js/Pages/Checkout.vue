<script setup>
    import {Link} from "@inertiajs/vue3";
    import AppLayout from "@/Layouts/AppLayout.vue";

    defineOptions({ layout:AppLayout })
</script>
<template>
    <div class="flex flex-col justify-between h-screen relative">
        <div class="">
            <div class="flex justify-start items-center px-2 py-3 border-b bg-white shadow-lg sticky top-0 z-10">
                <Link :href="route('home')" class="px-2 ">
                    <i class="fa-solid fa-chevron-left"></i>
                </Link>
                <div class="flex justify-start w-full">
                    <h3>Commandez-maintenant</h3>
                </div>
                <a href="" class="px-3">
                    <i class="fa-solid fa-cart-shopping  text-md"></i>
                </a>
            </div>
            <div class="flex flex-col justify-between">
                <div class="">
                    <a href="" class="px-2 py-3 flex shadow-md items-center justify-between">
                        <div class="py-2 px-4 bg-amber-900 rounded-lg text-white"><i class="fa-solid fa-location-dot"></i></div>
                        <div class="ml-3 text-left w-full">
                            <h3 class="font-semibold ">Lieu de livraison</h3>
                            <h4 class="text-sm">Abidjan, Yopougon</h4>
                        </div>
                        <span class="fa-solid fa-chevron-right"></span>
                    </a>
                    <div class="grid-cols-1 grid p-3 ">
                        <label class="">Information additionnelle</label>
                        <textarea class="textarea textarea-error" rows="4" placeholder="Exp: appelez moi avant la livraison"></textarea>
                    </div>
                </div>

            </div>
        </div>
        <div class="">
            <div class="grid grid-cols-1 gap-1">
                <div v-for="n in 5" class="flex justify-between px-3 py-2 bg-white border rounded-md">
                    <h4 class="">Soutiens-gorge rouge </h4>
                    <h4 class="">{{ n }} x 4 500 </h4>
                </div>
                <div class="flex justify-between px-3 py-2 bg-error text-white font-semibold ">
                    <h4 class="">Livraison </h4>
                    <h4 class="">9500 </h4>
                </div>
                <div class="border border-black bg-black my-2 max-w-md w-full"></div>
                <div class="flex justify-between px-3 py-2 text-black text-lg font-semibold ">
                    <h4 class="">Ma commande : </h4>
                    <h4 class="">18 500 </h4>
                </div>
            </div>
            <div class="flex justify-center bg-white px-6 py-4">
                <button class="btn bg-orange-500 w-full font-semibold uppercase text-white">Commandez maintenant</button>
            </div>
        </div>


    </div>
</template>

<style scoped>
footer{
    display: none;
}
</style>
