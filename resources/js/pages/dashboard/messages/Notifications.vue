<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { useI18n } from 'vue-i18n';
import { Bell, AlertTriangle, Package, ShoppingCart, CheckCircle, X, Clock } from 'lucide-vue-next';

const { t } = useI18n();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: t('dashboard.title'),
        href: '/dashboard',
    },
    {
        title: t('dashboard.sidebar.messages'),
        href: '/dashboard/messages',
    },
    {
        title: t('dashboard.sidebar.notifications'),
        href: '/dashboard/messages/notifications',
    },
];

// Mock data - In a real app, this would come from props/API
const notifications = [
    {
        id: 1,
        type: 'warning',
        title: 'Low Stock Alert',
        message: 'Product ABC123 is running low on stock. Current level: 5 units remaining.',
        timestamp: '5 minutes ago',
        read: false,
        priority: 'high'
    },
    {
        id: 2,
        type: 'success',
        title: 'Order Completed',
        message: 'Order #ORD-2024-001 has been successfully processed and shipped.',
        timestamp: '15 minutes ago',
        read: false,
        priority: 'medium'
    },
    {
        id: 3,
        type: 'info',
        title: 'Inventory Update',
        message: 'Weekly inventory count has been completed for Warehouse A.',
        timestamp: '1 hour ago',
        read: true,
        priority: 'low'
    },
    {
        id: 4,
        type: 'warning',
        title: 'System Maintenance',
        message: 'Scheduled maintenance will occur tonight from 2:00 AM to 4:00 AM UTC.',
        timestamp: '2 hours ago',
        read: false,
        priority: 'medium'
    },
    {
        id: 5,
        type: 'error',
        title: 'Failed Import',
        message: 'CSV import failed for file "inventory_update.csv". Please check the file format.',
        timestamp: '3 hours ago',
        read: true,
        priority: 'high'
    }
];

const getNotificationIcon = (type: string) => {
    switch (type) {
        case 'warning':
            return AlertTriangle;
        case 'success':
            return CheckCircle;
        case 'error':
            return X;
        case 'info':
        default:
            return Bell;
    }
};

const getNotificationColor = (type: string) => {
    switch (type) {
        case 'warning':
            return 'text-orange-500';
        case 'success':
            return 'text-green-500';
        case 'error':
            return 'text-red-500';
        case 'info':
        default:
            return 'text-blue-500';
    }
};

const getPriorityColor = (priority: string) => {
    switch (priority) {
        case 'high':
            return 'bg-red-100 text-red-800';
        case 'medium':
            return 'bg-orange-100 text-orange-800';
        case 'low':
        default:
            return 'bg-gray-100 text-gray-800';
    }
};
</script>

<template>
    <Head :title="t('dashboard.sidebar.notifications')" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight">{{ t('dashboard.sidebar.notifications') }}</h1>
                    <p class="text-muted-foreground">Stay updated with system alerts and important messages</p>
                </div>
                <div class="flex items-center space-x-2">
                    <Button variant="outline" size="sm">
                        <CheckCircle class="h-4 w-4 mr-2" />
                        {{ t('dashboard.messages.mark_as_read') }}
                    </Button>
                    <Button variant="outline" size="sm">
                        <Bell class="h-4 w-4 mr-2" />
                        Settings
                    </Button>
                </div>
            </div>

            <!-- Notification Stats -->
            <div class="grid gap-4 md:grid-cols-4">
                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">Total</CardTitle>
                        <Bell class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">{{ notifications.length }}</div>
                        <p class="text-xs text-muted-foreground">All notifications</p>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">Unread</CardTitle>
                        <AlertTriangle class="h-4 w-4 text-orange-500" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">{{ notifications.filter(n => !n.read).length }}</div>
                        <p class="text-xs text-muted-foreground">Need attention</p>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">High Priority</CardTitle>
                        <X class="h-4 w-4 text-red-500" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">{{ notifications.filter(n => n.priority === 'high').length }}</div>
                        <p class="text-xs text-muted-foreground">Critical alerts</p>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">Recent</CardTitle>
                        <Clock class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">{{ notifications.filter(n => n.timestamp.includes('minute')).length }}</div>
                        <p class="text-xs text-muted-foreground">Last hour</p>
                    </CardContent>
                </Card>
            </div>

            <!-- Notifications List -->
            <Card>
                <CardHeader>
                    <CardTitle>Recent Notifications</CardTitle>
                    <CardDescription>Latest system alerts and updates</CardDescription>
                </CardHeader>
                <CardContent>
                    <div class="space-y-4">
                        <div v-if="notifications.length === 0" class="text-center py-8">
                            <Bell class="h-12 w-12 text-muted-foreground mx-auto mb-4" />
                            <p class="text-muted-foreground">No notifications yet</p>
                        </div>

                        <div 
                            v-for="notification in notifications" 
                            :key="notification.id" 
                            class="flex items-start space-x-4 p-4 rounded-lg border hover:bg-gray-50 transition-colors"
                            :class="!notification.read ? 'border-blue-200 bg-blue-50/50' : 'border-gray-200'"
                        >
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                                    <component 
                                        :is="getNotificationIcon(notification.type)" 
                                        :class="['h-5 w-5', getNotificationColor(notification.type)]" 
                                    />
                                </div>
                            </div>
                            
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="text-sm font-medium text-gray-900">{{ notification.title }}</h4>
                                    <div class="flex items-center space-x-2">
                                        <Badge 
                                            variant="secondary" 
                                            :class="getPriorityColor(notification.priority)"
                                        >
                                            {{ notification.priority.toUpperCase() }}
                                        </Badge>
                                        <Badge 
                                            v-if="!notification.read" 
                                            variant="secondary" 
                                            class="bg-blue-100 text-blue-800"
                                        >
                                            New
                                        </Badge>
                                        <span class="text-xs text-gray-500">{{ notification.timestamp }}</span>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600">{{ notification.message }}</p>
                            </div>

                            <div class="flex-shrink-0">
                                <Button variant="ghost" size="sm">
                                    <X class="h-4 w-4" />
                                </Button>
                            </div>
                        </div>
                    </div>

                    <div v-if="notifications.length > 0" class="mt-6 flex justify-center">
                        <Button variant="outline">Load More Notifications</Button>
                    </div>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>