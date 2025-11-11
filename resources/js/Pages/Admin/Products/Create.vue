<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

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
    variants: [], // Array to hold variant data
    images: [], // Array to hold variant data
});

// Function to add a new empty variant row
const addVariantRow = () => {
    form.variants.push({
        taille_id: '',
        color_id: '',
        quantity: 0,
    });
};

// Function to remove a variant row
const removeVariantRow = (index) => {
    form.variants.splice(index, 1);
};

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

                            <!-- Product Variants Section -->
                            <div class="mt-6">
                                <h3 class="text-lg font-semibold mb-4">Product Variants</h3>
                                <div class="space-y-4">
                                    <div v-for="(variant, index) in form.variants" :key="index" class="flex items-end gap-4 p-4 border rounded-md bg-gray-50">
                                        <div>
                                            <InputLabel :for="`taille_id-${index}`" value="Size" />
                                            <select :id="`taille_id-${index}`" v-model="variant.taille_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                                <option value="" disabled>Select size</option>
                                                <option v-for="taille in tailles" :key="taille.id" :value="taille.id">{{ taille.name }}</option>
                                            </select>
                                            <InputError class="mt-2" :message="form.errors[`variants.${index}.taille_id`]"></InputError>
                                        </div>
                                        <div>
                                            <InputLabel :for="`color_id-${index}`" value="Color" />
                                            <select :id="`color_id-${index}`" v-model="variant.color_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                                <option value="" disabled>Select color</option>
                                                <option v-for="color in colors" :key="color.id" :value="color.id">{{ color.name }}</option>
                                            </select>
                                            <InputError class="mt-2" :message="form.errors[`variants.${index}.color_id`]"></InputError>
                                        </div>
                                        <div>
                                            <InputLabel :for="`quantity-${index}`" value="Quantity" />
                                            <TextInput :id="`quantity-${index}`" type="number" class="mt-1 block w-full" v-model="variant.quantity" required />
                                            <InputError class="mt-2" :message="form.errors[`variants.${index}.quantity`]"></InputError>
                                        </div>
                                        <button type="button" @click="removeVariantRow(index)" class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">Remove</button>
                                    </div>
                                </div>
                                <button type="button" @click="addVariantRow" class="mt-4 px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">Add Variant</button>
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
