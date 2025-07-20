<script setup lang="ts">
import { breadcrumbsData } from '@/composables/pages-data/breadcrumbs';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem, Dataset } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { PlusCircle } from 'lucide-vue-next';

interface Props {
    status?: string;
    routeName: string;
    datasets?: Dataset[];
}

const props = withDefaults(defineProps<Props>(), {
    status: '',
    datasets: () => [],
});

const breadcrumbs: BreadcrumbItem[] = breadcrumbsData[props.routeName] || [];

const datasetForm = useForm({
    csv_file: {},
});

const submitDatasetForm = () => {
    datasetForm.post(route('upload-csv'), {
        preserveScroll: true,
        forceFormData: true,
    });
};

const onFileChange = (event: Event) => {
    const file = (event.target as HTMLInputElement).files?.item(0);

    if (!file) return;

    datasetForm.csv_file = file;
    submitDatasetForm();
};
</script>

<template>
    <Head :title="breadcrumbs.at(0)?.title" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            <div v-if="status === 'dataset-uploaded'" class="mt-2 text-sm font-medium text-green-600">
                A new dataset has been successfully uploaded.
            </div>

            <div class="relative bg-muted rounded-md flex justify-center items-center cursor-pointer h-full w-full">
                <input type="file" accept="text/csv" @change="onFileChange" class="absolute top-0 left-0 h-full w-full rounded-md placeholder:hidden text-transparent cursor-pointer" />
                <PlusCircle class="size-7 text-primary" />
            </div>
        </div>
    </AppLayout>
</template>