<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import {
    BookOpen,
    Folder,
    LayoutGrid,
    MessageSquare,
    Bell,
    User,
    ShoppingCart,
    FileText,
    ArrowDownUp,
    Receipt,
    Package,
    Upload,
    Settings,
    FormInput,
    PackagePlus,
    List,
    LayoutTemplate,
    Send,
    Inbox,
    Archive
} from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const { t } = useI18n();

const mainNavItems: NavItem[] = [
    {
        title: t('dashboard.sidebar.dashboard'),
        href: '/dashboard',
        icon: LayoutGrid,
    },
    {
        title: t('dashboard.sidebar.product_management'),
        icon: Package,
        items: [
            {
                title: t('dashboard.sidebar.upload_product'),
                href: '/dashboard/products/upload',
                icon: PackagePlus,
            },
            {
                title: t('dashboard.sidebar.product_list'),
                href: '/dashboard/products',
                icon: List,
            },
        ],
    },
    {
        title: t('dashboard.sidebar.stock_management'),
        icon: Archive,
        items: [
            {
                title: t('dashboard.sidebar.upload_stock'),
                href: '/dashboard/stock/upload',
                icon: Upload,
            },
            {
                title: t('dashboard.sidebar.stock_list'),
                href: '/dashboard/stock',
                icon: List,
            },
            {
                title: t('dashboard.sidebar.stock_layout'),
                href: '/dashboard/stock/layout',
                icon: LayoutTemplate,
            },
        ],
    },
    {
        title: t('dashboard.sidebar.orders'),
        icon: ShoppingCart,
        items: [
            {
                title: t('dashboard.sidebar.order_list'),
                href: '/dashboard/orders',
                icon: List,
            },
            {
                title: t('dashboard.sidebar.backorder'),
                href: '/dashboard/orders/backorders',
                icon: ArrowDownUp,
            },
            {
                title: t('dashboard.sidebar.invoice'),
                href: '/dashboard/orders/invoices',
                icon: Receipt,
            },
        ],
    },
    {
        title: t('dashboard.sidebar.messages'),
        icon: MessageSquare,
        items: [
            {
                title: t('dashboard.sidebar.my_messages'),
                href: '/dashboard/messages',
                icon: Inbox,
            },
            {
                title: t('dashboard.sidebar.send_message'),
                href: '/dashboard/messages/send',
                icon: Send,
            },
            {
                title: t('dashboard.sidebar.notifications'),
                href: '/dashboard/messages/notifications',
                icon: Bell,
            },
        ],
    },
    {
        title: t('dashboard.sidebar.document'),
        icon: Folder,
        items: [
            {
                title: t('dashboard.sidebar.document_list'),
                href: '/dashboard/documents',
                icon: List,
            },
            {
                title: t('dashboard.sidebar.forms'),
                href: '/dashboard/documents/forms',
                icon: FormInput,
            },
        ],
    },
    {
        title: t('dashboard.sidebar.settings'),
        icon: Settings,
        items: [
            {
                title: t('dashboard.sidebar.account_settings'),
                href: '/dashboard/settings',
                icon: User,
            },
        ],
    },
];

const footerNavItems: NavItem[] = [
    {
        title: 'Github Repo',
        href: 'https://github.com/laravel/vue-starter-kit',
        icon: Folder,
    },
    {
        title: 'Documentation',
        href: 'https://laravel.com/docs/starter-kits#vue',
        icon: BookOpen,
    },
];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route('dashboard')">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
