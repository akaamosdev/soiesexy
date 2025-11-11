<template>
    <div class="p-4 max-w-4xl bg-white">
        <div class="flex my-3 justify-between items-center shadow-md z-10  py-2">

            <h3 class="font-semibold text-xl"><span class="fa fa-arrow"></span>Création d'Articles</h3>
        </div>
        <div class="flex w-full justify-center mx-auto">
            <input type="file" ref="fileInput" class="hidden" accept="image/*" multiple @change="previewImage" />
            <div class="bg-gray-300 border border-primary border-dotted w-[20rem] p-12 text-center cursor-pointer rounded-lg" @click="triggerFileInputClick">
                <h3 class="font-semibold text-xl flex items-center justify-center">
                    <i class="fa-solid fa-cloud-arrow-up fa-2x"></i> <span class="ml-2">Images</span>
                </h3>
            </div>
        </div>
        <div class="grid grid-cols-5 gap-2 mt-4">
            <div class="relative border border-success rounded-md" v-for="(imge,index) in preview" :key="index">
                <img :src="imge" alt="Image produit" class="object-cover h-48 w-full">
                <span class="absolute px-2 py-1 rounded-full text-white shadow-2xl
                 z-10 cursor-pointer top-0 right-0 bg-red-800" @click="removePreview(index)"><i class="fa-regular fa-trash-can"></i></span>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-2 mt-4">
            <div class="">
                <label  class="font-semibold">Nom du produit</label>
                <input type="text" class="input w-full mt-1 bg-gray-300">
            </div>

            <div class="flex justify-between space-x-2">
               <div class="">
                   <label  class="font-semibold">Prix achat</label>
                   <input type="text" class="input w-full mt-1 bg-gray-300" v-model="form.price_buy">
               </div>
                <div class="">
                    <label  class="font-semibold">Prix Vente</label>
                    <input type="text" class="input w-full mt-1 bg-gray-300" v-model="form.price_seller">
                </div>
            </div>
            <div class="">
                <label  class="font-semibold">Categories</label>
                <select name="categorie" id="categorie" v-model="form.categorie_id" class="select w-full bg-gray-300 mt-1">
                    <option value="" selected disabled>Choisir</option>
                    <option :value="cat.id" :key="cat.id" v-for="cat in categories">{{ cat.name }}</option>
                </select>
            </div>
            <div class="">
                <label  class="font-semibold">Tailles</label>
                <select name="taille" id="taille" v-model="form.taille_id" class="select w-full bg-gray-300 mt-1">
                    <option value="" selected disabled>Choisir</option>
                    <option :value="tail.id" :key="tail.id" v-for="tail in tailles">{{ tail.name }}</option>
                </select>
            </div>
            <div class="">
                <label  class="font-semibold">Couleurs</label>
                <select name="color_id" id="color_id" v-model="form.color_id" class="select w-full bg-gray-300 mt-1">
                    <option value="" selected disabled>Choisir</option>
                    <option :value="color.id" :key="color.id" v-for="color in colors">{{ color.name }}</option>
                </select>
            </div>
        </div>
        <div class="">
            <label  class="font-semibold w-full">Description</label>
            <textarea name="description" v-model="form.description" id="description" class="w-full textarea
             bg-gray-300 focus:border-indigo-500" rows="10"></textarea>
        </div>
        <div class="flex justify-end mt-3">
            <button type="reset" class="btn btn-primary font-semibold ">
                <i class="fa-solid fa-floppy-disk"></i> Enregistrer
            </button>
        </div>
    </div>
</template>

<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue"
import {Link, useForm} from "@inertiajs/vue3";
import {ref} from "vue";
const fileInput=ref(null);
const preview=ref([]);
const form = useForm({
    avatar:[],
    categorie_id:null,
    color_id:null,
    taille_id:null,
    name:null,
    price_buy:null,
    price_seller:null,
    description:null,
});
function triggerFileInputClick() {
    // Trigger click on the file input element
    fileInput.value.click();
}
function previewImage(event) {
    var input = event.target;
    for (const inputKey of input.files) {
        if (inputKey) {
            var reader = new FileReader();
            reader.onload = (e) => {
                preview.value.push(e.target.result);
            }
            form.avatar.push(inputKey);
            reader.readAsDataURL(inputKey);
        }
    }
}
function removePreview(index) {
    preview.value.splice(index,1);
    form.avatar.splice(index,1);
}
defineProps({ categories:Array, tailles:Array, colors:Array })
defineOptions({layout:AdminLayout})
</script>

<style scoped>

</style>
