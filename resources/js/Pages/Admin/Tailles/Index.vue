<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';

defineProps({
    tailles: Object,
});

const destroy = (id) => {
    if (confirm('Are you sure you want to delete this size?')) {
        router.delete(route('tailles.destroy', id));
    }
};
</script>

<template>
    <Head title="Sizes" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Sizes
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-end mb-4">
                    <Link :href="route('tailles.create')" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                        Create Size
                    </Link>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="taille in tailles.data" :key="taille.id">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ taille.name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <Link :href="route('tailles.edit', taille.id)" class="text-indigo-600 hover:text-indigo-900">Edit</Link>
                                    <button @click="destroy(taille.id)" class="ml-4 text-red-600 hover:text-red-900">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div class="mt-4 flex justify-between">
                    <Link v-if="tailles.prev_page_url" :href="tailles.prev_page_url" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                        Previous
                    </Link>
                    <div v-else></div>
                    <Link v-if="tailles.next_page_url" :href="tailles.next_page_url" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                        Next
                    </Link>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>