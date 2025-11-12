<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import CheckBoxMultple from "@/Components/CheckBoxMultple.vue";
import {onMounted} from "vue";

const props = defineProps({
    product: Object,
    categories: Array,
    tailles: Array,
    colors: Array,
});

// Main product form
const productForm = useForm({
    _method: 'PUT',
    name: props.product.name,
    price: props.product.price,
    category_id: props.product.category_id,
    description: props.product.description,
    taille_ids: props.product.tailles.map(taille => taille.id),
    color_ids: props.product.colors.map(color => color.id),
    images: [], // For new image uploads
    existing_image_ids: [], // IDs of images to keep
    existing_images: props.product.images.map(image => image.image_path),
});


onMounted(()=>{
    //console.log(props.product.tailles);
})

const submitProductForm = () => {
    productForm.post(route('products.update', props.product.id));
};


const handleImageChange = (e) => {
    productForm.images = e.target.files;
};

const removeExistingImage = (index,image_path) => {
    productForm.images = productForm.existing_images.splice(index,1);
    productForm.existing_image_ids.push(image_path);
};

</script>

<template>
    <Head :title="`Edit Product - ${product.name}`" />

    <AdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Product: {{ product.name }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <!-- Main Product Form -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-semibold mb-4">Product Details</h3>
                        <form @submit.prevent="submitProductForm" enctype="multipart/form-data">
                            <!-- Form fields for product details -->
                             <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <InputLabel for="name" value="Name" />
                                    <TextInput id="name" type="text" class="mt-1 block w-full" v-model="productForm.name" required autofocus />
                                    <InputError class="mt-2" :message="productForm.errors.name" />
                                </div>
                                <div>
                                    <InputLabel for="price" value="Price" />
                                    <TextInput id="price" type="number" step="0.01" class="mt-1 block w-full" v-model="productForm.price" required />
                                    <InputError class="mt-2" :message="productForm.errors.price" />
                                </div>
                                <div>
                                    <InputLabel for="category_id" value="Category" />
                                    <select id="category_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" v-model="productForm.category_id" required>
                                        <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                                    </select>
                                    <InputError class="mt-2" :message="productForm.errors.category_id" />
                                </div>
                                 <div class="">
                                     <InputLabel for="taille_ids" value="Taille disponibles" />
                                     <label v-for="taille in tailles" :key="taille.id">
                                         <CheckBoxMultple v-model="productForm.taille_ids" :value="taille.id" class="mx-3" />{{ taille.name}}
                                     </label>
                                 </div>
                            </div>
                            <div class="">
                                <InputLabel for="color_ids" value="Couleurs disponibles" />
                                <label v-for="col in colors" :key="col.id">
                                    <CheckBoxMultple v-model="productForm.color_ids" :value="col.id" class="mx-3" />{{ col.name}}
                                </label>
                            </div>
                            <div class="mt-4">
                                <InputLabel for="description" value="Description" />
                                <textarea id="description" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" v-model="productForm.description" rows="4"></textarea>
                                <InputError class="mt-2" :message="productForm.errors.description" />
                            </div>

                            <!-- Image Upload Section -->
                            <div class="mt-6">
                                <h4 class="font-medium mb-2">Product Images</h4>
                                <!-- Existing Images -->
                                <div v-if="productForm.existing_images.length > 0" class="mb-4 grid grid-cols-4 gap-4">
                                    <div v-for="(image,index) in productForm.existing_images" :key="index"  class="relative">
                                        <img :src="`/storage/${image}`" :alt="image" class="w-full h-32 object-cover rounded-md">
                                        <button type="button" @click="removeExistingImage(index,image)" class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 text-xs">X</button>
                                    </div>
                                </div>
                                <InputLabel for="new_images" value="Upload New Images" />
                                <input type="file" id="new_images" multiple @change="handleImageChange" class="mt-1 block w-full" />
                                <InputError class="mt-2" :message="productForm.errors.images" />
                                <InputError v-if="productForm.errors['images.0']" class="mt-2" :message="productForm.errors['images.0']" />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <PrimaryButton :class="{ 'opacity-25': productForm.processing }" :disabled="productForm.processing">
                                    Update Product Details
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </AdminLayout>
</template>
