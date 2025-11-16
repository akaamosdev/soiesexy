
<script setup>
import {Head, Link} from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
defineOptions({ layout:AppLayout })
</script>
<template>
    <Head title=" À propos de nous" />
    <div class="flex flex-col justify-start h-screen relative mb-28">
        <div class="">
            <div class="flex justify-start items-center px-2 py-3 border-b bg-white shadow-lg sticky top-0 z-10">
                <Link :href="route('home')" class="px-2 ">
                    <i class="fa-solid fa-chevron-left"></i>
                </Link>
                <div class="flex justify-start w-full ml-2">
                    <h3 class="font-bold text-center ">Qui sommes nous </h3>
                </div>
            </div>

        </div>
        <section class="max-w-3xl mx-auto p-2 bg-white rounded-2xl shadow-lg mb-32">
            <header class="mb-2">
                <h2 class="text-xl font-extrabold text-rose-600 dark:text-rose-400">
                    À propos de nous — <span class="text-gray-800 ">Soie Sexy</span>
                </h2>
            </header>
            <div class="flex justify-center h-64">
                <img src="/assets/img/about.jpg" alt="" class="my-3 w-full object-cover rounded text-center justify-center">
            </div>

            <div class="space-y-4 text-gray-700 leading-relaxed">
                <p class="text-base md:text-lg">
                    En Afrique, quand un homme aime sa femme, on dit souvent qu’elle l’a <em class="italic">envouté</em> (<strong>Gbassé</strong>). Et dans la plupart des cas, c’est vrai !
                </p>

                <p class="text-base md:text-lg">
                    Mais aujourd’hui, le monde a évolué. Plus besoin d’aller acheter des “secrets” pour attirer ou garder un homme… Non. Il suffit parfois d’un bon sous-vêtement pour capter son regard et l’impressionner.
                </p>

                <p class="text-base md:text-lg">
                    Chez <strong class="text-rose-600 dark:text-rose-400">Soie Sexy</strong>, nous vous aidons à <em class="italic">vouter</em> n’importe quel homme sans Gbassé : juste avec des gestes simples, des mots doux et des sous-corps excitants qui révèlent votre vraie beauté.
                </p>

                <p class="text-base md:text-lg">
                    Nous ne faisons pas que vendre. Nous vous montrons aussi <strong>comment séduire sans parler</strong>, grâce à des astuces pratiques et naturelles.
                </p>

                <p class="text-base md:text-lg">
                    Avec <strong class="text-rose-600 dark:text-rose-400">Soie Sexy</strong>, restez toujours belle… <span class="font-semibold">même dans la cuisine</span>. 🔥✨
                </p>
            </div>
            <div class="mt-8 items-center flex justify-between mb-16">
                <a href="https://wa.me/2250798690325" target="_blank" class="items-center px-6 py-3 bg-orange-600 text-white rounded-lg shadow hover:bg-green-700">
                    <i class="fa-brands fa-whatsapp "></i> +225 0798690325
                </a>
                <div class="flex justify-center items-center space-x-4">
                    <a href="https://web.facebook.com/soiesexy" class="hover:text-orange-600" target="_blank"><i class="fa-brands fa-facebook fa-2x"></i></a>
                    <a href="https://www.instagram.com/soie_sexy7" class="hover:text-orange-600" target="_blank"><i class="fa-brands fa-instagram fa-2x"></i></a>
                    <a href="www.tiktok.com/@soiesexy" class="hover:text-orange-600" target="_blank"><i class="fa-brands fa-tiktok fa-2x"></i></a>
                </div>
            </div>
        </section>

    </div>
</template>

<style scoped>

</style>
