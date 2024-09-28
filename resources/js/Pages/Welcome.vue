<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});
</script>

<template>
    <Head title="Анализ ценных бумаг" />

    <div class="conteiner absolute top-0 w-[100%] min-h-screen h-auto
    fixed  bg-gradient-to-t from-red-800 to-gray-950">


        <div v-if="canLogin" class="sm:fixed sm:top-0 sm:right-0 p-6 text-end">
            <Link
                v-if="$page.props.auth.user"
                :href="route('dashboard')"
                class="font-semibold px-2 text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:shadow focus:shadow-md focus:rounded-sm focus:shadow-blue-400"
                >Панель управления</Link>
                <Link
                v-if="$page.props.auth.user"
                :href="route('hour-trade')"
                class="font-semibold px-2 text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:shadow focus:shadow-md focus:rounded-sm focus:shadow-blue-400"
                >Сделки за час</Link>

            <template v-else>
                <Link
                    :href="route('guestShares')"
                    class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                    >Акции </Link
                >
                <Link
                    :href="route('login')"
                    class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500"
                    >Логин</Link
                >
            </template>
        </div>
    </div>
</template>
