<template>
  <div class="flex items-center space-x-2">
    <!-- Language Selector -->
    <DropdownMenu>
      <DropdownMenuTrigger as-child>
        <Button variant="ghost" size="sm" class="flex items-center space-x-2">
          <span class="text-lg">{{ currentLanguage.flag }}</span>
          <span class="hidden sm:inline">{{ currentLanguage.code.toUpperCase() }}</span>
          <ChevronDownIcon class="w-4 h-4" />
        </Button>
      </DropdownMenuTrigger>
      <DropdownMenuContent align="end" class="w-48">
        <DropdownMenuLabel>{{ $t('common.settings.language') }}</DropdownMenuLabel>
        <DropdownMenuSeparator />
        <DropdownMenuItem
          v-for="locale in SUPPORTED_LOCALES"
          :key="locale.code"
          @click="changeLanguage(locale.code)"
          :class="locale.code === currentLocale ? 'bg-blue-50' : ''"
        >
          <span class="mr-3">{{ locale.flag }}</span>
          {{ locale.name }}
          <CheckIcon v-if="locale.code === currentLocale" class="w-4 h-4 ml-auto" />
        </DropdownMenuItem>
      </DropdownMenuContent>
    </DropdownMenu>

    <!-- Timezone Selector -->
    <DropdownMenu>
      <DropdownMenuTrigger as-child>
        <Button variant="ghost" size="sm" class="flex items-center space-x-2">
          <ClockIcon class="w-4 h-4" />
          <span class="hidden sm:inline">{{ currentTimezone?.region || 'Time' }}</span>
          <ChevronDownIcon class="w-4 h-4" />
        </Button>
      </DropdownMenuTrigger>
      <DropdownMenuContent align="end" class="w-80 max-h-96 overflow-y-auto">
        <DropdownMenuLabel>{{ $t('common.settings.timezone') }}</DropdownMenuLabel>
        <DropdownMenuSeparator />

        <!-- Group by region -->
        <div v-for="region in uniqueRegions" :key="region" class="py-1">
          <div class="px-2 py-1.5 text-xs font-semibold text-gray-500 bg-gray-50">
            {{ region }}
          </div>
          <DropdownMenuItem
            v-for="tz in timezonesByRegion(region)"
            :key="tz.code"
            @click="changeTimezone(tz.code)"
            :class="tz.code === currentTimezoneCode ? 'bg-blue-50' : ''"
            class="pl-4"
          >
            <div class="flex-1">
              <div class="text-sm">{{ tz.name }}</div>
              <div class="text-xs text-gray-500">{{ tz.offset }}</div>
            </div>
            <CheckIcon v-if="tz.code === currentTimezoneCode" class="w-4 h-4 ml-auto flex-shrink-0" />
          </DropdownMenuItem>
        </div>
      </DropdownMenuContent>
    </DropdownMenu>
  </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'
import { useI18n } from 'vue-i18n'
import { router } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'
import {
  DropdownMenu,
  DropdownMenuContent,
  DropdownMenuItem,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu'
import { ChevronDownIcon, CheckIcon, ClockIcon } from '@heroicons/vue/24/outline'
import { SUPPORTED_LOCALES, SUPPORTED_TIMEZONES, setLocale, setTimezone } from '@/i18n'

const { locale } = useI18n()

const currentLocale = computed(() => locale.value)

const currentLanguage = computed(() => {
  return SUPPORTED_LOCALES.find(lang => lang.code === currentLocale.value) || SUPPORTED_LOCALES[0]
})

const currentTimezoneCode = computed(() => {
  return localStorage.getItem('warehouse-timezone') || 'Australia/Sydney'
})

const currentTimezone = computed(() => {
  return SUPPORTED_TIMEZONES.find(tz => tz.code === currentTimezoneCode.value)
})

const uniqueRegions = computed(() => {
  const regions = [...new Set(SUPPORTED_TIMEZONES.map(tz => tz.region))]
  // Order: Australia, New Zealand, China, UTC
  return regions.sort((a, b) => {
    const order = ['Australia', 'New Zealand', 'China', 'UTC']
    return order.indexOf(a) - order.indexOf(b)
  })
})

const timezonesByRegion = (region: string) => {
  return SUPPORTED_TIMEZONES.filter(tz => tz.region === region)
}

const changeLanguage = (newLocale: string) => {
  setLocale(newLocale)

  // If user is logged in, save to backend
  if ((window as any).$page?.props?.auth?.user) {
    // Save will be handled by settings page
    // For now just reload
    window.location.reload()
  } else {
    window.location.reload()
  }
}

const changeTimezone = (newTimezone: string) => {
  setTimezone(newTimezone)

  // If user is logged in, save to backend
  if ((window as any).$page?.props?.auth?.user) {
    router.patch('/settings/timezone', {
      timezone: newTimezone
    }, {
      preserveScroll: true,
      onSuccess: () => {
        window.location.reload()
      }
    })
  } else {
    window.location.reload()
  }
}
</script>