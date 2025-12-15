<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { Input } from '@/components/ui/input';
import { useI18n } from 'vue-i18n';
import { Package, Search, Plus, AlertTriangle, TrendingUp, Filter, Download } from 'lucide-vue-next';

const { t } = useI18n();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: t('dashboard.title'),
        href: '/dashboard',
    },
    {
        title: t('dashboard.sidebar.warehouse'),
        href: '#',
    },
    {
        title: t('dashboard.sidebar.inventory'),
        href: '/dashboard/warehouse/inventory',
    },
];

// Mock inventory data
const inventoryItems = [
    {
        id: 'PROD-001',
        name: 'Industrial Safety Helmet',
        sku: 'ISH-001',
        category: 'Safety Equipment',
        currentStock: 150,
        minStock: 20,
        maxStock: 500,
        unitPrice: 29.99,
        location: 'A-1-01',
        lastUpdated: '2024-01-15',
        status: 'in_stock',
        supplier: 'SafetyFirst Ltd'
    },
    {
        id: 'PROD-002',
        name: 'Steel Wire Rope 10mm',
        sku: 'SWR-10MM',
        category: 'Construction Materials',
        currentStock: 8,
        minStock: 15,
        maxStock: 200,
        unitPrice: 89.50,
        location: 'B-2-05',
        lastUpdated: '2024-01-14',
        status: 'low_stock',
        supplier: 'MetalWorks Inc'
    },
    {
        id: 'PROD-003',
        name: 'Hydraulic Jack 5T',
        sku: 'HJ-5T',
        category: 'Tools',
        currentStock: 0,
        minStock: 5,
        maxStock: 50,
        unitPrice: 299.99,
        location: 'C-1-12',
        lastUpdated: '2024-01-13',
        status: 'out_of_stock',
        supplier: 'ToolMaster Co'
    },
    {
        id: 'PROD-004',
        name: 'LED Work Light 50W',
        sku: 'LWL-50W',
        category: 'Lighting',
        currentStock: 75,
        minStock: 10,
        maxStock: 300,
        unitPrice: 45.00,
        location: 'D-3-08',
        lastUpdated: '2024-01-15',
        status: 'in_stock',
        supplier: 'BrightTech Ltd'
    },
    {
        id: 'PROD-005',
        name: 'Polyethylene Sheeting 4x6m',
        sku: 'PES-4X6',
        category: 'Protective Materials',
        currentStock: 12,
        minStock: 20,
        maxStock: 100,
        unitPrice: 15.75,
        location: 'E-1-03',
        lastUpdated: '2024-01-12',
        status: 'low_stock',
        supplier: 'PlasticPro Inc'
    }
];

const getStatusColor = (status: string) => {
    switch (status) {
        case 'in_stock':
            return 'bg-green-100 text-green-800';
        case 'low_stock':
            return 'bg-orange-100 text-orange-800';
        case 'out_of_stock':
            return 'bg-red-100 text-red-800';
        default:
            return 'bg-gray-100 text-gray-800';
    }
};

const getStatusText = (status: string) => {
    switch (status) {
        case 'in_stock':
            return 'In Stock';
        case 'low_stock':
            return 'Low Stock';
        case 'out_of_stock':
            return 'Out of Stock';
        default:
            return 'Unknown';
    }
};

const totalValue = inventoryItems.reduce((sum, item) => sum + (item.currentStock * item.unitPrice), 0);
const lowStockCount = inventoryItems.filter(item => item.status === 'low_stock').length;
const outOfStockCount = inventoryItems.filter(item => item.status === 'out_of_stock').length;
</script>

