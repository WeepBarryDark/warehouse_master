<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import Heading from '@/components/Heading.vue';
import { useI18n } from 'vue-i18n';
import {
    ArrowLeft,
    Download,
    FileSpreadsheet,
    RefreshCw,
    Trash2,
    CheckCircle,
    Clock,
    AlertCircle,
    Package,
    DollarSign,
    Calendar,
    User,
} from 'lucide-vue-next';

const { t } = useI18n();

interface ShippingItem {
    id: number;
    model_number: string;
    product_name: string | null;
    category: string | null;
    quantity: number;
    unit_price: number | null;
    total_price: number | null;
    carton_quantity: number | null;
    gross_weight: number | null;
    net_weight: number | null;
    volume: number | null;
}

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
    notes: string | null;
    created_at: string;
    processed_at: string | null;
    user: {
        name: string;
        email: string;
    };
    items: ShippingItem[];
}

interface Props {
    document: ShippingDocument;
}

const props = defineProps<Props>();

const getStatusColor = (status: string) => {
    switch (status) {
        case 'processed':
            return 'bg-green-100 text-green-700 border-green-200';
        case 'pending':
            return 'bg-yellow-100 text-yellow-700 border-yellow-200';
        case 'failed':
            return 'bg-red-100 text-red-700 border-red-200';
        default:
            return 'bg-gray-100 text-gray-700 border-gray-200';
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
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    });
};

const downloadDocument = () => {
    router.get(route('dashboard.documents.download', props.document.id));
};

const parseDocument = () => {
    router.post(route('dashboard.documents.parse', props.document.id));
};

const deleteDocument = () => {
    if (confirm('Are you sure you want to delete this document?')) {
        router.delete(route('dashboard.documents.destroy', props.document.id));
    }
};
</script>

