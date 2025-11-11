<script setup>
import {Head, Link} from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import {ref, computed, watch, onMounted} from 'vue';
import {showToast} from "@/helpers.js";

defineOptions({ layout: AppLayout });

const props = defineProps({
    product: Object,
});

const selectedTailleId = ref(null);
const selectedColorId = ref(null);
const inCart = ref(false);
const quantity = ref(1);
const mainImage = ref(props.product.images.length > 0 ? `/storage/${props.product.images[0].image_path}` : '/assets/img/no-image.jpg');

// Set initial selected variant if product has variants
// if (props.product.variants.length > 0) {
//     selectedTailleId.value = props.product.variants[0].taille_id;
//     selectedColorId.value = props.product.variants[0].color_id;
// }

const availableTailles = computed(() => {
    const tailles = new Set();
    props.product.variants.forEach(variant => {
        tailles.add(JSON.stringify({ id: variant.taille.id, name: variant.taille.name }));
    });
    return Array.from(tailles).map(t => JSON.parse(t));
});

const availableColors = computed(() => {
    const colors = new Set();
    props.product.variants.forEach(variant => {
        colors.add(JSON.stringify({ id: variant.color.id, name: variant.color.name, code: variant.color.code }));
    });
    return Array.from(colors).map(c => JSON.parse(c));
});

const selectedVariant = computed(() => {
    return props.product.variants.find(
        (variant) =>
            variant.taille_id === selectedTailleId.value &&
            variant.color_id === selectedColorId.value
    );
});

const displayedPrice = computed(() => {
    return selectedVariant.value ? selectedVariant.value.product.price : props.product.price;
});

const incrementQuantity = () => {
    quantity.value++;
    // if (selectedVariant.value && quantity.value < selectedVariant.value.quantity) {
    //     quantity.value++;
    // } else if (!selectedVariant.value) {
    //     quantity.value++; // Allow increment even without variant if no stock check
    // }
};

const decrementQuantity = () => {
    if (quantity.value > 1) {
        quantity.value--;
    }
};

const selectImage = (imagePath) => {
    mainImage.value = `/storage/${imagePath}`;
};

// Watch for changes in selected variant to update main image if needed
watch(selectedVariant, (newVariant) => {
    // if (newVariant && newVariant.product.images.length > 0) {
    //     mainImage.value = `/storage/${newVariant.product.images[0].image_path}`;
    // } else if (props.product.images.length > 0) {
    //     mainImage.value = `/storage/${props.product.images[0].image_path}`;
    // } else {
    //     mainImage.value = '/assets/img/no-image.jpg';
    // }
});
watch(selectedTailleId, (value) => {
    console.log(value);
})

// --- Cart Logic (LocalStorage) ---
const cart = ref(JSON.parse(localStorage.getItem('cart')) || {});

onMounted(() => {
    console.log(selectedTailleId);
});

const saveCart = () => {
    localStorage.setItem('cart', JSON.stringify(cart.value));
};

const addToCart = () => {
    if (!selectedVariant.value) {
        alert('Please select a size and color.');
        return;
    }
    if (selectedVariant.value.quantity === 0) {
        alert('This variant is out of stock.');
        return;
    }
    if (quantity.value > selectedVariant.value.quantity) {
        alert(`Only ${selectedVariant.value.quantity} items are available in stock.`);
        return;
    }

    const variantId = selectedVariant.value.id;
    const item = cart.value[variantId];

    if (item) {
        item.quantity += quantity.value;
    } else {
        cart.value[variantId] = {
            id: variantId,

            product_id: props.product.id,
            name: props.product.name,
            price: selectedVariant.value.product.price,
            image: props.product.images.length > 0 ? props.product.images[0].image_path : null,
            quantity: quantity.value,
        };
    }
    saveCart();
    showToast("Produit ajouté au panier avec succès");
};

// --- Wishlist Logic (LocalStorage) ---
const wishlist = ref(JSON.parse(localStorage.getItem('wishlist')) || {});

const saveWishlist = () => {
    localStorage.setItem('wishlist', JSON.stringify(wishlist.value));
};

