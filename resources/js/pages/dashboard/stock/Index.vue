<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { useI18n } from 'vue-i18n';
import { Upload, Search, Filter, ArrowUpDown } from 'lucide-vue-next';
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
        title: t('dashboard.sidebar.stock_list'),
        href: '/dashboard/stock',
    },
];

interface StockItem {
    id: number;
    product_name: string;
    sku: string;
    quantity: number;
    location: string;
    batch_number: string;
    last_updated: string;
}

interface Props {
    stock?: StockItem[];
}

const props = defineProps<Props>();

const searchQuery = ref('');

// Sample data for demonstration
const sampleStock: StockItem[] = props.stock || [
    { id: 1, product_name: 'Laptop Computer', sku: 'ELEC-001', quantity: 25, location: 'A1-B3', batch_number: 'BATCH-001', last_updated: '2024-01-15' },
    { id: 2, product_name: 'Office Chair', sku: 'FURN-001', quantity: 50, location: 'B2-C4', batch_number: 'BATCH-002', last_updated: '2024-01-14' },
    { id: 3, product_name: 'Wireless Mouse', sku: 'ELEC-002', quantity: 5, location: 'A1-B2', batch_number: 'BATCH-003', last_updated: '2024-01-13' },
    { id: 4, product_name: 'Desk Lamp', sku: 'FURN-002', quantity: 0, location: 'C1-D2', batch_number: 'BATCH-004', last_updated: '2024-01-12' },
];

const totalStock = sampleStock.reduce((sum, item) => sum + item.quantity, 0);
const lowStockCount = sampleStock.filter(item => item.quantity < 10).length;
</script>

<template>
    <Head :title="t('dashboard.sidebar.stock_list')" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight">{{ t('dashboard.sidebar.stock_list') }}</h1>
                    <p class="text-muted-foreground">Monitor and manage your warehouse inventory</p>
                </div>
                <Button as-child>
                    <Link :href="route('dashboard.stock.new')">
                        <Upload class="mr-2 h-4 w-4" />
                        {{ t('dashboard.sidebar.new_stock') }}
                    </Link>
                </Button>
            </div>

            <!-- Stats Cards -->
        <div class="grid gap-4 md:grid-cols-3">
            <Card>
                <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                    <CardTitle class="text-sm font-medium">Total Stock Items</CardTitle>
                </CardHeader>
                <CardContent>
                    <div class="text-2xl font-bold">{{ sampleStock.length }}</div>
                    <p class="text-xs text-muted-foreground">Unique products in stock</p>
                </CardContent>
            </Card>

            <Card>
                <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                    <CardTitle class="text-sm font-medium">Total Quantity</CardTitle>
                </CardHeader>
                <CardContent>
                    <div class="text-2xl font-bold">{{ totalStock }}</div>
                    <p class="text-xs text-muted-foreground">Units across all products</p>
                </CardContent>
            </Card>

            <Card>
                <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                    <CardTitle class="text-sm font-medium">Low Stock Alert</CardTitle>
                </CardHeader>
                <CardContent>
                    <div class="text-2xl font-bold text-yellow-600">{{ lowStockCount }}</div>
                    <p class="text-xs text-muted-foreground">Products below threshold</p>
                </CardContent>
            </Card>
        </div>

        <Card>
            <CardHeader>
                <CardTitle>Stock Records</CardTitle>
                <CardDescription>View and manage your warehouse stock levels</CardDescription>
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
                                placeholder="Search stock records..."
                                class="pl-10"
                            />
                        </div>
                        <Button variant="outline">
                            <Filter class="mr-2 h-4 w-4" />
                            Filter
                        </Button>
                        <Button variant="outline">
                            <ArrowUpDown class="mr-2 h-4 w-4" />
                            Sort
                        </Button>
                    </div>

                    <!-- Stock Table -->
                    <div class="rounded-md border">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b bg-muted/50">
                                    <th class="px-4 py-3 text-left text-sm font-medium">Product</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium">SKU</th>
                                    <th class="px-4 py-3 text-right text-sm font-medium">Quantity</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium">Location</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium">Batch</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium">Last Updated</th>
                                    <th class="px-4 py-3 text-right text-sm font-medium">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in sampleStock" :key="item.id" class="border-b">
                                    <td class="px-4 py-3">{{ item.product_name }}</td>
                                    <td class="px-4 py-3 text-muted-foreground">{{ item.sku }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <span
                                            :class="{
                                                'text-red-600 font-medium': item.quantity === 0,
                                                'text-yellow-600 font-medium': item.quantity > 0 && item.quantity < 10,
                                                'text-green-600 font-medium': item.quantity >= 10,
                                            }"
                                        >
                                            {{ item.quantity }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">{{ item.location }}</td>
                                    <td class="px-4 py-3 text-muted-foreground">{{ item.batch_number }}</td>
                                    <td class="px-4 py-3 text-muted-foreground">{{ item.last_updated }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <Button variant="ghost" size="sm">Adjust</Button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div v-if="sampleStock.length === 0" class="py-12 text-center text-muted-foreground">
                        No stock records found. Add stock to get started.
                    </div>
                </div>
            </CardContent>
        </Card>
        </div>
    </AppLayout>
</template>
