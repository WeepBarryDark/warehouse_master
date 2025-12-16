<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: t('dashboard.title'),
        href: '/dashboard',
    },
    {
        title: t('dashboard.sidebar.product_management'),
        href: '/dashboard/products',
    },
    {
        title: t('dashboard.sidebar.new_product'),
        href: '/dashboard/products/new',
    },
];

const form = useForm({
    name: '',
    sku: '',
    description: '',
    category: '',
    woodType: '',
    finish: '',
    grade: '',
    price: '',
    quantity: '',
    weight: '',
    dimensions: '',
    thickness: '',
});

const submit = () => {
    form.post(route('dashboard.products.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <Head :title="t('dashboard.sidebar.new_product')" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight">{{ t('dashboard.sidebar.new_product') }}</h1>
                    <p class="text-muted-foreground">Add a new wooden floor product to your inventory</p>
                </div>
            </div>

            <Card>
            <CardHeader>
                <CardTitle>Wooden Floor Product Information</CardTitle>
                <CardDescription>Add a new wooden floor product to your inventory</CardDescription>
            </CardHeader>
            <CardContent>
                <form @submit.prevent="submit" class="space-y-6">
                    <div class="grid gap-6 sm:grid-cols-2">
                        <div class="space-y-2">
                            <Label for="name">Floor Product Name *</Label>
                            <Input
                                id="name"
                                v-model="form.name"
                                type="text"
                                required
                                placeholder="e.g., Oak Natural Wide Plank"
                            />
                        </div>

                        <div class="space-y-2">
                            <Label for="sku">SKU *</Label>
                            <Input
                                id="sku"
                                v-model="form.sku"
                                type="text"
                                required
                                placeholder="e.g., FLOOR-OAK-001"
                            />
                        </div>

                        <div class="space-y-2 sm:col-span-2">
                            <Label for="description">Description</Label>
                            <Input
                                id="description"
                                v-model="form.description"
                                type="text"
                                placeholder="Product description"
                            />
                        </div>

                        <div class="space-y-2">
                            <Label for="category">Category</Label>
                            <Input
                                id="category"
                                v-model="form.category"
                                type="text"
                                placeholder="e.g., Solid Hardwood / Engineered / Laminate"
                            />
                        </div>

                        <div class="space-y-2">
                            <Label for="woodType">Wood Type</Label>
                            <Input
                                id="woodType"
                                v-model="form.woodType"
                                type="text"
                                placeholder="e.g., Oak / Maple / Walnut / Bamboo"
                            />
                        </div>

                        <div class="space-y-2">
                            <Label for="finish">Finish</Label>
                            <Input
                                id="finish"
                                v-model="form.finish"
                                type="text"
                                placeholder="e.g., Matte / Glossy / Semi-Gloss"
                            />
                        </div>

                        <div class="space-y-2">
                            <Label for="grade">Grade</Label>
                            <Input
                                id="grade"
                                v-model="form.grade"
                                type="text"
                                placeholder="e.g., A Grade / B Grade / Premium"
                            />
                        </div>

                        <div class="space-y-2">
                            <Label for="price">Price</Label>
                            <Input
                                id="price"
                                v-model="form.price"
                                type="number"
                                step="0.01"
                                placeholder="0.00"
                            />
                        </div>

                        <div class="space-y-2">
                            <Label for="quantity">Initial Quantity</Label>
                            <Input
                                id="quantity"
                                v-model="form.quantity"
                                type="number"
                                placeholder="0"
                            />
                        </div>

                        <div class="space-y-2">
                            <Label for="thickness">Thickness (mm)</Label>
                            <Input
                                id="thickness"
                                v-model="form.thickness"
                                type="number"
                                step="0.1"
                                placeholder="e.g., 12 / 15 / 18"
                            />
                        </div>

                        <div class="space-y-2">
                            <Label for="weight">Weight per sqm (kg)</Label>
                            <Input
                                id="weight"
                                v-model="form.weight"
                                type="number"
                                step="0.01"
                                placeholder="e.g., 8.5"
                            />
                        </div>

                        <div class="space-y-2 sm:col-span-2">
                            <Label for="dimensions">Dimensions (Length x Width mm)</Label>
                            <Input
                                id="dimensions"
                                v-model="form.dimensions"
                                type="text"
                                placeholder="e.g., 1200 x 150 / 1820 x 190"
                            />
                        </div>
                    </div>

                    <div class="flex justify-end gap-4">
                        <Button type="button" variant="outline" @click="form.reset()">
                            Reset
                        </Button>
                        <Button type="submit" :disabled="form.processing">
                            {{ form.processing ? 'Adding...' : 'Add Floor Product' }}
                        </Button>
                    </div>
                </form>
            </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
