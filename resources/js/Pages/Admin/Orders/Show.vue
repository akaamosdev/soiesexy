<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    order: Object,
});
</script>

<template>
    <Head :title="`Order #${order.id}`" />

    <AdminLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Order Details <span class="text-gray-500">#{{ order.id }}</span>
                </h2>
                <Link :href="route('orders.index')" class="text-sm text-blue-500 hover:underline">Back to Orders</Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200 grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Customer & Order Info -->
                        <div class="md:col-span-1">
                            <h3 class="text-lg font-semibold mb-4">Order Information</h3>
                            <div class="space-y-2 text-sm">
                                <p><strong>Customer:</strong> {{ order.user.name }}</p>
                                <p><strong>Email:</strong> {{ order.user.email }}</p>
                                <p><strong>Order Date:</strong> {{ new Date(order.created_at).toLocaleString() }}</p>
                                <p><strong>Total Amount:</strong> ${{ order.total_amount }}</p>
                                <p><strong>Payment Method:</strong> {{ order.payment_method }}</p>
                                
                                <p><strong>Order Status:</strong> <span class="font-medium capitalize">{{ order.status }}</span></p>
                            </div>
                        </div>

                        <!-- Shipping Address -->
                        <div class="md:col-span-1">
                            <h3 class="text-lg font-semibold mb-4">Shipping Address</h3>
                            <div v-if="order.address" class="space-y-1 text-sm">
                                <p>{{ order.address.full_name }}</p>
                                <p>{{ order.address.address_line_1 }}</p>
                                <p v-if="order.address.address_line_2">{{ order.address.address_line_2 }}</p>
                                <p>{{ order.address.city }}</p>
                                <p><strong>Phone:</strong> {{ order.address.phone_number }}</p>
                            </div>
                             <div v-else>
                                <p class="text-sm text-gray-500">No address provided.</p>
                            </div>
                        </div>
                    </div>

                     <!-- Order Items -->
                    <div class="p-6 bg-white border-t border-gray-200">
                         <h3 class="text-lg font-semibold mb-4">Order Items</h3>
                         <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Variant</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="item in order.items" :key="item.id">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ item.product_variant.product.name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ item.product_variant.taille.name }} / {{ item.product_variant.color.name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ item.quantity }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ item.price }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ (item.quantity * item.price).toFixed(2) }}</td>
                                </tr>
                            </tbody>
                         </table>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>