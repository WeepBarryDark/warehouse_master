<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import Heading from '@/components/Heading.vue';
import { useI18n } from 'vue-i18n';
import { Grid3x3, Save, Undo } from 'lucide-vue-next';
import { ref } from 'vue';

const { t } = useI18n();

interface WarehouseZone {
    id: string;
    name: string;
    capacity: number;
    current: number;
    color: string;
}

const zones = ref<WarehouseZone[]>([
    { id: 'A', name: 'Zone A - Electronics', capacity: 100, current: 75, color: 'bg-blue-100 border-blue-300' },
    { id: 'B', name: 'Zone B - Furniture', capacity: 80, current: 60, color: 'bg-green-100 border-green-300' },
    { id: 'C', name: 'Zone C - Office Supplies', capacity: 120, current: 90, color: 'bg-purple-100 border-purple-300' },
    { id: 'D', name: 'Zone D - Storage', capacity: 60, current: 15, color: 'bg-yellow-100 border-yellow-300' },
    { id: 'E', name: 'Zone E - Receiving', capacity: 40, current: 10, color: 'bg-red-100 border-red-300' },
    { id: 'F', name: 'Zone F - Shipping', capacity: 40, current: 25, color: 'bg-orange-100 border-orange-300' },
]);

const getUtilization = (zone: WarehouseZone) => {
    return Math.round((zone.current / zone.capacity) * 100);
};

const getUtilizationColor = (utilization: number) => {
    if (utilization >= 90) return 'text-red-600';
    if (utilization >= 70) return 'text-yellow-600';
    return 'text-green-600';
};
</script>

