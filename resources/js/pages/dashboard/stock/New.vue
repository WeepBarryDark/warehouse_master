<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import { useI18n } from 'vue-i18n';
import { Upload } from 'lucide-vue-next';
import { ref } from 'vue';

const { t } = useI18n();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: t('dashboard.title'),
        href: '/dashboard',
    },
    {
        title: t('dashboard.sidebar.stock_management'),
        href: '/dashboard/stock',
    },
    {
        title: t('dashboard.sidebar.new_stock'),
        href: '/dashboard/stock/new',
    },
];

const form = useForm({
    product_id: '',
    quantity: '',
    location: '',
    batch_number: '',
    notes: '',
});

const fileInput = ref<HTMLInputElement | null>(null);
const selectedFile = ref<File | null>(null);

const handleFileUpload = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files[0]) {
        selectedFile.value = target.files[0];
    }
};

const submit = () => {
    form.post(route('dashboard.stock.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            selectedFile.value = null;
        },
    });
};
</script>

<template>
    <Head :title="t('dashboard.sidebar.new_stock')" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight">{{ t('dashboard.sidebar.new_stock') }}</h1>
                    <p class="text-muted-foreground">Add wooden floor product stock to your warehouse</p>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-2">
            <!-- Manual Entry -->
            <Card>
                <CardHeader>
                    <CardTitle>Add Floor Product Stock</CardTitle>
                    <CardDescription>Enter wooden floor product stock information manually</CardDescription>
                </CardHeader>
                <CardContent>
                    <form @submit.prevent="submit" class="space-y-4">
                        <div class="space-y-2">
                            <Label for="product_id">Floor Product SKU *</Label>
                            <Input
                                id="product_id"
                                v-model="form.product_id"
                                type="text"
                                required
                                placeholder="e.g., FLOOR-OAK-001"
                            />
                        </div>

                        <div class="space-y-2">
                            <Label for="quantity">Quantity (sqm) *</Label>
                            <Input
                                id="quantity"
                                v-model="form.quantity"
                                type="number"
                                required
                                placeholder="0"
                            />
                        </div>

                        <div class="space-y-2">
                            <Label for="location">Warehouse Location</Label>
                            <Input
                                id="location"
                                v-model="form.location"
                                type="text"
                                placeholder="e.g., Aisle 3, Shelf B"
                            />
                        </div>

                        <div class="space-y-2">
                            <Label for="batch_number">Batch Number</Label>
                            <Input
                                id="batch_number"
                                v-model="form.batch_number"
                                type="text"
                                placeholder="e.g., BATCH-2024-001"
                            />
                        </div>

                        <div class="space-y-2">
                            <Label for="notes">Notes</Label>
                            <Input
                                id="notes"
                                v-model="form.notes"
                                type="text"
                                placeholder="Additional information"
                            />
                        </div>

                        <div class="flex justify-end gap-4">
                            <Button type="button" variant="outline" @click="form.reset()">
                                Reset
                            </Button>
                            <Button type="submit" :disabled="form.processing">
                                {{ form.processing ? 'Adding...' : 'Add Stock' }}
                            </Button>
                        </div>
                    </form>
                </CardContent>
            </Card>

            <!-- Bulk Upload -->
            <Card>
                <CardHeader>
                    <CardTitle>Bulk Upload</CardTitle>
                    <CardDescription>Upload wooden floor product stock data from CSV or Excel file</CardDescription>
                </CardHeader>
                <CardContent class="space-y-6">
                    <div class="space-y-4">
                        <div
                            class="flex flex-col items-center justify-center rounded-lg border-2 border-dashed border-muted-foreground/25 p-12 text-center hover:border-muted-foreground/50 transition-colors cursor-pointer"
                            @click="fileInput?.click()"
                        >
                            <Upload class="h-12 w-12 text-muted-foreground mb-4" />
                            <div class="space-y-2">
                                <p class="text-sm font-medium">
                                    Click to upload or drag and drop
                                </p>
                                <p class="text-xs text-muted-foreground">
                                    CSV, XLSX files up to 10MB
                                </p>
                            </div>
                            <input
                                ref="fileInput"
                                type="file"
                                accept=".csv,.xlsx,.xls"
                                class="hidden"
                                @change="handleFileUpload"
                            />
                        </div>

                        <div v-if="selectedFile" class="rounded-lg border p-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="rounded-md bg-primary/10 p-2">
                                        <Upload class="h-4 w-4 text-primary" />
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium">{{ selectedFile.name }}</p>
                                        <p class="text-xs text-muted-foreground">
                                            {{ (selectedFile.size / 1024).toFixed(2) }} KB
                                        </p>
                                    </div>
                                </div>
                                <Button variant="ghost" size="sm" @click="selectedFile = null">
                                    Remove
                                </Button>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <p class="text-sm font-medium">File Requirements:</p>
                        <ul class="text-xs text-muted-foreground space-y-1 list-disc list-inside">
                            <li>Headers: SKU, Quantity (sqm), Location, Batch Number</li>
                            <li>Maximum 1000 rows per file</li>
                            <li>All floor products must exist in the system</li>
                        </ul>
                    </div>

                    <Button class="w-full" :disabled="!selectedFile">
                        <Upload class="mr-2 h-4 w-4" />
                        Upload Stock Data
                    </Button>
                </CardContent>
            </Card>
            </div>
        </div>
    </AppLayout>
</template>
