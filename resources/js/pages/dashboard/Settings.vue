<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { useI18n } from 'vue-i18n';
import LanguageTimezoneSettings from '@/components/LanguageTimezoneSettings.vue';

const { t } = useI18n();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: t('dashboard.title'),
        href: '/dashboard',
    },
    {
        title: t('dashboard.sidebar.settings'),
        href: '/dashboard/settings',
    },
];
</script>

<template>
    <Head :title="t('dashboard.sidebar.system_settings')" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight">{{ t('dashboard.sidebar.system_settings') }}</h1>
                    <p class="text-muted-foreground">Manage your system preferences and configurations</p>
                </div>
            </div>

            <!-- Settings Cards -->
            <div class="grid gap-6 md:grid-cols-2">
                <!-- Language Settings -->
                <Card>
                    <CardHeader>
                        <CardTitle>Language</CardTitle>
                        <CardDescription>Configure your language preferences</CardDescription>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-medium">Current Language</h4>
                                <p class="text-sm text-muted-foreground">Choose your preferred language</p>
                            </div>
                            <LanguageTimezoneSettings />
                        </div>
                    </CardContent>
                </Card>

                <!-- Notification Settings -->
                <Card>
                    <CardHeader>
                        <CardTitle>Notifications</CardTitle>
                        <CardDescription>Manage how you receive notifications</CardDescription>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-medium">Email Notifications</h4>
                                <p class="text-sm text-muted-foreground">Receive updates via email</p>
                            </div>
                            <Button variant="outline" size="sm">Configure</Button>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-medium">Push Notifications</h4>
                                <p class="text-sm text-muted-foreground">Real-time browser notifications</p>
                            </div>
                            <Button variant="outline" size="sm">Configure</Button>
                        </div>
                    </CardContent>
                </Card>

                <!-- Display Settings -->
                <Card>
                    <CardHeader>
                        <CardTitle>Display</CardTitle>
                        <CardDescription>Customize your interface appearance</CardDescription>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-medium">Theme</h4>
                                <p class="text-sm text-muted-foreground">Choose your preferred theme</p>
                            </div>
                            <Button variant="outline" size="sm">Configure</Button>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-medium">Sidebar</h4>
                                <p class="text-sm text-muted-foreground">Sidebar collapse behavior</p>
                            </div>
                            <Button variant="outline" size="sm">Configure</Button>
                        </div>
                    </CardContent>
                </Card>

                <!-- Data & Privacy -->
                <Card>
                    <CardHeader>
                        <CardTitle>Data & Privacy</CardTitle>
                        <CardDescription>Manage your data preferences</CardDescription>
                    </CardHeader>
                    <CardContent class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-medium">Data Export</h4>
                                <p class="text-sm text-muted-foreground">Download your data</p>
                            </div>
                            <Button variant="outline" size="sm">Export</Button>
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-medium">Analytics</h4>
                                <p class="text-sm text-muted-foreground">Usage analytics preferences</p>
                            </div>
                            <Button variant="outline" size="sm">Configure</Button>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>