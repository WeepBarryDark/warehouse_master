<template>
  <nav class="bg-gradient-to-r from-blue-50 to-indigo-50 border-b border-blue-100 sticky top-0 z-50 shadow-sm backdrop-blur-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        <!-- Logo -->
        <div class="flex items-center">
          <Link href="/" class="flex items-center space-x-2">
            <div class="w-8 h-8 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg flex items-center justify-center">
              <span class="text-white font-bold text-sm">WM</span>
            </div>
            <span class="text-xl font-bold text-gray-900">WarehouseMaster</span>
          </Link>
        </div>


        <!-- Cart and User Actions -->
        <div class="flex items-center space-x-4">
          <!-- Language and Timezone Settings -->
          <LanguageTimezoneSettings />
          <!-- Cart -->
          <Link :href="route('cart')" class="relative p-2 text-gray-700 hover:text-blue-600 transition-colors">
            <ShoppingCartIcon class="w-6 h-6" />
            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
              {{ cartItemsCount }}
            </span>
          </Link>

          <!-- User Avatar / Login -->
          <div v-if="$page.props.auth.user" class="relative">
            <DropdownMenu>
              <DropdownMenuTrigger as-child>
                <Button variant="ghost" class="relative h-10 w-10 rounded-full">
                  <Avatar class="h-10 w-10">
                    <AvatarImage :src="$page.props.auth.user.avatar" :alt="$page.props.auth.user.name" />
                    <AvatarFallback>{{ getInitials($page.props.auth.user.name) }}</AvatarFallback>
                  </Avatar>
                </Button>
              </DropdownMenuTrigger>
              <DropdownMenuContent class="w-56" align="end">
                <DropdownMenuLabel class="font-normal">
                  <div class="flex flex-col space-y-1">
                    <p class="text-sm font-medium">{{ $page.props.auth.user.name }}</p>
                    <p class="text-xs text-muted-foreground">{{ $page.props.auth.user.email }}</p>
                  </div>
                </DropdownMenuLabel>
                <DropdownMenuSeparator />
                <DropdownMenuItem as-child>
                  <Link :href="route('dashboard')" class="w-full cursor-pointer flex items-center">
                    <span>{{ $t('nav.dashboard') }}</span>
                  </Link>
                </DropdownMenuItem>
                <DropdownMenuItem as-child>
                  <Link :href="route('profile.edit')" class="w-full cursor-pointer flex items-center">
                    <span>{{ $t('nav.settings') }}</span>
                  </Link>
                </DropdownMenuItem>
                <DropdownMenuSeparator />
                <DropdownMenuItem as-child>
                  <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="w-full text-left cursor-pointer flex items-center"
                  >
                    <span>{{ $t('nav.logout') }}</span>
                  </Link>
                </DropdownMenuItem>
              </DropdownMenuContent>
            </DropdownMenu>
          </div>
          
          <div v-else class="flex items-center space-x-2">
            <Link :href="route('login')" class="text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors">
              {{ $t('nav.login') }}
            </Link>
            <Link
              :href="route('register')"
              class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors"
            >
              {{ $t('nav.register') }}
            </Link>
          </div>

        </div>
      </div>

    </div>
  </nav>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { Link } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'
import { Button } from '@/components/ui/button'
import { Avatar, AvatarFallback, AvatarImage } from '@/components/ui/avatar'
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger
} from '@/components/ui/dropdown-menu'
import { ShoppingCartIcon } from '@heroicons/vue/24/outline'
import LanguageTimezoneSettings from '@/components/LanguageTimezoneSettings.vue'

const { t } = useI18n()

const cartItemsCount = computed(() => {
  // This would typically come from a store or prop
  return 3
})

const getInitials = (name: string) => {
  return name
    .split(' ')
    .map(word => word.charAt(0))
    .join('')
    .toUpperCase()
    .slice(0, 2)
}
</script>