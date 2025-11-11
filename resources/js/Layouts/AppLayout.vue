<template>
    <div class="max-w-md rounded-md w-full mx-auto  z-10 h-screen bg-slate-50 overflow-y-scroll  relative">
        <ToastC />
        <div class="bg-white shadow-xl  border-2 p-1 rounded-md">

            <slot />
        </div>
        <Footer />
    </div>
</template>

<script>
import Footer from "@/Layouts/Footer.vue";
import ToastC from "@/Components/ToastC.vue";
export default {
    name: "AppLayout",
    components: {ToastC, Footer}
}
</script>

<style scoped>

</style>
