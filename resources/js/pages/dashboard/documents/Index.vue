<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import Heading from '@/components/Heading.vue';
import { useI18n } from 'vue-i18n';
import { Upload, Search, Filter, FileSpreadsheet, Download, Eye, Trash2, Clock, CheckCircle, AlertCircle } from 'lucide-vue-next';
import { ref } from 'vue';

const { t } = useI18n();

interface ShippingDocument {
    id: number;
    order_number: string | null;
    eta_date: string | null;
    container_number: string | null;
    file_name: string;
    file_type: string;
    file_size: number;
    total_amount: number | null;
    total_items: number;
    status: string;
    created_at: string;
    user: {
        name: string;
    };
}

interface Props {
    documents: {
        data: ShippingDocument[];
        current_page: number;
        last_page: number;
        total: number;
    };
}

const props = defineProps<Props>();

const searchQuery = ref('');

const getStatusColor = (status: string) => {
    switch (status) {
        case 'processed':
            return 'bg-green-100 text-green-700';
        case 'pending':
            return 'bg-yellow-100 text-yellow-700';
        case 'failed':
            return 'bg-red-100 text-red-700';
        default:
            return 'bg-gray-100 text-gray-700';
    }
};

const getStatusIcon = (status: string) => {
    switch (status) {
        case 'processed':
            return CheckCircle;
        case 'pending':
            return Clock;
        case 'failed':
            return AlertCircle;
        default:
            return Clock;
    }
};

const formatFileSize = (bytes: number) => {
    if (bytes >= 1048576) {
        return (bytes / 1048576).toFixed(2) + ' MB';
    } else if (bytes >= 1024) {
        return (bytes / 1024).toFixed(2) + ' KB';
    }
    return bytes + ' bytes';
};

const formatDate = (date: string) => {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
    });
};

const downloadDocument = (documentId: number) => {
    router.get(route('dashboard.documents.download', documentId));
};

const deleteDocument = (documentId: number) => {
    if (confirm('Are you sure you want to delete this document?')) {
        router.delete(route('dashboard.documents.destroy', documentId));
    }
};
</script>

<template>
    <Head title="Shipping Documents" />

    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <Heading>Shipping Documents</Heading>
            <Button as-child>
                <Link :href="route('dashboard.documents.create')">
                    <Upload class="mr-2 h-4 w-4" />
                    Upload Document
                </Link>
            </Button>
        </div>

        <!-- Stats Cards -->
        <div class="grid gap-4 md:grid-cols-4">
            <Card>
                <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                    <CardTitle class="text-sm font-medium">Total Documents</CardTitle>
                    <FileSpreadsheet class="h-4 w-4 text-muted-foreground" />
                </CardHeader>
                <CardContent>
                    <div class="text-2xl font-bold">{{ props.documents.total }}</div>
                    <p class="text-xs text-muted-foreground">All uploaded files</p>
                </CardContent>
            </Card>

            <Card>
                <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                    <CardTitle class="text-sm font-medium">Processed</CardTitle>
                    <CheckCircle class="h-4 w-4 text-green-600" />
                </CardHeader>
                <CardContent>
                    <div class="text-2xl font-bold">
                        {{ props.documents.data.filter(d => d.status === 'processed').length }}
                    </div>
                    <p class="text-xs text-muted-foreground">Successfully parsed</p>
                </CardContent>
            </Card>

            <Card>
                <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                    <CardTitle class="text-sm font-medium">Pending</CardTitle>
                    <Clock class="h-4 w-4 text-yellow-600" />
                </CardHeader>
                <CardContent>
                    <div class="text-2xl font-bold">
                        {{ props.documents.data.filter(d => d.status === 'pending').length }}
                    </div>
                    <p class="text-xs text-muted-foreground">Awaiting processing</p>
                </CardContent>
            </Card>

            <Card>
                <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                    <CardTitle class="text-sm font-medium">Total Items</CardTitle>
                    <FileSpreadsheet class="h-4 w-4 text-muted-foreground" />
                </CardHeader>
                <CardContent>
                    <div class="text-2xl font-bold">
                        {{ props.documents.data.reduce((sum, d) => sum + d.total_items, 0) }}
                    </div>
                    <p class="text-xs text-muted-foreground">Across all documents</p>
                </CardContent>
            </Card>
        </div>

        <Card>
            <CardHeader>
                <CardTitle>All Documents</CardTitle>
                <CardDescription>Manage your shipping documents and loading lists</CardDescription>
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
                                placeholder="Search documents..."
                                class="pl-10"
                            />
                        </div>
                        <Button variant="outline">
                            <Filter class="mr-2 h-4 w-4" />
                            Filter
                        </Button>
                    </div>

                    <!-- Documents Table -->
                    <div class="rounded-md border">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b bg-muted/50">
                                    <th class="px-4 py-3 text-left text-sm font-medium">File Name</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium">Order Number</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium">ETA Date</th>
                                    <th class="px-4 py-3 text-right text-sm font-medium">Items</th>
                                    <th class="px-4 py-3 text-right text-sm font-medium">Total Amount</th>
                                    <th class="px-4 py-3 text-center text-sm font-medium">Status</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium">Uploaded</th>
                                    <th class="px-4 py-3 text-right text-sm font-medium">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="document in props.documents.data" :key="document.id" class="border-b hover:bg-muted/50">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-2">
                                            <FileSpreadsheet class="h-4 w-4 text-green-600" />
                                            <div>
                                                <p class="text-sm font-medium">{{ document.file_name }}</p>
                                                <p class="text-xs text-muted-foreground">{{ formatFileSize(document.file_size) }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        {{ document.order_number || '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        {{ document.eta_date ? formatDate(document.eta_date) : '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-right text-sm font-medium">
                                        {{ document.total_items }}
                                    </td>
                                    <td class="px-4 py-3 text-right text-sm">
                                        {{ document.total_amount ? `$${document.total_amount.toFixed(2)}` : '-' }}
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <span
                                            :class="['inline-flex items-center gap-1 rounded-full px-2 py-1 text-xs font-medium', getStatusColor(document.status)]"
                                        >
                                            <component :is="getStatusIcon(document.status)" class="h-3 w-3" />
                                            {{ document.status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-muted-foreground">
                                        {{ formatDate(document.created_at) }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex justify-end gap-2">
                                            <Button variant="ghost" size="sm" as-child>
                                                <Link :href="route('dashboard.documents.show', document.id)">
                                                    <Eye class="h-4 w-4" />
                                                </Link>
                                            </Button>
                                            <Button
                                                variant="ghost"
                                                size="sm"
                                                @click="downloadDocument(document.id)"
                                            >
                                                <Download class="h-4 w-4" />
                                            </Button>
                                            <Button
                                                variant="ghost"
                                                size="sm"
                                                @click="deleteDocument(document.id)"
                                            >
                                                <Trash2 class="h-4 w-4 text-red-600" />
                                            </Button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div v-if="props.documents.data.length === 0" class="py-12 text-center text-muted-foreground">
                        <FileSpreadsheet class="mx-auto h-12 w-12 mb-4 opacity-50" />
                        <p>No documents found. Upload your first shipping document to get started.</p>
                        <Button as-child class="mt-4">
                            <Link :href="route('dashboard.documents.create')">
                                <Upload class="mr-2 h-4 w-4" />
                                Upload Document
                            </Link>
                        </Button>
                    </div>
                </div>
            </CardContent>
        </Card>
    </div>
</template>
