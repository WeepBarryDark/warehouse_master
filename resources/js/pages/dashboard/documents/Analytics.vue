<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import Heading from '@/components/Heading.vue';
import { useI18n } from 'vue-i18n';
import {
    TrendingUp,
    Package,
    DollarSign,
    FileSpreadsheet,
    BarChart3,
    PieChart,
    Calendar,
    Weight,
} from 'lucide-vue-next';
import { computed } from 'vue';
import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    BarElement,
    ArcElement,
    Title,
    Tooltip,
    Legend,
} from 'chart.js';
import { Bar, Doughnut, Line } from 'vue-chartjs';

// Register Chart.js components
ChartJS.register(
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    BarElement,
    ArcElement,
    Title,
    Tooltip,
    Legend
);

const { t } = useI18n();

interface ModelStat {
    model_number: string;
    count: number;
    total_quantity: number;
    total_value: number;
    total_weight: number;
    total_volume: number;
}

interface CategoryStat {
    category: string;
    count: number;
    total_quantity: number;
    total_value: number;
}

interface MonthlyTrend {
    month: number;
    document_count: number;
    items_count: number;
    total_value: number;
}

interface Props {
    stats: {
        totalDocuments: number;
        totalItems: number;
        totalValue: number;
    };
    modelStats: ModelStat[];
    categoryStats: CategoryStat[];
    recentDocuments: any[];
    monthlyTrend: MonthlyTrend[];
}

const props = defineProps<Props>();

// Chart colors
const chartColors = [
    'rgba(59, 130, 246, 0.8)',  // blue
    'rgba(16, 185, 129, 0.8)',  // green
    'rgba(251, 146, 60, 0.8)',  // orange
    'rgba(139, 92, 246, 0.8)',  // purple
    'rgba(236, 72, 153, 0.8)',  // pink
    'rgba(234, 179, 8, 0.8)',   // yellow
    'rgba(20, 184, 166, 0.8)',  // teal
    'rgba(244, 63, 94, 0.8)',   // rose
];

// Model quantity chart data
const modelQuantityChart = computed(() => {
    const top10 = props.modelStats.slice(0, 10);
    return {
        labels: top10.map(m => m.model_number),
        datasets: [{
            label: 'Quantity',
            data: top10.map(m => m.total_quantity),
            backgroundColor: chartColors,
            borderColor: chartColors.map(c => c.replace('0.8', '1')),
            borderWidth: 1,
        }]
    };
});

// Model value chart data
const modelValueChart = computed(() => {
    const top10 = props.modelStats.slice(0, 10);
    return {
        labels: top10.map(m => m.model_number),
        datasets: [{
            label: 'Total Value ($)',
            data: top10.map(m => Number(m.total_value) || 0),
            backgroundColor: 'rgba(16, 185, 129, 0.8)',
            borderColor: 'rgba(16, 185, 129, 1)',
            borderWidth: 1,
        }]
    };
});

// Category distribution chart
const categoryChart = computed(() => ({
    labels: props.categoryStats.map(c => c.category || 'Uncategorized'),
    datasets: [{
        data: props.categoryStats.map(c => c.total_quantity),
        backgroundColor: chartColors,
        borderColor: chartColors.map(c => c.replace('0.8', '1')),
        borderWidth: 2,
    }]
}));

// Monthly trend chart
const monthlyChart = computed(() => {
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    const allMonths = Array.from({length: 12}, (_, i) => i + 1);

    return {
        labels: allMonths.map(m => months[m - 1]),
        datasets: [
            {
                label: 'Documents',
                data: allMonths.map(m => {
                    const data = props.monthlyTrend.find(t => t.month === m);
                    return data ? data.document_count : 0;
                }),
                borderColor: 'rgba(59, 130, 246, 1)',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.4,
            },
            {
                label: 'Items',
                data: allMonths.map(m => {
                    const data = props.monthlyTrend.find(t => t.month === m);
                    return data ? data.items_count : 0;
                }),
                borderColor: 'rgba(16, 185, 129, 1)',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                tension: 0.4,
            }
        ]
    };
});

const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            position: 'top' as const,
        },
    },
};

const doughnutOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            position: 'right' as const,
        },
    },
};

const formatCurrency = (value: number) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
    }).format(value);
};
</script>

