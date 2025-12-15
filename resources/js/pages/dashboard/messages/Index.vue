<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { useI18n } from 'vue-i18n';
import { MessageSquare, Bell, Clock, User } from 'lucide-vue-next';

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
];

// Mock data - In a real app, this would come from props/API
const messages = [
    {
        id: 1,
        subject: 'Order #ORD-2024-001 Status Update',
        sender: 'System',
        preview: 'Your order has been processed and is ready for shipment.',
        timestamp: '2 hours ago',
        unread: true,
        type: 'order'
    },
    {
        id: 2,
        subject: 'Weekly Inventory Report',
        sender: 'Warehouse Manager',
        preview: 'Please review the attached weekly inventory summary report.',
        timestamp: '1 day ago',
        unread: false,
        type: 'report'
    },
    {
        id: 3,
        subject: 'Low Stock Alert - Product ABC123',
        sender: 'Inventory System',
        preview: 'Product ABC123 is running low on stock. Current level: 5 units.',
        timestamp: '2 days ago',
        unread: true,
        type: 'alert'
    },
    {
        id: 4,
        subject: 'Invoice #INV-2024-045 Generated',
        sender: 'Billing System',
        preview: 'Invoice #INV-2024-045 has been generated and sent to customer.',
        timestamp: '3 days ago',
        unread: false,
        type: 'invoice'
    }
];
</script>

<template>
    <Head :title="t('dashboard.messages.title')" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight">{{ t('dashboard.messages.title') }}</h1>
                    <p class="text-muted-foreground">Manage your messages and notifications</p>
                </div>
                <div class="flex items-center space-x-2">
                    <Button variant="outline" size="sm">
                        <Bell class="h-4 w-4 mr-2" />
                        {{ t('dashboard.messages.notifications') }}
                    </Button>
                    <Button size="sm">
                        <MessageSquare class="h-4 w-4 mr-2" />
                        New Message
                    </Button>
                </div>
            </div>

            <!-- Message Stats -->
            <div class="grid gap-4 md:grid-cols-3">
                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">{{ t('dashboard.messages.all_messages') }}</CardTitle>
                        <MessageSquare class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">{{ messages.length }}</div>
                        <p class="text-xs text-muted-foreground">Total messages</p>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">{{ t('dashboard.messages.unread') }}</CardTitle>
                        <Bell class="h-4 w-4 text-orange-500" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">{{ messages.filter(m => m.unread).length }}</div>
                        <p class="text-xs text-muted-foreground">Unread messages</p>
                    </CardContent>
                </Card>

                <Card>
                    <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                        <CardTitle class="text-sm font-medium">Response Rate</CardTitle>
                        <Clock class="h-4 w-4 text-muted-foreground" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">< 2h</div>
                        <p class="text-xs text-muted-foreground">Average response time</p>
                    </CardContent>
                </Card>
            </div>

            <!-- Messages List -->
            <Card>
                <CardHeader>
                    <CardTitle>Recent Messages</CardTitle>
                    <CardDescription>Your latest messages and notifications</CardDescription>
                </CardHeader>
                <CardContent>
                    <div class="space-y-4">
                        <div v-if="messages.length === 0" class="text-center py-8">
                            <MessageSquare class="h-12 w-12 text-muted-foreground mx-auto mb-4" />
                            <p class="text-muted-foreground">{{ t('dashboard.messages.no_messages') }}</p>
                        </div>

                        <div 
                            v-for="message in messages" 
                            :key="message.id" 
                            class="flex items-start space-x-4 p-4 rounded-lg border hover:bg-gray-50 transition-colors cursor-pointer"
                            :class="message.unread ? 'border-blue-200 bg-blue-50/50' : 'border-gray-200'"
                        >
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                                    <User class="h-5 w-5 text-gray-500" />
                                </div>
                            </div>
                            
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between mb-1">
                                    <h4 class="text-sm font-medium text-gray-900 truncate">{{ message.subject }}</h4>
                                    <div class="flex items-center space-x-2">
                                        <Badge 
                                            v-if="message.unread" 
                                            variant="secondary" 
                                            class="bg-blue-100 text-blue-800"
                                        >
                                            New
                                        </Badge>
                                        <span class="text-xs text-gray-500">{{ message.timestamp }}</span>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600 mb-1">From: {{ message.sender }}</p>
                                <p class="text-sm text-gray-500 truncate">{{ message.preview }}</p>
                            </div>
                        </div>
                    </div>

                    <div v-if="messages.length > 0" class="mt-6 flex justify-center">
                        <Button variant="outline">Load More Messages</Button>
                    </div>
                </CardContent>
            </Card>
        </div>
    </AppLayout>
</template>