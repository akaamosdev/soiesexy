<template>
  <div class="bg-white rounded-2xl text-center relative border border-slate-300">
    <div class="wishlist absolute right-0 px-2 py-1 bg-red-100 rounded-full cursor-pointer"
         @click="addToWishlist(product,wishlist)">
      <i class="fa-regular fa-heart text-red-500"
         :class="{'fa-solid': isInWishlist(product.id)}">
    </i>
    </div>
    <div class="img bg-white rounded-xl ">
      <Link :href="route('show', product.slug)" class="">
        <img v-if="product.images.length > 0" :src="`/storage/${product.images[0].image_path}`"
             :alt="product.images[0].alt_text" class="h-48 w-full object-cover rounded">
        <img v-else src="/assets/img/no-image.jpg" :alt="product.name" class="h-32 w-full object-cover rounded">
      </Link>
    </div>
    <h1 class="text-md font-semibold">{{ product.name.substring(0,21) }}</h1>
    <h1 class="text-md font-bold text-rose-600">{{ formatPrice(product.price) }} FCFA</h1>
      <h4 class="text-xs text-gray-800 line-through">{{ formatPrice(Number(product.price)+product.price*0.35) }} FCFA</h4>
<!--    <h4 class="">-->
<!--                <span>-->
<!--                <i class="fa-solid fa-star text-amber-400"></i>-->
<!--                <i class="fa-solid fa-star text-amber-400"></i>-->
<!--                <i class="fa-solid fa-star text-amber-400"></i>-->
<!--                <i class="fa-regular fa-star text-amber-400"></i>-->
<!--                <i class="fa-regular fa-star text-amber-400"></i>-->
<!--            <span class="text-slate-500">(2 avis)</span>-->
<!--            </span>-->
<!--    </h4>-->
    <button @click="openModal" class="w-full">
      <div class="px-2 py-1 mt-2 bg-slate-950 text-white w-full rounded-se-2xl rounded-es-2xl">
        <i class="fa-solid fa-cart-plus"></i> Ajouter au panier
      </div>
    </button>

      <dialog ref="modalRef" class="modal modal-bottom sm:modal-middle">
          <div class="modal-box p-3">
              <form method="dialog">
                  <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
              </form>
              <h1 class="text-left mb-2">{{ product.name}}</h1>
              <h3 class="text-left font-bold">Tailles</h3>
              <div class="grid grid-cols-5 gap-3">
                  <label v-for="taille in product.tailles" :for="`size-${product.id}-${taille.id}`"
                         class="px-1 py-1 border rounded-full cursor-pointer"
                         :class="{'bg-amber-950 text-white': selectedTailleId === taille.id,
                        'bg-white text-black': selectedTailleId !== taille.id}">
                      <input type="radio" class="hidden" name="size" :id="`size-${product.id}-${taille.id}`" :value="taille.id" v-model="selectedTailleId">
                      {{ taille.name }}
                  </label>
              </div>
              <div class="flex justify-between items-center">
                  <div class="basis-4/6">
                      <h3 class="font-bold text-left">Couleurs</h3>
                      <div class="flex mt-2 text-center items-center space-x-2 w-full">
                          <label v-for="color in product.colors" :key="color.id"  :for="`color-${product.id}-${color.id}`"
                                 class=" h-8 w-8 shadow-lg rounded-full cursor-pointer"
                                 :style="{ backgroundColor: color.code }"
                                 :class="{'border-2 border-amber-500': selectedColorId === color.id}">
                              <input type="radio" class="hidden" name="color"  :id="`color-${product.id}-${color.id}`" :value="color.id" v-model="selectedColorId">
                              <i v-if="selectedColorId === color.id" class="fa-solid fa-check text-white text-lg"></i>
                          </label>
                      </div>
                  </div>
                  <div class="basis-2/6">
                      <h3 class="font-semibold ">Qté</h3>
                      <div class="flex justify-between w-full">
                          <button @click="decrementQuantity" class="px-2 py-0 rounded-full bg-amber-950 text-white font-semibold text-md">-</button>
                          <span class=" text-md">{{ quantity }}</span>
                          <button @click="incrementQuantity" class="px-2 py-0 rounded-full bg-amber-950 text-white font-semibold text-md">+</button>
                      </div>
                  </div>
              </div>
              <div class="flex justify-between items-center space-x-4 mt-3">
                  <button :disabled="!selectedColorId || !selectedTailleId|| !quantity "
                          @click="buyNow"
                          class="border disabled:opacity-50 border-rose-600 basis-3/6 py-1 px-2 rounded">Acheter maintenant</button>
                  <button :disabled="!selectedTailleId || !selectedColorId || !quantity" @click="saveCart"
                          class="border disabled:opacity-50 bg-rose-600 text-white py-1 px-2 rounded
                           border-rose-600">Ajouter au panier</button>
              </div>
          </div>
      </dialog>
  </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import {onMounted, ref, watch} from 'vue';
import {addToCart, addToWishlist, formatPrice, getCart, getWishlist, showToast} from "@/helpers.js";

const props = defineProps({
    product: Object,
});
const selectedTailleId = ref(0);
const selectedColorId = ref(0);
const quantity = ref(1);
const modalRef = ref(null);

const cart = ref(getCart());
const wishlist = ref(getWishlist());

const incrementQuantity = () => {
    quantity.value++;
};
const isInWishlist = (productId) => {
  return  wishlist.value.find((item) => item.id === productId);
}
function openModal() {
    // s'assurer que l'élément existe avant appel
    if (modalRef.value) {
        modalRef.value.showModal();
        selectedTailleId.value = 0;
        selectedColorId.value = 0;
        quantity.value = 1;
    } else {
        console.warn('Modal element not found for product', props.product.id);
    }
}

function closeModal() {
    if (modalRef.value) modalRef.value.close();
}
const decrementQuantity = () => {
    if (quantity.value > 1) {
        quantity.value--;
    }
};
const saveCart = () => {
 var statut= addToCart(props.product,selectedTailleId,selectedColorId,quantity,cart);
 if (statut) {
     showToast("Produit ajouté au panier avec succès");
     closeModal();
 }
};
const buyNow = () => {
  saveCart();
  window.location.href = route('checkout');
}

window.addEventListener('storage', (event) => {
    if (event.key === 'cart') {
        cart.value = JSON.parse(event.newValue || '{}');
    }
    if (event.key === 'wishlist') {
        wishlist.value = JSON.parse(event.newValue || '{}');
    }
});


</script>

<style scoped>

</style>