<template>
    <Head title="Document Analytics" />

    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <Heading>Document Analytics</Heading>
            <p class="text-sm text-muted-foreground">数据分析与统计</p>
        </div>

        <!-- Summary Stats -->
        <div class="grid gap-4 md:grid-cols-3">
            <Card>
                <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                    <CardTitle class="text-sm font-medium">Total Documents</CardTitle>
                    <FileSpreadsheet class="h-4 w-4 text-muted-foreground" />
                </CardHeader>
                <CardContent>
                    <div class="text-2xl font-bold">{{ props.stats.totalDocuments }}</div>
                    <p class="text-xs text-muted-foreground">Processed shipments</p>
                </CardContent>
            </Card>

            <Card>
                <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                    <CardTitle class="text-sm font-medium">Total Items</CardTitle>
                    <Package class="h-4 w-4 text-muted-foreground" />
                </CardHeader>
                <CardContent>
                    <div class="text-2xl font-bold">{{ props.stats.totalItems.toLocaleString() }}</div>
                    <p class="text-xs text-muted-foreground">Units shipped</p>
                </CardContent>
            </Card>

            <Card>
                <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                    <CardTitle class="text-sm font-medium">Total Value</CardTitle>
                    <DollarSign class="h-4 w-4 text-muted-foreground" />
                </CardHeader>
                <CardContent>
                    <div class="text-2xl font-bold">{{ formatCurrency(props.stats.totalValue) }}</div>
                    <p class="text-xs text-muted-foreground">货款总额</p>
                </CardContent>
            </Card>
        </div>

        <!-- Charts Row 1 -->
        <div class="grid gap-6 lg:grid-cols-2">
            <!-- Model Quantity Chart -->
            <Card>
                <CardHeader>
                    <CardTitle class="flex items-center gap-2">
                        <BarChart3 class="h-5 w-5" />
                        Top Models by Quantity
                    </CardTitle>
                    <CardDescription>型号数量排行 (Top 10)</CardDescription>
                </CardHeader>
                <CardContent>
                    <div class="h-[300px]">
                        <Bar :data="modelQuantityChart" :options="chartOptions" />
                    </div>
                </CardContent>
            </Card>

            <!-- Model Value Chart -->
            <Card>
                <CardHeader>
                    <CardTitle class="flex items-center gap-2">
                        <DollarSign class="h-5 w-5" />
                        Top Models by Value
                    </CardTitle>
                    <CardDescription>型号货值排行 (Top 10)</CardDescription>
                </CardHeader>
                <CardContent>
                    <div class="h-[300px]">
                        <Bar :data="modelValueChart" :options="chartOptions" />
                    </div>
                </CardContent>
            </Card>
        </div>

        <!-- Charts Row 2 -->
        <div class="grid gap-6 lg:grid-cols-2">
            <!-- Category Distribution -->
            <Card>
                <CardHeader>
                    <CardTitle class="flex items-center gap-2">
                        <PieChart class="h-5 w-5" />
                        Category Distribution
                    </CardTitle>
                    <CardDescription>产品分类分布</CardDescription>
                </CardHeader>
                <CardContent>
                    <div v-if="props.categoryStats.length > 0" class="h-[300px]">
                        <Doughnut :data="categoryChart" :options="doughnutOptions" />
                    </div>
                    <div v-else class="h-[300px] flex items-center justify-center text-muted-foreground">
                        No category data available
                    </div>
                </CardContent>
            </Card>

            <!-- Monthly Trend -->
            <Card>
                <CardHeader>
                    <CardTitle class="flex items-center gap-2">
                        <Calendar class="h-5 w-5" />
                        Monthly Trend ({{ new Date().getFullYear() }})
                    </CardTitle>
                    <CardDescription>月度趋势</CardDescription>
                </CardHeader>
                <CardContent>
                    <div class="h-[300px]">
                        <Line :data="monthlyChart" :options="chartOptions" />
                    </div>
                </CardContent>
            </Card>
        </div>

        <!-- Model Statistics Table -->
        <Card>
            <CardHeader>
                <CardTitle>Model Statistics</CardTitle>
                <CardDescription>Detailed breakdown by model number</CardDescription>
            </CardHeader>
            <CardContent>
                <div class="rounded-md border overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b bg-muted/50">
                                <th class="px-4 py-3 text-left text-sm font-medium">Model</th>
                                <th class="px-4 py-3 text-right text-sm font-medium">Occurrences</th>
                                <th class="px-4 py-3 text-right text-sm font-medium">Total Qty</th>
                                <th class="px-4 py-3 text-right text-sm font-medium">Total Value</th>
                                <th class="px-4 py-3 text-right text-sm font-medium">Weight (kg)</th>
                                <th class="px-4 py-3 text-right text-sm font-medium">Volume (m³)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="model in props.modelStats" :key="model.model_number" class="border-b hover:bg-muted/50">
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center rounded-md bg-blue-100 px-2 py-1 text-xs font-medium text-blue-700">
                                        {{ model.model_number }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right text-sm">{{ model.count }}</td>
                                <td class="px-4 py-3 text-right text-sm font-medium">{{ model.total_quantity.toLocaleString() }}</td>
                                <td class="px-4 py-3 text-right text-sm">{{ formatCurrency(Number(model.total_value) || 0) }}</td>
                                <td class="px-4 py-3 text-right text-sm">{{ (Number(model.total_weight) || 0).toFixed(2) }}</td>
                                <td class="px-4 py-3 text-right text-sm">{{ (Number(model.total_volume) || 0).toFixed(3) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div v-if="props.modelStats.length === 0" class="py-12 text-center text-muted-foreground">
                    <BarChart3 class="mx-auto h-12 w-12 mb-4 opacity-50" />
                    <p>No data available. Upload and process documents to see analytics.</p>
                </div>
            </CardContent>
        </Card>

        <!-- Category Statistics -->
        <Card v-if="props.categoryStats.length > 0">
            <CardHeader>
                <CardTitle>Category Statistics</CardTitle>
                <CardDescription>产品分类统计</CardDescription>
            </CardHeader>
            <CardContent>
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                    <div
                        v-for="category in props.categoryStats"
                        :key="category.category"
                        class="rounded-lg border p-4 hover:bg-muted/50 transition-colors"
                    >
                        <div class="flex items-start justify-between mb-2">
                            <h4 class="font-semibold">{{ category.category || 'Uncategorized' }}</h4>
                            <span class="text-xs bg-primary/10 text-primary px-2 py-1 rounded">
                                {{ category.count }} items
                            </span>
                        </div>
                        <div class="space-y-1 text-sm text-muted-foreground">
                            <p>Quantity: <span class="font-medium text-foreground">{{ category.total_quantity.toLocaleString() }}</span></p>
                            <p>Value: <span class="font-medium text-foreground">{{ formatCurrency(Number(category.total_value) || 0) }}</span></p>
                        </div>
                    </div>
                </div>
            </CardContent>
        </Card>
    </div>
</template>
