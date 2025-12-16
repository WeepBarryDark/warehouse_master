<script setup lang="ts">
import { Head, useForm } from '@inertiajs/vue3';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import Heading from '@/components/Heading.vue';
import { useI18n } from 'vue-i18n';
import { Upload, FileSpreadsheet, X, CheckCircle } from 'lucide-vue-next';
import { ref } from 'vue';

const { t } = useI18n();

const fileInput = ref<HTMLInputElement | null>(null);
const selectedFile = ref<File | null>(null);

const form = useForm({
    file: null as File | null,
    order_number: '',
    eta_date: '',
    container_number: '',
    notes: '',
    auto_parse: true,
});

const handleFileSelect = (event: Event) => {
    const target = event.target as HTMLInputElement;
    if (target.files && target.files[0]) {
        const file = target.files[0];
        selectedFile.value = file;
        form.file = file;
    }
};

const removeFile = () => {
    selectedFile.value = null;
    form.file = null;
    if (fileInput.value) {
        fileInput.value.value = '';
    }
};

const submit = () => {
    form.post(route('dashboard.documents.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            selectedFile.value = null;
        },
    });
};
</script>

<template>
    <Head title="Upload Shipping Document" />

    <div class="space-y-6">
        <Heading>Upload Shipping Document</Heading>

        <div class="grid gap-6 lg:grid-cols-3">
            <!-- Main Upload Card -->
            <Card class="lg:col-span-2">
                <CardHeader>
                    <CardTitle>Document Upload</CardTitle>
                    <CardDescription>Upload装柜装箱明细表 (Container Loading List)</CardDescription>
                </CardHeader>
                <CardContent>
                    <form @submit.prevent="submit" class="space-y-6">
                        <!-- File Upload Area -->
                        <div class="space-y-4">
                            <Label>Excel File *</Label>

                            <!-- Drop Zone -->
                            <div
                                v-if="!selectedFile"
                                class="flex flex-col items-center justify-center rounded-lg border-2 border-dashed border-muted-foreground/25 p-12 text-center hover:border-muted-foreground/50 transition-colors cursor-pointer"
                                @click="fileInput?.click()"
                            >
                                <Upload class="h-12 w-12 text-muted-foreground mb-4" />
                                <div class="space-y-2">
                                    <p class="text-sm font-medium">
                                        Click to upload or drag and drop
                                    </p>
                                    <p class="text-xs text-muted-foreground">
                                        Excel files (.xlsx, .xls, .csv) up to 10MB
                                    </p>
                                </div>
                                <input
                                    ref="fileInput"
                                    type="file"
                                    accept=".xlsx,.xls,.csv"
                                    class="hidden"
                                    @change="handleFileSelect"
                                />
                            </div>

                            <!-- Selected File Display -->
                            <div v-else class="rounded-lg border p-4 bg-muted/50">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="rounded-md bg-green-100 p-3">
                                            <FileSpreadsheet class="h-6 w-6 text-green-600" />
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium">{{ selectedFile.name }}</p>
                                            <p class="text-xs text-muted-foreground">
                                                {{ (selectedFile.size / 1024).toFixed(2) }} KB
                                            </p>
                                        </div>
                                    </div>
                                    <Button
                                        type="button"
                                        variant="ghost"
                                        size="sm"
                                        @click="removeFile"
                                    >
                                        <X class="h-4 w-4" />
                                    </Button>
                                </div>
                            </div>
                        </div>

                        <!-- Document Details -->
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="space-y-2">
                                <Label for="order_number">Order/Batch Number</Label>
                                <Input
                                    id="order_number"
                                    v-model="form.order_number"
                                    type="text"
                                    placeholder="e.g., LM250220-2C"
                                />
                                <p class="text-xs text-muted-foreground">订单号/批次号</p>
                            </div>

                            <div class="space-y-2">
                                <Label for="eta_date">ETA Date</Label>
                                <Input
                                    id="eta_date"
                                    v-model="form.eta_date"
                                    type="date"
                                />
                                <p class="text-xs text-muted-foreground">预计到达时间</p>
                            </div>

                            <div class="space-y-2 sm:col-span-2">
                                <Label for="container_number">Container Number</Label>
                                <Input
                                    id="container_number"
                                    v-model="form.container_number"
                                    type="text"
                                    placeholder="Container/柜号"
                                />
                            </div>

                            <div class="space-y-2 sm:col-span-2">
                                <Label for="notes">Notes</Label>
                                <textarea
                                    id="notes"
                                    v-model="form.notes"
                                    rows="3"
                                    class="flex w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 resize-none"
                                    placeholder="Additional notes..."
                                />
                            </div>
                        </div>

                        <!-- Auto Parse Option -->
                        <div class="flex items-center space-x-2">
                            <Checkbox
                                id="auto_parse"
                                :checked="form.auto_parse"
                                @update:checked="form.auto_parse = $event"
                            />
                            <Label
                                for="auto_parse"
                                class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70 cursor-pointer"
                            >
                                Automatically parse and import data after upload
                            </Label>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex justify-end gap-4">
                            <Button type="button" variant="outline" @click="form.reset()">
                                Reset
                            </Button>
                            <Button type="submit" :disabled="!selectedFile || form.processing">
                                <Upload class="mr-2 h-4 w-4" />
                                {{ form.processing ? 'Uploading...' : 'Upload Document' }}
                            </Button>
                        </div>
                    </form>
                </CardContent>
            </Card>

            <!-- Instructions Card -->
            <Card>
                <CardHeader>
                    <CardTitle>Instructions</CardTitle>
                    <CardDescription>文件上传说明</CardDescription>
                </CardHeader>
                <CardContent class="space-y-4">
                    <div class="space-y-2">
                        <h4 class="text-sm font-semibold flex items-center gap-2">
                            <CheckCircle class="h-4 w-4 text-green-600" />
                            Supported Models
                        </h4>
                        <div class="text-xs text-muted-foreground space-y-1">
                            <p>• ES Series: ES-01, ES-02, ES-03, ES-09</p>
                            <p>• EV Series: EV-01, EV-06, EV-07, EV-09</p>
                            <p>• AQUA Series: AQUA-003</p>
                            <p>• EC Series: EC03, EC04, EC13</p>
                            <p>• Moschino</p>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <h4 class="text-sm font-semibold">Expected Format</h4>
                        <div class="text-xs text-muted-foreground space-y-1">
                            <p><strong>Column A:</strong> Model Number (型号)</p>
                            <p><strong>Column B:</strong> Product Name (产品名称)</p>
                            <p><strong>Column C:</strong> Category (分类)</p>
                            <p><strong>Column D:</strong> Quantity (数量)</p>
                            <p><strong>Column E:</strong> Unit Price (单价)</p>
                            <p><strong>Column F:</strong> Carton Qty (箱数)</p>
                            <p><strong>Column G:</strong> Carton Number (箱号)</p>
                            <p><strong>Column H:</strong> Gross Weight (毛重)</p>
                            <p><strong>Column I:</strong> Net Weight (净重)</p>
                            <p><strong>Column J:</strong> Volume (体积)</p>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <h4 class="text-sm font-semibold">Requirements</h4>
                        <ul class="text-xs text-muted-foreground space-y-1 list-disc list-inside">
                            <li>First row should contain headers</li>
                            <li>Data starts from row 2</li>
                            <li>Model numbers must be valid</li>
                            <li>Maximum file size: 10MB</li>
                        </ul>
                    </div>
                </CardContent>
            </Card>
        </div>
    </div>
</template>