<template>
    <Head :title="`Document: ${props.document.file_name}`" />

    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <Button variant="outline" size="icon" as-child>
                    <Link :href="route('dashboard.documents')">
                        <ArrowLeft class="h-4 w-4" />
                    </Link>
                </Button>
                <Heading>Document Details</Heading>
            </div>
            <div class="flex gap-2">
                <Button
                    v-if="props.document.status === 'pending'"
                    variant="outline"
                    @click="parseDocument"
                >
                    <RefreshCw class="mr-2 h-4 w-4" />
                    Parse Document
                </Button>
                <Button variant="outline" @click="downloadDocument">
                    <Download class="mr-2 h-4 w-4" />
                    Download
                </Button>
                <Button variant="destructive" @click="deleteDocument">
                    <Trash2 class="mr-2 h-4 w-4" />
                    Delete
                </Button>
            </div>
        </div>

        <!-- Document Info -->
        <div class="grid gap-6 md:grid-cols-2">
            <Card>
                <CardHeader>
                    <CardTitle>Document Information</CardTitle>
                    <CardDescription>Basic details about the uploaded document</CardDescription>
                </CardHeader>
                <CardContent class="space-y-4">
                    <div class="flex items-center gap-3">
                        <FileSpreadsheet class="h-5 w-5 text-green-600" />
                        <div class="flex-1">
                            <p class="text-sm font-medium">{{ props.document.file_name }}</p>
                            <p class="text-xs text-muted-foreground">
                                {{ formatFileSize(props.document.file_size) }} • {{ props.document.file_type.toUpperCase() }}
                            </p>
                        </div>
                        <span
                            :class="['inline-flex items-center gap-1 rounded-full px-3 py-1 text-xs font-medium border', getStatusColor(props.document.status)]"
                        >
                            <component :is="getStatusIcon(props.document.status)" class="h-3 w-3" />
                            {{ props.document.status }}
                        </span>
                    </div>

                    <div class="grid gap-3">
                        <div class="flex items-start gap-3">
                            <Package class="h-4 w-4 mt-0.5 text-muted-foreground" />
                            <div class="flex-1">
                                <p class="text-xs text-muted-foreground">Order Number</p>
                                <p class="text-sm font-medium">{{ props.document.order_number || 'Not specified' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <Calendar class="h-4 w-4 mt-0.5 text-muted-foreground" />
                            <div class="flex-1">
                                <p class="text-xs text-muted-foreground">ETA Date</p>
                                <p class="text-sm font-medium">
                                    {{ props.document.eta_date ? new Date(props.document.eta_date).toLocaleDateString() : 'Not specified' }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <Package class="h-4 w-4 mt-0.5 text-muted-foreground" />
                            <div class="flex-1">
                                <p class="text-xs text-muted-foreground">Container Number</p>
                                <p class="text-sm font-medium">{{ props.document.container_number || 'Not specified' }}</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <User class="h-4 w-4 mt-0.5 text-muted-foreground" />
                            <div class="flex-1">
                                <p class="text-xs text-muted-foreground">Uploaded By</p>
                                <p class="text-sm font-medium">{{ props.document.user.name }}</p>
                                <p class="text-xs text-muted-foreground">{{ formatDate(props.document.created_at) }}</p>
                            </div>
                        </div>
                    </div>

                    <div v-if="props.document.notes" class="pt-3 border-t">
                        <p class="text-xs text-muted-foreground mb-1">Notes</p>
                        <p class="text-sm">{{ props.document.notes }}</p>
                    </div>
                </CardContent>
            </Card>

            <!-- Summary Stats -->
            <Card>
                <CardHeader>
                    <CardTitle>Summary</CardTitle>
                    <CardDescription>Document statistics and totals</CardDescription>
                </CardHeader>
                <CardContent class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="rounded-lg border p-4">
                            <div class="flex items-center gap-2 mb-2">
                                <Package class="h-4 w-4 text-muted-foreground" />
                                <p class="text-xs text-muted-foreground">Total Items</p>
                            </div>
                            <p class="text-2xl font-bold">{{ props.document.total_items }}</p>
                        </div>

                        <div class="rounded-lg border p-4">
                            <div class="flex items-center gap-2 mb-2">
                                <DollarSign class="h-4 w-4 text-muted-foreground" />
                                <p class="text-xs text-muted-foreground">Total Amount</p>
                            </div>
                            <p class="text-2xl font-bold">
                                {{ props.document.total_amount ? `$${props.document.total_amount.toFixed(2)}` : '-' }}
                            </p>
                        </div>
                    </div>

                    <div v-if="props.document.processed_at" class="rounded-lg bg-muted p-4">
                        <div class="flex items-center gap-2 mb-1">
                            <CheckCircle class="h-4 w-4 text-green-600" />
                            <p class="text-sm font-medium">Document Processed</p>
                        </div>
                        <p class="text-xs text-muted-foreground">{{ formatDate(props.document.processed_at) }}</p>
                    </div>

                    <div v-if="props.document.items.length > 0" class="space-y-2">
                        <p class="text-sm font-medium">Quick Stats</p>
                        <div class="text-xs text-muted-foreground space-y-1">
                            <p>Total Quantity: {{ props.document.items.reduce((sum, item) => sum + item.quantity, 0) }} units</p>
                            <p>Total Weight: {{ props.document.items.reduce((sum, item) => sum + (item.gross_weight || 0), 0).toFixed(2) }} kg</p>
                            <p>Total Volume: {{ props.document.items.reduce((sum, item) => sum + (item.volume || 0), 0).toFixed(3) }} m³</p>
                        </div>
                    </div>
                </CardContent>
            </Card>
        </div>

        <!-- Items Table -->
        <Card>
            <CardHeader>
                <CardTitle>Shipping Items ({{ props.document.items.length }})</CardTitle>
                <CardDescription>Detailed breakdown of items in this shipment</CardDescription>
            </CardHeader>
            <CardContent>
                <div v-if="props.document.items.length === 0" class="py-12 text-center text-muted-foreground">
                    <Package class="mx-auto h-12 w-12 mb-4 opacity-50" />
                    <p>No items found. This document hasn't been parsed yet.</p>
                    <Button class="mt-4" @click="parseDocument">
                        <RefreshCw class="mr-2 h-4 w-4" />
                        Parse Document Now
                    </Button>
                </div>

                <div v-else class="rounded-md border overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b bg-muted/50">
                                <th class="px-4 py-3 text-left text-sm font-medium">Model</th>
                                <th class="px-4 py-3 text-left text-sm font-medium">Product Name</th>
                                <th class="px-4 py-3 text-left text-sm font-medium">Category</th>
                                <th class="px-4 py-3 text-right text-sm font-medium">Qty</th>
                                <th class="px-4 py-3 text-right text-sm font-medium">Unit Price</th>
                                <th class="px-4 py-3 text-right text-sm font-medium">Total Price</th>
                                <th class="px-4 py-3 text-right text-sm font-medium">Cartons</th>
                                <th class="px-4 py-3 text-right text-sm font-medium">Weight (kg)</th>
                                <th class="px-4 py-3 text-right text-sm font-medium">Volume (m³)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in props.document.items" :key="item.id" class="border-b hover:bg-muted/50">
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center rounded-md bg-blue-100 px-2 py-1 text-xs font-medium text-blue-700">
                                        {{ item.model_number }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm">{{ item.product_name || '-' }}</td>
                                <td class="px-4 py-3 text-sm text-muted-foreground">{{ item.category || '-' }}</td>
                                <td class="px-4 py-3 text-right text-sm font-medium">{{ item.quantity }}</td>
                                <td class="px-4 py-3 text-right text-sm">
                                    {{ item.unit_price ? `$${item.unit_price.toFixed(2)}` : '-' }}
                                </td>
                                <td class="px-4 py-3 text-right text-sm font-medium">
                                    {{ item.total_price ? `$${item.total_price.toFixed(2)}` : '-' }}
                                </td>
                                <td class="px-4 py-3 text-right text-sm">{{ item.carton_quantity || '-' }}</td>
                                <td class="px-4 py-3 text-right text-sm">
                                    {{ item.gross_weight ? item.gross_weight.toFixed(2) : '-' }}
                                </td>
                                <td class="px-4 py-3 text-right text-sm">
                                    {{ item.volume ? item.volume.toFixed(3) : '-' }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </CardContent>
        </Card>
    </div>
</template>
