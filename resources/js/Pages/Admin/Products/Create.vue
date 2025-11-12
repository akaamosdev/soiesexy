<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Checkbox from "@/Components/Checkbox.vue";
import CheckBoxMultple from "@/Components/CheckBoxMultple.vue";
import {watch} from "vue";

const props = defineProps({
    categories: Array,
    tailles: Array,
    colors: Array,
});

const form = useForm({
    name: '',
    price: '',
    category_id: '',
    description: '',
    taille_ids: [], // Array to hold variant data
    color_ids: [], // Array to hold variant data
    images: [], // Arr
});


const submit = () => {
    form.post(route('products.store'));
};
</script>

<template>
    <Head title="Create Product" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Product
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <!-- Main Product Form -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-semibold mb-4">Product Details</h3>
                        <form @submit.prevent="submit" enctype="multipart/form-data">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <InputLabel for="name" value="Name" />
                                    <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus />
                                    <InputError class="mt-2" :message="form.errors.name" />
                                </div>

                                <div>
                                    <InputLabel for="price" value="Price" />
                                    <TextInput id="price" type="number" step="0.01" class="mt-1 block w-full" v-model="form.price" required />
                                    <InputError class="mt-2" :message="form.errors.price" />
                                </div>

                                <div>
                                    <InputLabel for="category_id" value="Category" />
                                    <select id="category_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" v-model="form.category_id" required>
                                        <option value="" disabled>Select a category</option>
                                        <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                                    </select>
                                    <InputError class="mt-2" :message="form.errors.category_id" />
                                </div>
                                <div class="">
                                    <InputLabel for="taille_ids" value="Taille disponibles" />
                                    <label v-for="taille in tailles" :key="taille.id">
                                        <CheckBoxMultple v-model="form.taille_ids" :value="taille.id" class="mx-3" />{{ taille.name}}
                                    </label>
                                </div>

                            </div>
                            <div class="">
                                <InputLabel for="color_ids" value="Couleurs disponibles" />
                                <label v-for="col in colors" :key="col.id">
                                    <CheckBoxMultple v-model="form.color_ids" :value="col.id" class="mx-3" />{{ col.name}}
                                </label>
                            </div>

                            <div class="mt-4">
                                <InputLabel for="description" value="Description" />
                                <textarea id="description" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" v-model="form.description" rows="4"></textarea>
                                <InputError class="mt-2" :message="form.errors.description" />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="images" value="Product Images" />
                                <input type="file" id="images" multiple @change="form.images = $event.target.files" class="mt-1 block w-full" />
                                <InputError class="mt-2" :message="form.errors.images" />
                                <InputError v-if="form.errors['images.0']" class="mt-2" :message="form.errors['images.0']" />
                            </div>


                            <div class="flex items-center justify-end mt-4">
                                <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                    Create Product
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