const isInWishlist = (productId) => {
    return !!wishlist.value[productId];
};

const toggleWishlist = (product) => {
    if (isInWishlist(product.id)) {
        delete wishlist.value[product.id];
        alert(`${product.name} removed from wishlist!`);
    } else {
        wishlist.value[product.id] = {
            id: product.id,
            name: product.name,
            price: product.price,
            image: product.images.length > 0 ? product.images[0].image_path : null,
        };
        alert(`${product.name} added to wishlist!`);
    }
    saveWishlist();
};

// Watch for changes in localStorage from other tabs/windows
window.addEventListener('storage', (event) => {
    if (event.key === 'cart') {
        cart.value = JSON.parse(event.newValue || '{}');
    }
    if (event.key === 'wishlist') {
        wishlist.value = JSON.parse(event.newValue || '{}');
    }
});


</script>
<template>
    <Head :title="product.name" />
    <div class="relative">
        <div class="flex justify-between items-center p-2 border-b bg-white shadow-lg sticky top-0 z-10">
            <div class="flex items-center">
                <Link :href="route('home')" class="p-2 ">
                    <i class="fa-solid fa-arrow-left"></i>
                </Link>
                <h3 class="text-lg font-semibold">Détails</h3>
            </div>
            <div class=" flex justify-start text-lg">

            </div>
            <div class="">
                <Link class="bg-red-600 px-4 py-2 text-white rounded-md">Achater maintenant</Link>
            </div>
        </div>
        <div class="bg-rose-100 py-1 rounded-lg">
            <div class="wishlist absolute right-0 mr-3 mt-3 px-4 py-3 bg-red-100 rounded-full cursor-pointer" @click="toggleWishlist(product)">
                <i class="fa-regular fa-heart text-red-500" :class="{'fa-solid': isInWishlist(product.id)}"></i>
            </div>
            <img :src="mainImage" :alt="product.name" class="h-96 w-full object-cover rounded-es-xl rounded-ee-xl">

            <!-- Image Thumbnails -->
            <div v-if="product.images.length > 1" class="flex justify-center space-x-2 mt-4 px-3">
                <img v-for="image in product.images" :key="image.id" :src="`/storage/${image.image_path}`" :alt="image.alt_text"
                     class="w-16 h-16 object-cover rounded-md cursor-pointer border-2"
                     :class="{'border-amber-500': mainImage === `/storage/${image.image_path}`}"
                     @click="selectImage(image.image_path)">
            </div>
        </div>
        <div class="p-3">
            <hr>
<!--            <div class="flex justify-between">-->
<!--                <div class="">-->
<!--                    Commentaires-->
<!--                </div>-->
<!--                <div class=""><i class="fa-solid fa-star text-amber-400"></i>-->
<!--                    <span class="font-semibold">4.7</span>-->
<!--                    <span class="text-muted p-2">(515)</span></div>-->
<!--            </div>-->
            <h2 class="font-semibold text-xl">
                {{ product.name }}
            </h2>
            <div class="flex mt-3 ">
                <div class="basis-3/6">
                    <h3 class="font-semibold text-lg uppercase">Prix : </h3>
                    <h2 class="font-semibold text-xl text-amber-600">{{ displayedPrice }} FCFA</h2>
                </div>
                <div class="basis-2/6">
                    <h3 class="font-semibold text-xl">Quantité : </h3>
                    <div class="flex justify-between w-full">
                        <button @click="decrementQuantity" class="px-3 py-0 rounded-full bg-amber-950 text-white font-semibold text-xl">-</button>
                        <span class=" text-xl">{{ quantity }}</span>
                        <button @click="incrementQuantity" class="px-2 py-0 rounded-full bg-amber-950 text-white font-semibold text-xl">+</button>
                    </div>
                </div>
            </div>
            <h2 class="font-semibold text-lg mt-6">
                Nos tailles disponibles
            </h2>
            <div class="flex mt-2 text-center items-center space-x-2">
                <label v-for="taille in availableTailles" :key="taille.id" :for="`size-${taille.id}`"
                       class="px-3 py-2 shadow-lg border rounded-full cursor-pointer"
                       :class="{'bg-amber-950 text-white': selectedTailleId === taille.id,
                        'bg-white text-black': selectedTailleId !== taille.id}">
                    <input type="radio" class="hidden" name="size" :id="`size-${taille.id}`" :value="taille.id" v-model="selectedTailleId">
                    {{ taille.name }}
                </label>
            </div>
            <h2 class="font-semibold text-lg mt-6">
                Nos couleurs disponibles
            </h2>
            <div class="flex mt-2 text-center items-center space-x-2">
                <label v-for="color in availableColors" :key="color.id" :for="`color-${color.id}`"
                       class="w-10 h-10 shadow-lg rounded-full flex items-center justify-center cursor-pointer"
                       :style="{ backgroundColor: color.code }"
                       :class="{'border-2 border-amber-500': selectedColorId === color.id}">
                    <input type="radio" class="hidden" name="color" :id="`color-${color.id}`" :value="color.id" v-model="selectedColorId">
                    <i v-if="selectedColorId === color.id" class="fa-solid fa-check text-white text-lg"></i>
                </label>
            </div>
            <h2 class="font-semibold text-lg mt-6">
                Description:
            </h2>
            <p class="mt-1">
                {{ product.description }}
            </p>
            <div class=" mt-6">
