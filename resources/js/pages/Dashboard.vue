<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import { PlusCircle } from 'lucide-vue-next';

interface Props {
    status?: string;
}

defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

const uploadDatasetForm = useForm({
    csv_file: {},
});

const submitForm = () => {
    uploadDatasetForm.post(route('upload-csv'), {
        preserveScroll: true,
        forceFormData: true,
    })
};

const onFileChange = (event: Event) => {
    const file = (event.target as HTMLInputElement).files?.item(0);
    if (!file) return;

    uploadDatasetForm.csv_file = file;

    if (!uploadDatasetForm.csv_file) return;

    submitForm();
};
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <div class="relative bg-muted rounded-md flex justify-center items-center cursor-pointer h-full w-full">
                        <input type="file" accept="text/csv" @change="onFileChange" class="absolute top-0 left-0 h-full w-full rounded-md placeholder:hidden text-transparent cursor-pointer" />
                        <PlusCircle class="size-7 text-primary" />
                    </div>
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                    <div v-if="status === 'dataset-uploaded'" class="mt-2 text-sm font-medium text-green-600">
                        A new dataset has been successfully uploaded.
                    </div>
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
            </div>
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <PlaceholderPattern />
            </div>
        </div>
    </AppLayout>
</template>
