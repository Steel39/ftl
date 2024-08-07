<script setup>
import App from '@/App.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import LastTrades from '@/views/LastTrades.vue';
</script>

<template>
    <Head title="Сделки за час" />
    
    <AuthenticatedLayout>
        <template #header>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <LastTrades
                
            </LastTrades>
            </div>
        </div>
    </AuthenticatedLayout>
</template>