<template>
    <Head :title="t('dashboard.warehouse.inventory_title')" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight">{{ t('dashboard.warehouse.inventory_title') }}</h1>
                    <p class="text-muted-foreground">Monitor and manage your warehouse inventory</p>
                </div>
                <div class="flex items-center space-x-2">
                    <Button variant="outline" size="sm">
                        <Download class="h-4 w-4 mr-2" />
                        {{ t('common.export') }}
                    </Button>
                    <Button size="sm">
                        <Plus class="h-4 w-4 mr-2" />
                        {{ t('common.add') }} Item
                    </Button>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid gap-4 md:grid-cols-4">
                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">Total Items</CardTitle>
                        <Package class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">{{ inventoryItems.length }}</div>
                        <p class="text-xs text-muted-foreground">Unique products</p>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">Total Value</CardTitle>
                        <TrendingUp class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">${{ totalValue.toLocaleString() }}</div>
                        <p class="text-xs text-muted-foreground">Inventory worth</p>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">{{ t('dashboard.warehouse.low_stock') }}</CardTitle>
                        <AlertTriangle class="h-4 w-4 text-orange-500" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">{{ lowStockCount }}</div>
                        <p class="text-xs text-muted-foreground">Items need reorder</p>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">Out of Stock</CardTitle>
                        <AlertTriangle class="h-4 w-4 text-red-500" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">{{ outOfStockCount }}</div>
                        <p class="text-xs text-muted-foreground">Items unavailable</p>
                    </CardContent>
                </Card>
            </div>

            <!-- Search and Filters -->
            <Card>
                <CardHeader>
                    <CardTitle>Inventory Items</CardTitle>
                    <CardDescription>View and manage your warehouse inventory</CardDescription>
                </CardHeader>
                <CardContent>
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="relative flex-1">
                            <Search class="absolute left-3 top-3 h-4 w-4 text-muted-foreground" />
                            <Input placeholder="Search items by name, SKU, or category..." class="pl-10" />
                        </div>
                        <Button variant="outline" size="sm">
                            <Filter class="h-4 w-4 mr-2" />
                            {{ t('common.filter') }}
                        </Button>
                    </div>

                    <!-- Inventory Table -->
                    <div class="rounded-md border">
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="border-b bg-gray-50">
                                    <tr>
                                        <th class="text-left p-4 font-medium">Item</th>
                                        <th class="text-left p-4 font-medium">SKU</th>
                                        <th class="text-left p-4 font-medium">Category</th>
                                        <th class="text-left p-4 font-medium">{{ t('dashboard.warehouse.current_stock') }}</th>
                                        <th class="text-left p-4 font-medium">Location</th>
                                        <th class="text-left p-4 font-medium">Unit Price</th>
                                        <th class="text-left p-4 font-medium">Status</th>
                                        <th class="text-left p-4 font-medium">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in inventoryItems" :key="item.id" class="border-b hover:bg-gray-50">
                                        <td class="p-4">
                                            <div>
                                                <div class="font-medium">{{ item.name }}</div>
                                                <div class="text-xs text-muted-foreground">{{ item.supplier }}</div>
                                            </div>
                                        </td>
                                        <td class="p-4 font-mono text-sm">{{ item.sku }}</td>
                                        <td class="p-4">{{ item.category }}</td>
                                        <td class="p-4">
                                            <div class="flex items-center space-x-2">
                                                <span :class="item.currentStock <= item.minStock ? 'text-red-600 font-semibold' : ''">
                                                    {{ item.currentStock }}
                                                </span>
                                                <span class="text-xs text-muted-foreground">/ {{ item.maxStock }}</span>
                                            </div>
                                        </td>
                                        <td class="p-4 font-mono text-sm">{{ item.location }}</td>
                                        <td class="p-4">${{ item.unitPrice.toFixed(2) }}</td>
                                        <td class="p-4">
                                            <Badge variant="secondary" :class="getStatusColor(item.status)">
                                                {{ getStatusText(item.status) }}
                                            </Badge>
                                        </td>
                                        <td class="p-4">
                                            <div class="flex items-center space-x-2">
                                                <Button variant="outline" size="sm">
                                                    {{ t('common.edit') }}
                                                </Button>
                                                <Button variant="secondary" size="sm">
                                                    {{ t('common.view') }}
                                                </Button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-6 flex justify-between items-center">
                        <p class="text-sm text-muted-foreground">
                            Showing {{ inventoryItems.length }} of {{ inventoryItems.length }} items
                        </p>
                        <div class="flex items-center space-x-2">
                            <Button variant="outline" size="sm">
                                Previous
                            </Button>
                            <Button variant="outline" size="sm">
                                Next
                            </Button>
                        </div>
                    </div>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>