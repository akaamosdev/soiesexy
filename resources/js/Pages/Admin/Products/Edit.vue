<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

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
    images: [], // For new image uploads
    existing_image_ids: props.product.images.map(image => image.id), // IDs of images to keep
});

// New variant form
const variantForm = useForm({
    taille_id: '',
    color_id: '',
    quantity: 0,
});

const submitProductForm = () => {
    productForm.post(route('products.update', props.product.id));
};

const addVariant = () => {
    variantForm.post(route('products.variants.store', props.product.id), {
        preserveScroll: true,
        onSuccess: () => variantForm.reset(),
    });
};

const updateVariantQuantity = (variantId, quantity) => {
    const form = useForm({ quantity });
    form.put(route('variants.update', variantId), {
        preserveScroll: true,
    });
};

const deleteVariant = (variantId) => {
    if (confirm('Are you sure you want to delete this variant?')) {
        const form = useForm({});
        form.delete(route('variants.destroy', variantId), {
            preserveScroll: true,
        });
    }
};

const handleImageChange = (e) => {
    productForm.images = e.target.files;
};

const removeExistingImage = (imageId) => {
    productForm.existing_image_ids = productForm.existing_image_ids.filter(id => id !== imageId);
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
                                <div v-if="product.images.length > 0" class="mb-4 grid grid-cols-4 gap-4">
                                    <div v-for="image in product.images" :key="image.id" class="relative">
                                        <img :src="`/storage/${image.image_path}`" :alt="image.alt_text" class="w-full h-32 object-cover rounded-md">
                                        <button type="button" @click="removeExistingImage(image.id)" class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 text-xs">X</button>
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

                <!-- Product Variants Management -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-semibold mb-4">Product Variants</h3>
                        <!-- Existing Variants -->
                        <div class="mb-6">
                            <h4 class="font-medium mb-2">Existing Variants</h4>
                            <div v-if="product.variants.length > 0" class="space-y-2">
                                <div v-for="variant in product.variants" :key="variant.id" class="flex items-center justify-between p-2 border rounded-md">
                                    <div>
                                        <span class="font-semibold">{{ variant.taille.name }} / {{ variant.color.name }}</span>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <TextInput type="number" class="w-24" :value="variant.quantity" @input="updateVariantQuantity(variant.id, $event.target.value)" />
                                        <button @click="deleteVariant(variant.id)" class="text-red-500 hover:text-red-700 font-semibold">Delete</button>
                                    </div>
                                </div>
                            </div>
                            <p v-else class="text-sm text-gray-500">No variants exist for this product yet.</p>
                        </div>

                        <!-- Add New Variant Form -->
                        <div>
                             <h4 class="font-medium mb-2">Add New Variant</h4>
                            <form @submit.prevent="addVariant" class="flex items-end gap-4 p-4 border rounded-md bg-gray-50">
                                <div>
                                    <InputLabel for="taille_id" value="Size" />
                                    <select id="taille_id" v-model="variantForm.taille_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                        <option value="" disabled>Select size</option>
                                        <option v-for="taille in tailles" :key="taille.id" :value="taille.id">{{ taille.name }}</option>
                                    </select>
                                     <InputError class="mt-2" :message="variantForm.errors.taille_id" />
                                </div>
                                <div>
                                    <InputLabel for="color_id" value="Color" />
                                    <select id="color_id" v-model="variantForm.color_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                        <option value="" disabled>Select color</option>
                                        <option v-for="color in colors" :key="color.id" :value="color.id">{{ color.name }}</option>
                                    </select>
                                    <InputError class="mt-2" :message="variantForm.errors.color_id" />
                                </div>
                                <div>
                                    <InputLabel for="quantity" value="Quantity" />
                                    <TextInput id="quantity" type="number" class="w-24" v-model="variantForm.quantity" required />
                                    <InputError class="mt-2" :message="variantForm.errors.quantity" />
                                </div>
                                <PrimaryButton :class="{ 'opacity-25': variantForm.processing }" :disabled="variantForm.processing">
                                    Add Variant
                                </PrimaryButton>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
