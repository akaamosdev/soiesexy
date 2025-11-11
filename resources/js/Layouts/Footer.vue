<script setup>
import {Link} from "@inertiajs/vue3";
</script>

<template>
    <div class="">
        <div class="mt-16"></div>
        <footer class="fixed bottom-0 bg-white w-full h-16 border-t-2 pb-2 border-slate-500 px-6 py-2
            rounded-l-lg rounded-r-lg max-w-md">
                <div class="flex justify-center space-x-10">
                    <Link :href="route('home')" class="text-white ">
                            <div class="bg-amber-900  text-slate-950 border px-2 py-3 rounded-full h-12 w-12 text-center
                            px-2 py-3 rounded-full h-12 w-12 text-center p">
                                <i class="fa-solid fa-house"></i>
                            </div>
                    </Link>
                    <Link :href="route('wishlist')" class="text-white ">
                        <div class="bg-amber-900  text-slate-950 border px-2 py-3 rounded-full h-12 w-12 text-center">
                            <i class="fa-solid fa-heart  cursor-pointer"></i>
                        </div>
                    </Link>
                    <Link :href="route('card')" class="text-white ">
                        <div :class="$page.component==='Card'?'bg-amber-100 text-slate-950':'bg-amber-800  text-slate-50' "
                             class=" border px-2 py-3 rounded-full h-12 w-12 text-center ">
                        <i class="fa-solid fa-cart-plus"></i>
                        </div>
                    </Link>
                    <Link :href="route('wishlist')" href="" class="text-white ">
                        <div class="bg-amber-100 text-slate-950 border px-2 py-3 rounded-full h-12 w-12 text-center p">
                            <i class="fa-solid fa-file"></i>
                        </div>
                    </Link>
                    <Link :href="route('dashboard')" class="text-white ">
                        <div class="bg-amber-900  text-slate-950 border px-2 py-3 rounded-full h-12 w-12 text-center">
                        <i class="fa-regular fa-user"></i>
                        </div>
                    </Link>
            </div>
        </footer>
    </div>
</template>

<style scoped>

</style>
