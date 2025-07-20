<script setup lang="ts">
import { breadcrumbsData } from '@/composables/pages-data/breadcrumbs';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem, Project } from '@/types';
import { Head } from '@inertiajs/vue3';

interface Props {
    routeName: string;
    projects?: Project[];
}

const props = withDefaults(defineProps<Props>(), {
    status: '',
    projects: () => [],
});

const breadcrumbs: BreadcrumbItem[] = breadcrumbsData[props.routeName] || [];
</script>

<template>
    <Head :title="breadcrumbs.at(0)?.title" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            
        </div>
    </AppLayout>
</template>