<template>
    <Head :title="t('dashboard.sidebar.stock_layout')" />

    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <Heading>{{ t('dashboard.sidebar.stock_layout') }}</Heading>
            <div class="flex gap-2">
                <Button variant="outline">
                    <Undo class="mr-2 h-4 w-4" />
                    Reset
                </Button>
                <Button>
                    <Save class="mr-2 h-4 w-4" />
                    Save Layout
                </Button>
            </div>
        </div>

        <!-- Warehouse Stats -->
        <div class="grid gap-4 md:grid-cols-4">
            <Card>
                <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                    <CardTitle class="text-sm font-medium">Total Capacity</CardTitle>
                </CardHeader>
                <CardContent>
                    <div class="text-2xl font-bold">
                        {{ zones.reduce((sum, z) => sum + z.capacity, 0) }}
                    </div>
                    <p class="text-xs text-muted-foreground">Units available</p>
                </CardContent>
            </Card>

            <Card>
                <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                    <CardTitle class="text-sm font-medium">Current Stock</CardTitle>
                </CardHeader>
                <CardContent>
                    <div class="text-2xl font-bold">
                        {{ zones.reduce((sum, z) => sum + z.current, 0) }}
                    </div>
                    <p class="text-xs text-muted-foreground">Units in warehouse</p>
                </CardContent>
            </Card>

            <Card>
                <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                    <CardTitle class="text-sm font-medium">Utilization</CardTitle>
                </CardHeader>
                <CardContent>
                    <div class="text-2xl font-bold">
                        {{ Math.round((zones.reduce((sum, z) => sum + z.current, 0) / zones.reduce((sum, z) => sum + z.capacity, 0)) * 100) }}%
                    </div>
                    <p class="text-xs text-muted-foreground">Overall capacity used</p>
                </CardContent>
            </Card>

            <Card>
                <CardHeader class="flex flex-row items-center justify-between space-y-0 pb-2">
                    <CardTitle class="text-sm font-medium">Active Zones</CardTitle>
                </CardHeader>
                <CardContent>
                    <div class="text-2xl font-bold">{{ zones.length }}</div>
                    <p class="text-xs text-muted-foreground">Warehouse zones</p>
                </CardContent>
            </Card>
        </div>

        <!-- Warehouse Layout Grid -->
        <Card>
            <CardHeader>
                <CardTitle>Warehouse Layout</CardTitle>
                <CardDescription>Visual representation of your warehouse zones and capacity</CardDescription>
            </CardHeader>
            <CardContent>
                <div class="grid grid-cols-2 gap-4 lg:grid-cols-3">
                    <div
                        v-for="zone in zones"
                        :key="zone.id"
                        :class="['rounded-lg border-2 p-6 transition-all hover:shadow-md cursor-pointer', zone.color]"
                    >
                        <div class="space-y-3">
                            <div class="flex items-start justify-between">
                                <div>
                                    <div class="flex items-center gap-2">
                                        <Grid3x3 class="h-5 w-5" />
                                        <h3 class="font-semibold">{{ zone.name }}</h3>
                                    </div>
                                    <p class="text-sm text-muted-foreground mt-1">Zone {{ zone.id }}</p>
                                </div>
                                <span
                                    :class="['text-sm font-bold', getUtilizationColor(getUtilization(zone))]"
                                >
                                    {{ getUtilization(zone) }}%
                                </span>
                            </div>

                            <div class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span>Current</span>
                                    <span class="font-medium">{{ zone.current }} / {{ zone.capacity }}</span>
                                </div>
                                <div class="h-2 w-full rounded-full bg-white/50">
                                    <div
                                        class="h-full rounded-full transition-all"
                                        :class="{
                                            'bg-green-600': getUtilization(zone) < 70,
                                            'bg-yellow-600': getUtilization(zone) >= 70 && getUtilization(zone) < 90,
                                            'bg-red-600': getUtilization(zone) >= 90,
                                        }"
                                        :style="{ width: `${getUtilization(zone)}%` }"
                                    />
                                </div>
                            </div>

                            <div class="pt-2">
                                <Button variant="ghost" size="sm" class="w-full">
                                    View Details
                                </Button>
                            </div>
                        </div>
                    </div>
                </div>
            </CardContent>
        </Card>

        <!-- Zone Details -->
        <Card>
            <CardHeader>
                <CardTitle>Zone Management</CardTitle>
                <CardDescription>Configure and manage warehouse zones</CardDescription>
            </CardHeader>
            <CardContent>
                <div class="space-y-4">
                    <div class="rounded-md border">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b bg-muted/50">
                                    <th class="px-4 py-3 text-left text-sm font-medium">Zone</th>
                                    <th class="px-4 py-3 text-left text-sm font-medium">Name</th>
                                    <th class="px-4 py-3 text-right text-sm font-medium">Capacity</th>
                                    <th class="px-4 py-3 text-right text-sm font-medium">Current</th>
                                    <th class="px-4 py-3 text-right text-sm font-medium">Available</th>
                                    <th class="px-4 py-3 text-center text-sm font-medium">Status</th>
                                    <th class="px-4 py-3 text-right text-sm font-medium">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="zone in zones" :key="zone.id" class="border-b">
                                    <td class="px-4 py-3 font-medium">{{ zone.id }}</td>
                                    <td class="px-4 py-3">{{ zone.name }}</td>
                                    <td class="px-4 py-3 text-right">{{ zone.capacity }}</td>
                                    <td class="px-4 py-3 text-right">{{ zone.current }}</td>
                                    <td class="px-4 py-3 text-right">{{ zone.capacity - zone.current }}</td>
                                    <td class="px-4 py-3 text-center">
                                        <span
                                            class="inline-flex rounded-full px-2 py-1 text-xs font-medium"
                                            :class="{
                                                'bg-green-100 text-green-700': getUtilization(zone) < 70,
                                                'bg-yellow-100 text-yellow-700': getUtilization(zone) >= 70 && getUtilization(zone) < 90,
                                                'bg-red-100 text-red-700': getUtilization(zone) >= 90,
                                            }"
                                        >
                                            {{ getUtilization(zone) }}% Used
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <Button variant="ghost" size="sm">Edit</Button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </CardContent>
        </Card>
    </div>
</template>
