<template>
    <div class=" ">
    <div class="flex p-4 my-3 justify-between items-center sticky top-0 shadow-md z-10 bg-white py-2">
        <h3 class="font-semibold text-xl">Liste des Articles</h3>
        <Link class="btn btn-primary" :href="route('art.create')">Ajouter article</Link>
    </div>
        <div class="overflow-y-auto h-auto  h-screen p-4">

            <table class="table-fixed w-full table">
                <!-- head -->
                <thead>
                <tr>
                    <th>N°</th>
                    <th>Name</th>
                    <th>Job</th>
                    <th>Favorite Color</th>
                </tr>
                </thead>
                <tbody>
                <!-- row 1 -->
                <tr v-for="n in 50">
                    <th>1</th>
                    <td>Cy Ganderton</td>
                    <td>Quality Control Specialist</td>
                    <td>Blue</td>
                </tr>
                <!-- row 2 -->
                <tr >
                    <th>2</th>
                    <td>Hart Hagerty</td>
                    <td>Desktop Support Technician</td>
                    <td>Purple</td>
                </tr>
                <!-- row 3 -->
                <tr >
                    <th>3</th>
                    <td>Brice Swyre</td>
                    <td>Tax Accountant</td>
                    <td>Red</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue"
import {Link} from "@inertiajs/vue3";
defineOptions({layout:AdminLayout})
</script>

<style scoped>

</style>
