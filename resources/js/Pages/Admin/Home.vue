<template>
    <Head title="Tableau de bord admin" />
    <div class="">
        <h3 class="">Hello i am logged in</h3>
    </div>
</template>

<script setup>
    import AdminLayout from "@/Layouts/AdminLayout.vue";
    import {Head} from "@inertiajs/vue3";
    import {computed} from "vue";
    computed(()=>{
        alert('ok');
    })
    defineOptions({layout:AdminLayout})
</script>

<style scoped>

</style>