<!--                <div class="px-2 py-2 bg-white mb-4">-->
<!--                    <h2 class="font-semibold text-lg  ">-->
<!--                        Commentaires clients vérifiés-->
<!--                    </h2>-->
<!--                    <div class="flex items-center">-->
<!--                        <span class="px-2 border border-amber-200 text-amber-600">4.7/5</span>-->
<!--                        <span class="p-2">28 avis vérifiés</span>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="grid grid-cols-1 mt-2 gap-2">-->
<!--                    <div v-for="n in 5" class="bg-white p-2 rounded-md">-->
<!--                        <div class="flex justify-between">-->
<!--                            <div class="">-->
<!--                                <span>-->
<!--                                    <i class="fa-solid fa-star text-amber-400"></i>-->
<!--                                    <i class="fa-solid fa-star text-amber-400"></i>-->
<!--                                    <i class="fa-solid fa-star text-amber-400"></i>-->
<!--                                    <i class="fa-regular fa-star text-amber-400"></i>-->
<!--                                    <i class="fa-regular fa-star text-amber-400"></i>-->
<!--                                </span>-->
<!--                            </div>-->
<!--                            <div class="text-gray-500">-->
<!--                                28-08-2024-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <h4 class="font-semibold">Satisfait</h4>-->
<!--                        <p>-->
<!--                            Trop contente pour votre service-->
<!--                        </p>-->
<!--                        <div class="flex justify-between items-center mt-2">-->
<!--                            <div class="text-gray-500 italic">-->
<!--                                par Aka oi Aka-->
<!--                            </div>-->
<!--                            <div class="text-green-700 ">-->
<!--                                <i class="fa-regular fa-circle-check"></i>-->
<!--                                Achat vérifié-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
            </div>
        </div>
        <div class="fixed bottom-0 left-0 right-0 bg-white w-full h-16 pb-2 px-4  pt-2 mx-auto
    rounded-l-lg rounded-r-lg max-w-md  rounded-full  z-10">
            <div class="flex justify-between space-x-3">
                <button class=" basis-1/6 p-3 w-full text-green-600 border-green-600 border  text-center rounded-lg">
                    <i class="fa-brands fa-whatsapp"></i>
                </button>
                <button @click="addToCart" class="p-3 w-full text-white disabled:opacity-25 bg-amber-600 text-center rounded-lg"
                        :disabled="!selectedTailleId || !selectedColorId">
                    <i class="fa-solid fa-cart-plus"></i> Ajouter au panier
                </button>
            </div>
        </div>
        <div class="mb-4"></div>
    </div>
</template>

<style scoped>
/* Add any specific styles here if needed */
</style>
