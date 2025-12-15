<template>
  <EcommerceLayout>
    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-gradient-to-br from-blue-900 via-blue-800 to-purple-900">
      <div class="absolute inset-0 bg-black/20"></div>
      <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
          <div class="text-white">
            <h1 class="text-4xl lg:text-6xl font-bold leading-tight mb-6">
              {{ $t('home.hero.title', { highlight: $t('home.hero.highlight') }) }}
            </h1>
            <p class="text-xl text-blue-100 mb-8 leading-relaxed">
              {{ $t('home.hero.subtitle') }}
            </p>
            <div class="flex flex-col sm:flex-row gap-4">
              <Button size="lg" class="bg-white text-blue-900 hover:bg-gray-100 text-lg px-8 py-4">
                {{ $t('home.hero.cta_trial') }}
              </Button>
              <Button variant="outline" size="lg" class="border-white text-white hover:bg-white hover:text-blue-900 text-lg px-8 py-4">
                {{ $t('home.hero.cta_demo') }}
              </Button>
            </div>
          </div>
          <div class="hidden lg:block">
            <div class="relative">
              <div class="absolute inset-0 bg-gradient-to-r from-blue-600 to-purple-600 rounded-2xl transform rotate-6"></div>
              <div class="relative bg-white rounded-2xl shadow-2xl transform -rotate-2 hover:rotate-0 transition-transform duration-500 p-8">
                <!-- Dashboard Mockup -->
                <div class="space-y-4">
                  <div class="flex items-center space-x-2 mb-6">
                    <div class="w-3 h-3 bg-red-400 rounded-full"></div>
                    <div class="w-3 h-3 bg-yellow-400 rounded-full"></div>
                    <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                  </div>
                  <div class="grid grid-cols-2 gap-4">
                    <div class="bg-blue-50 rounded-lg p-4">
                      <div class="w-8 h-8 bg-blue-500 rounded mb-2"></div>
                      <div class="h-2 bg-gray-200 rounded mb-1"></div>
                      <div class="h-2 bg-gray-200 rounded w-3/4"></div>
                    </div>
                    <div class="bg-green-50 rounded-lg p-4">
                      <div class="w-8 h-8 bg-green-500 rounded mb-2"></div>
                      <div class="h-2 bg-gray-200 rounded mb-1"></div>
                      <div class="h-2 bg-gray-200 rounded w-2/3"></div>
                    </div>
                    <div class="bg-purple-50 rounded-lg p-4">
                      <div class="w-8 h-8 bg-purple-500 rounded mb-2"></div>
                      <div class="h-2 bg-gray-200 rounded mb-1"></div>
                      <div class="h-2 bg-gray-200 rounded w-4/5"></div>
                    </div>
                    <div class="bg-orange-50 rounded-lg p-4">
                      <div class="w-8 h-8 bg-orange-500 rounded mb-2"></div>
                      <div class="h-2 bg-gray-200 rounded mb-1"></div>
                      <div class="h-2 bg-gray-200 rounded w-1/2"></div>
                    </div>
                  </div>
                  <div class="bg-gray-50 rounded-lg p-4 mt-4">
                    <div class="flex space-x-1 mb-3">
                      <div class="h-12 bg-blue-400 rounded w-8"></div>
                      <div class="h-8 bg-blue-300 rounded w-8 mt-4"></div>
                      <div class="h-16 bg-blue-500 rounded w-8 -mt-4"></div>
                      <div class="h-6 bg-blue-200 rounded w-8 mt-6"></div>
                      <div class="h-10 bg-blue-400 rounded w-8 mt-2"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Floating Elements -->
      <div class="absolute top-20 left-10 w-16 h-16 bg-white/10 rounded-full animate-bounce delay-1000"></div>
      <div class="absolute top-40 right-20 w-8 h-8 bg-purple-400/20 rounded-full animate-pulse"></div>
      <div class="absolute bottom-20 left-1/4 w-12 h-12 bg-blue-400/15 rounded-full animate-bounce delay-500"></div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
            {{ $t('home.features.title') }}
          </h2>
          <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            {{ $t('home.features.subtitle') }}
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div v-for="feature in features" :key="feature.id" class="group relative p-8 bg-white rounded-2xl border border-gray-200 hover:shadow-xl hover:border-blue-300 transition-all duration-300">
            <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-500 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
              <component :is="feature.icon" class="w-6 h-6 text-white" />
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-3">{{ feature.title }}</h3>
            <p class="text-gray-600 leading-relaxed">{{ feature.description }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Stats Section -->
    <section class="py-20 bg-gradient-to-r from-blue-50 to-purple-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
            {{ $t('home.stats.title') }}
          </h2>
          <p class="text-xl text-gray-600">
            {{ $t('home.stats.subtitle') }}
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
          <div v-for="stat in stats" :key="stat.label" class="text-center">
            <div class="text-4xl lg:text-5xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-600 mb-2">
              {{ stat.value }}
            </div>
            <div class="text-gray-600 text-lg">{{ stat.label }}</div>
          </div>
        </div>
      </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-20 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
            {{ $t('home.testimonials.title') }}
          </h2>
          <p class="text-xl text-gray-600">
            {{ $t('home.testimonials.subtitle') }}
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div v-for="testimonial in testimonials" :key="testimonial.id" class="bg-gray-50 rounded-2xl p-8 relative">
            <div class="flex items-center mb-6">
              <div class="flex text-yellow-400">
                <StarIcon v-for="n in 5" :key="n" class="w-5 h-5 fill-current" />
              </div>
            </div>
            <blockquote class="text-gray-700 mb-6 leading-relaxed">
              "{{ testimonial.content }}"
            </blockquote>
            <div class="flex items-center">
              <div class="w-12 h-12 rounded-full mr-4 flex items-center justify-center text-white font-semibold" :class="testimonial.avatarBg">
                {{ getInitials(testimonial.author) }}
              </div>
              <div>
                <div class="font-semibold text-gray-900">{{ testimonial.author }}</div>
                <div class="text-gray-600 text-sm">{{ testimonial.role }}</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-blue-900 to-purple-900 relative overflow-hidden">
      <div class="absolute inset-0 bg-black/20"></div>
      <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl lg:text-4xl font-bold text-white mb-6">
          {{ $t('home.cta.title') }}
        </h2>
        <p class="text-xl text-blue-100 mb-8 leading-relaxed">
          {{ $t('home.cta.subtitle') }}
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <Button size="lg" class="bg-white text-blue-900 hover:bg-gray-100 text-lg px-8 py-4">
            {{ $t('home.cta.trial') }}
          </Button>
          <Button variant="outline" size="lg" class="border-white text-white hover:bg-white hover:text-blue-900 text-lg px-8 py-4">
            {{ $t('home.cta.demo') }}
          </Button>
        </div>
      </div>
    </section>
  </EcommerceLayout>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import { useI18n } from 'vue-i18n'
import EcommerceLayout from '@/layouts/EcommerceLayout.vue'
import { Button } from '@/components/ui/button'
import {
  CubeIcon,
  ChartBarIcon,
  ClockIcon,
  ShieldCheckIcon,
  TruckIcon,
  UsersIcon,
  StarIcon
} from '@heroicons/vue/24/outline'

const { t } = useI18n()

const features = computed(() => [
  {
    id: 1,
    icon: CubeIcon,
    title: t('home.features.inventory.title'),
    description: t('home.features.inventory.description')
  },
  {
    id: 2,
    icon: ChartBarIcon,
    title: t('home.features.analytics.title'),
    description: t('home.features.analytics.description')
  },
  {
    id: 3,
    icon: ClockIcon,
    title: t('home.features.tracking.title'),
    description: t('home.features.tracking.description')
  },
  {
    id: 4,
    icon: ShieldCheckIcon,
    title: t('home.features.quality.title'),
    description: t('home.features.quality.description')
  },
  {
    id: 5,
    icon: TruckIcon,
    title: t('home.features.shipping.title'),
    description: t('home.features.shipping.description')
  },
  {
    id: 6,
    icon: UsersIcon,
    title: t('home.features.team.title'),
    description: t('home.features.team.description')
  }
])

const stats = computed(() => [
  { value: '10K+', label: t('home.stats.users') },
  { value: '99.9%', label: t('home.stats.uptime') },
  { value: '50M+', label: t('home.stats.items') },
  { value: '24/7', label: t('home.stats.support') }
])

const testimonials = ref([
  {
    id: 1,
    content: 'WarehouseMaster transformed our operations completely. We\'ve reduced processing time by 60% and eliminated manual errors.',
    author: 'Sarah Johnson',
    role: 'Operations Manager, TechCorp',
    avatarBg: 'bg-gradient-to-r from-pink-500 to-rose-500'
  },
  {
    id: 2,
    content: 'The real-time tracking and analytics have given us unprecedented visibility into our warehouse operations. Highly recommended!',
    author: 'Michael Chen',
    role: 'Logistics Director, GlobalTrade',
    avatarBg: 'bg-gradient-to-r from-blue-500 to-cyan-500'
  },
  {
    id: 3,
    content: 'Implementation was smooth and the ROI was immediate. Our inventory accuracy improved from 85% to 99.5% within the first month.',
    author: 'Emily Rodriguez',
    role: 'Warehouse Supervisor, FastShip',
    avatarBg: 'bg-gradient-to-r from-emerald-500 to-teal-500'
  }
])

const getInitials = (name: string) => {
  return name
    .split(' ')
    .map(word => word.charAt(0))
    .join('')
    .toUpperCase()
    .slice(0, 2)
}
</script>