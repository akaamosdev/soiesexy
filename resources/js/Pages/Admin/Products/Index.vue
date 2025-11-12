<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

defineProps({
    products: Object,
});

const destroy = (id) => {
    if (confirm('Are you sure you want to delete this product?')) {
        router.delete(route('products.destroy', id));
    }
};
</script>

<template>
    <Head title="Products" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Products
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-end mb-4">
                    <Link :href="route('products.create')" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                        Create Product
                    </Link>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tailles</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Couleurs</th>
                                <th scope="col" class="relative text-gray-500 px-6 py-3">
                                    <span class="sr-only">Action</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="product in products.data" :key="product.id">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <img v-if="product.images.length > 0" :src="`/storage/${product.images[0].image_path}`" :alt="product.images[0].alt_text" class="h-10 w-10 object-cover rounded-full">
                                    <span v-else class="text-gray-400">No Image</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ product.name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ product.price }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap ">
                                    <div class="flex">
                                        <div v-for="taille in product.tailles" class="text-sm  text-gray-900 mr-2">{{ taille.name }}, </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex">
                                        <div v-for="color in product.colors" class="text-sm  text-gray-900 mr-2">{{ color.name }}, </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <Link :href="route('products.edit', product.id)" class="text-indigo-600 hover:text-indigo-900">Edit</Link>
                                    <button @click="destroy(product.id)" class="ml-4 text-red-600 hover:text-red-900">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                 <!-- Pagination -->
                <div class="mt-4 flex justify-between">
                    <Link v-if="products.prev_page_url" :href="products.prev_page_url" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                        Previous
                    </Link>
                    <div v-else></div>
                    <Link v-if="products.next_page_url" :href="products.next_page_url" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                        Next
                    </Link>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
