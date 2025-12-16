<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { useI18n } from 'vue-i18n';
import { PackagePlus, Search, Filter } from 'lucide-vue-next';
import { ref } from 'vue';

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
        title: t('dashboard.sidebar.product_list'),
        href: '/dashboard/products',
    },
];

interface Product {
    id: number;
    name: string;
    sku: string;
    category: string;
    woodType: string;
    finish: string;
    dimensions: string;
    thickness: number;
    price: number;
    quantity: number;
    status: string;
}

interface Props {
    products?: Product[];
}

const props = defineProps<Props>();

const searchQuery = ref('');

// Sample wooden floor products for demonstration
const sampleProducts: Product[] = props.products || [
    { id: 1, name: 'Oak Natural Wide Plank', sku: 'FLOOR-OAK-001', category: 'Solid Hardwood', woodType: 'Oak', finish: 'Matte', dimensions: '1820 x 190', thickness: 18, price: 89.99, quantity: 250, status: 'In Stock' },
    { id: 2, name: 'Maple Engineered Premium', sku: 'FLOOR-MPL-002', category: 'Engineered Wood', woodType: 'Maple', finish: 'Semi-Gloss', dimensions: '1200 x 150', thickness: 15, price: 65.99, quantity: 180, status: 'In Stock' },
    { id: 3, name: 'Walnut Classic Dark', sku: 'FLOOR-WNT-003', category: 'Solid Hardwood', woodType: 'Walnut', finish: 'Glossy', dimensions: '1820 x 150', thickness: 18, price: 125.50, quantity: 15, status: 'Low Stock' },
    { id: 4, name: 'Bamboo Natural Light', sku: 'FLOOR-BMB-004', category: 'Bamboo Flooring', woodType: 'Bamboo', finish: 'Matte', dimensions: '1200 x 140', thickness: 12, price: 52.99, quantity: 0, status: 'Out of Stock' },
    { id: 5, name: 'Oak Smoked Wide Plank', sku: 'FLOOR-OAK-005', category: 'Engineered Wood', woodType: 'Oak', finish: 'Matte', dimensions: '1820 x 190', thickness: 15, price: 95.00, quantity: 320, status: 'In Stock' },
];
</script>

<template>
    <Head :title="t('dashboard.sidebar.product_list')" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight">{{ t('dashboard.sidebar.product_list') }}</h1>
                    <p class="text-muted-foreground">Manage your wooden floor product inventory</p>
                </div>
                <Button as-child>
                    <Link :href="route('dashboard.products.new')">
                        <PackagePlus class="mr-2 h-4 w-4" />
                        {{ t('dashboard.sidebar.new_product') }}
                    </Link>
                </Button>
            </div>

            <Card>
            <CardHeader>
                <CardTitle>All Wooden Floor Products</CardTitle>
                <CardDescription>Manage your wooden floor product inventory</CardDescription>
            </CardHeader>
            <CardContent>
                <div class="space-y-4">
                    <!-- Search and Filter -->
                    <div class="flex gap-4">
                        <div class="relative flex-1">
                            <Search class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-muted-foreground" />
                            <Input
                                v-model="searchQuery"
                                type="search"
                                placeholder="Search floor products by name, SKU, wood type..."
                                class="pl-10"
                            />
                        </div>
                        <Button variant="outline">
                            <Filter class="mr-2 h-4 w-4" />
                            Filter
                        </Button>
                    </div>

                    <!-- Products Table -->
                    <div class="rounded-md border">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b bg-muted/50">
                                    <th class="px-4 py-3 text-left text-sm font-medium">Product Name</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium">SKU</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium">Wood Type</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium">Category</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium">Dimensions</th>
                                    <th class="px-4 py-3 text-right text-sm font-medium">Price/sqm</th>
                                    <th class="px-4 py-3 text-right text-sm font-medium">Qty (sqm)</th>
                                    <th class="px-4 py-3 text-center text-sm font-medium">Status</th>
                                    <th class="px-4 py-3 text-right text-sm font-medium">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="product in sampleProducts" :key="product.id" class="border-b hover:bg-muted/50">
                                    <td class="px-4 py-3 font-medium">{{ product.name }}</td>
                                    <td class="px-4 py-3 text-muted-foreground font-mono text-xs">{{ product.sku }}</td>
                                    <td class="px-4 py-3">{{ product.woodType }}</td>
                                    <td class="px-4 py-3 text-sm">{{ product.category }}</td>
                                    <td class="px-4 py-3 text-sm text-muted-foreground">{{ product.dimensions }}mm</td>
                                    <td class="px-4 py-3 text-right font-medium">${{ product.price.toFixed(2) }}</td>
                                    <td class="px-4 py-3 text-right">{{ product.quantity }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <span
                                            class="inline-flex rounded-full px-2 py-1 text-xs font-medium"
                                            :class="{
                                                'bg-green-100 text-green-700': product.status === 'In Stock',
                                                'bg-yellow-100 text-yellow-700': product.status === 'Low Stock',
                                                'bg-red-100 text-red-700': product.status === 'Out of Stock',
                                            }"
                                        >
                                            {{ product.status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <Button variant="ghost" size="sm">Edit</Button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div v-if="sampleProducts.length === 0" class="py-12 text-center text-muted-foreground">
                        No floor products found. Add your first wooden floor product to get started.
                    </div>
                </div>
            </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>
