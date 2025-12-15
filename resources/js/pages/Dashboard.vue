<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { useI18n } from 'vue-i18n';
import { ShoppingCart, Package, Bell, TrendingUp, Users, AlertTriangle } from 'lucide-vue-next';

const { t } = useI18n();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: t('dashboard.title'),
        href: '/dashboard',
    },
];

// Mock data - In a real app, this would come from props/API
const stats = {
    totalOrders: 1247,
    pendingOrders: 23,
    inventoryItems: 5642,
    notifications: 8,
    lowStockItems: 12,
    monthlyGrowth: 12.5
};

const recentActivity = [
    { id: 1, action: 'New order #ORD-2024-001 received', time: '2 minutes ago', type: 'order' },
    { id: 2, action: 'Stock level warning for Product ABC123', time: '15 minutes ago', type: 'warning' },
    { id: 3, action: 'Invoice #INV-2024-045 generated', time: '1 hour ago', type: 'invoice' },
    { id: 4, action: 'Inventory updated for Warehouse A', time: '2 hours ago', type: 'inventory' },
];
</script>

<template>
    <Head :title="t('dashboard.title')" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-6">
            <!-- Welcome Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight">{{ t('dashboard.welcome') }}</h1>
                    <p class="text-muted-foreground">{{ new Date().toLocaleDateString($i18n.locale, { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }) }}</p>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">{{ t('dashboard.stats.total_orders') }}</CardTitle>
                        <ShoppingCart class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">{{ stats.totalOrders.toLocaleString() }}</div>
                        <p class="text-xs text-muted-foreground">
                            <TrendingUp class="inline h-3 w-3 mr-1" />
                            +{{ stats.monthlyGrowth }}% from last month
                        </p>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">{{ t('dashboard.stats.pending_orders') }}</CardTitle>
                        <AlertTriangle class="h-4 w-4 text-orange-500" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">{{ stats.pendingOrders }}</div>
                        <p class="text-xs text-muted-foreground">Require immediate attention</p>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">{{ t('dashboard.stats.inventory_items') }}</CardTitle>
                        <Package class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">{{ stats.inventoryItems.toLocaleString() }}</div>
                        <p class="text-xs text-muted-foreground">
                            <AlertTriangle class="inline h-3 w-3 mr-1 text-red-500" />
                            {{ stats.lowStockItems }} low stock items
                        </p>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">{{ t('dashboard.stats.notifications') }}</CardTitle>
                        <Bell class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">{{ stats.notifications }}</div>
                        <p class="text-xs text-muted-foreground">Unread notifications</p>
                    </CardContent>
                </Card>
            </div>

            <!-- Main Content Grid -->
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-7">
                <!-- Recent Activity -->
                <Card class="col-span-4">
                    <CardHeader>
                        <CardTitle>Recent Activity</CardTitle>
                        <CardDescription>Latest updates from your warehouse operations</CardDescription>
                    </CardHeader>
                    <CardContent>
                        <div class="space-y-4">
                            <div v-for="activity in recentActivity" :key="activity.id" class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <div :class="[
                                        'w-2 h-2 rounded-full mt-2',
                                        activity.type === 'order' ? 'bg-blue-500' :
                                        activity.type === 'warning' ? 'bg-orange-500' :
                                        activity.type === 'invoice' ? 'bg-green-500' :
                                        'bg-gray-500'
                                    ]"></div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">{{ activity.action }}</p>
                                    <p class="text-sm text-gray-500">{{ activity.time }}</p>
                                </div>
                            </div>
                        </div>
                    </CardContent>
                </Card>

                <!-- Quick Actions -->
                <Card class="col-span-3">
                    <CardHeader>
                        <CardTitle>Quick Actions</CardTitle>
                        <CardDescription>Common tasks and shortcuts</CardDescription>
                    </CardHeader>
                    <CardContent class="space-y-2">
                        <button class="w-full p-3 text-left rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                            <div class="flex items-center space-x-3">
                                <ShoppingCart class="h-5 w-5 text-blue-500" />
                                <div>
                                    <p class="font-medium">Create New Order</p>
                                    <p class="text-sm text-gray-500">Start a new customer order</p>
                                </div>
                            </div>
                        </button>
                        
                        <button class="w-full p-3 text-left rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                            <div class="flex items-center space-x-3">
                                <Package class="h-5 w-5 text-green-500" />
                                <div>
                                    <p class="font-medium">Update Inventory</p>
                                    <p class="text-sm text-gray-500">Adjust stock levels</p>
                                </div>
                            </div>
                        </button>
                        
                        <button class="w-full p-3 text-left rounded-lg border border-gray-200 hover:bg-gray-50 transition-colors">
                            <div class="flex items-center space-x-3">
                                <AlertTriangle class="h-5 w-5 text-orange-500" />
                                <div>
                                    <p class="font-medium">Review Alerts</p>
                                    <p class="text-sm text-gray-500">Check system notifications</p>
                                </div>
                            </div>
                        </button>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
