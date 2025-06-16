<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import { computed, onMounted } from 'vue';
import { useStore } from 'vuex';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

const store = useStore();
const stats = computed(() => store.state.dashboard.stats);

onMounted(() => {
  store.dispatch('dashboard/fetchStats');
});

</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4 h-full">
                        <h2 class="text-sm text-gray-500 dark:text-gray-300">Total Pizzas</h2>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ stats.total_pizzas }}</p>
                    </div>
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4 h-full">
                        <h2 class="text-sm text-gray-500 dark:text-gray-300">Total Orders</h2>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ stats.total_orders }}</p>
                        </div>
                    </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4 h-full">
                        <h2 class="text-sm text-gray-500 dark:text-gray-300">Total Revenue</h2>
                        <p class="text-2xl font-bold text-green-600 dark:text-green-400">${{ stats.total_revenue }}</p>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
