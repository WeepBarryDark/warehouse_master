<template>
  <EcommerceLayout>
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-50 to-purple-50 py-16">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
          {{ $t('products.title') }}
        </h1>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
          {{ $t('products.subtitle') }}
        </p>
      </div>
    </section>

    <!-- Product Categories -->
    <section class="py-20">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Filter Tabs -->
        <div class="flex flex-wrap justify-center gap-4 mb-12">
          <Button
            v-for="category in categories"
            :key="category.id"
            :variant="selectedCategory === category.id ? 'default' : 'outline'"
            @click="selectedCategory = category.id"
            class="px-6 py-2"
          >
            {{ category.name }}
          </Button>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div
            v-for="product in filteredProducts"
            :key="product.id"
            class="group bg-white rounded-2xl border border-gray-200 overflow-hidden hover:shadow-xl hover:border-blue-300 transition-all duration-300"
          >
            <div class="relative overflow-hidden h-48 bg-gradient-to-br" :class="product.gradient">
              <div class="absolute inset-0 flex items-center justify-center">
                <component :is="product.icon" class="w-20 h-20 text-white/80" />
              </div>
              <div class="absolute inset-0 bg-black/10 group-hover:bg-black/5 transition-colors duration-300"></div>
              <div class="absolute top-4 right-4">
                <span
                  :class="[
                    'px-3 py-1 rounded-full text-sm font-medium backdrop-blur-sm',
                    product.badge === 'Popular' ? 'bg-blue-100/90 text-blue-700' :
                    product.badge === 'New' ? 'bg-green-100/90 text-green-700' :
                    'bg-purple-100/90 text-purple-700'
                  ]"
                >
                  {{ product.badge }}
                </span>
              </div>
            </div>
            
            <div class="p-6">
              <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ product.name }}</h3>
              <p class="text-gray-600 mb-4 line-clamp-3">{{ product.description }}</p>
              
              <div class="flex items-center justify-between mb-4">
                <div class="text-2xl font-bold text-blue-600">
                  {{ product.price }}
                </div>
                <div class="flex items-center text-sm text-gray-500">
                  <StarIcon class="w-4 h-4 text-yellow-400 fill-current mr-1" />
                  {{ product.rating }}
                </div>
              </div>

              <div class="space-y-2 mb-6">
                <div
                  v-for="feature in product.features.slice(0, 3)"
                  :key="feature"
                  class="flex items-center text-sm text-gray-600"
                >
                  <CheckCircleIcon class="w-4 h-4 text-green-500 mr-2 flex-shrink-0" />
                  {{ feature }}
                </div>
              </div>

              <div class="flex gap-2">
                <Button class="flex-1">
                  {{ $t('products.actions.learn_more') }}
                </Button>
                <Button variant="outline" size="icon">
                  <HeartIcon class="w-4 h-4" />
                </Button>
              </div>
            </div>
          </div>
        </div>

        <!-- Load More Button -->
        <div class="text-center mt-12">
          <Button variant="outline" size="lg" class="px-8">
            {{ $t('products.actions.load_more') }}
          </Button>
        </div>
      </div>
    </section>

    <!-- Product Comparison -->
    <section class="py-20 bg-gray-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
            {{ $t('products.comparison.title') }}
          </h2>
          <p class="text-xl text-gray-600">
            {{ $t('products.comparison.subtitle') }}
          </p>
        </div>

        <div class="overflow-x-auto">
          <table class="w-full bg-white rounded-2xl overflow-hidden shadow-lg">
            <thead class="bg-gradient-to-r from-blue-500 to-purple-500 text-white">
              <tr>
                <th class="text-left p-6 font-semibold">Features</th>
                <th class="text-center p-6 font-semibold">Starter</th>
                <th class="text-center p-6 font-semibold">Professional</th>
                <th class="text-center p-6 font-semibold">Enterprise</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(feature, index) in comparisonFeatures" :key="feature.name" :class="index % 2 === 0 ? 'bg-gray-50' : 'bg-white'">
                <td class="p-6 font-medium text-gray-900">{{ feature.name }}</td>
                <td class="p-6 text-center">
                  <component
                    :is="feature.starter ? CheckCircleIcon : XCircleIcon"
                    :class="feature.starter ? 'text-green-500' : 'text-gray-300'"
                    class="w-6 h-6 mx-auto"
                  />
                </td>
                <td class="p-6 text-center">
                  <component
                    :is="feature.professional ? CheckCircleIcon : XCircleIcon"
                    :class="feature.professional ? 'text-green-500' : 'text-gray-300'"
                    class="w-6 h-6 mx-auto"
                  />
                </td>
                <td class="p-6 text-center">
                  <component
                    :is="feature.enterprise ? CheckCircleIcon : XCircleIcon"
                    :class="feature.enterprise ? 'text-green-500' : 'text-gray-300'"
                    class="w-6 h-6 mx-auto"
                  />
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-gradient-to-r from-blue-900 to-purple-900">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl lg:text-4xl font-bold text-white mb-6">
          {{ $t('products.cta.title') }}
        </h2>
        <p class="text-xl text-blue-100 mb-8">
          {{ $t('products.cta.subtitle') }}
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <Button size="lg" class="bg-white text-blue-900 hover:bg-gray-100 text-lg px-8 py-4">
            {{ $t('products.cta.trial') }}
          </Button>
          <Button variant="outline" size="lg" class="border-white text-white hover:bg-white hover:text-blue-900 text-lg px-8 py-4">
            {{ $t('products.cta.contact') }}
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
  StarIcon,
  CheckCircleIcon,
  XCircleIcon,
  HeartIcon,
  CubeIcon,
  ChartBarIcon,
  CogIcon,
  DevicePhoneMobileIcon,
  LinkIcon,
  ShieldCheckIcon
} from '@heroicons/vue/24/outline'

const { t } = useI18n()
const selectedCategory = ref('all')

const categories = computed(() => [
  { id: 'all', name: t('products.categories.all') },
  { id: 'management', name: t('products.categories.management') },
  { id: 'analytics', name: t('products.categories.analytics') },
  { id: 'automation', name: t('products.categories.automation') },
  { id: 'integration', name: t('products.categories.integration') }
])

const products = computed(() => [
  {
    id: 1,
    name: 'Inventory Control System',
    description: 'Complete inventory management solution with real-time tracking, automated reordering, and comprehensive reporting capabilities.',
    price: '$99/month',
    rating: '4.9',
    badge: t('products.badges.popular'),
    category: 'management',
    icon: CubeIcon,
    gradient: 'from-blue-500 to-blue-700',
    features: [
      'Real-time inventory tracking',
      'Automated stock alerts',
      'Barcode scanning support',
      'Multi-location management',
      'Integration with major ERPs'
    ]
  },
  {
    id: 2,
    name: 'Warehouse Analytics Pro',
    description: 'Advanced analytics platform providing deep insights into warehouse performance, productivity metrics, and operational efficiency.',
    price: '$149/month',
    rating: '4.8',
    badge: t('products.badges.new'),
    category: 'analytics',
    icon: ChartBarIcon,
    gradient: 'from-emerald-500 to-emerald-700',
    features: [
      'Custom dashboard creation',
      'Predictive analytics',
      'Performance benchmarking',
      'ROI tracking',
      'Export to multiple formats'
    ]
  },
  {
    id: 3,
    name: 'Automated Workflow Engine',
    description: 'Streamline operations with intelligent automation that reduces manual tasks and optimizes warehouse workflows.',
    price: '$199/month',
    rating: '4.7',
    badge: t('products.badges.enterprise'),
    category: 'automation',
    icon: CogIcon,
    gradient: 'from-purple-500 to-purple-700',
    features: [
      'Workflow automation',
      'Task scheduling',
      'Quality control checks',
      'Exception handling',
      'Performance optimization'
    ]
  },
  {
    id: 4,
    name: 'Mobile Warehouse App',
    description: 'Mobile-first application for warehouse staff with offline capabilities, scanning features, and real-time synchronization.',
    price: '$49/month',
    rating: '4.6',
    badge: t('products.badges.popular'),
    category: 'management',
    icon: DevicePhoneMobileIcon,
    gradient: 'from-cyan-500 to-cyan-700',
    features: [
      'Mobile barcode scanning',
      'Offline functionality',
      'Real-time sync',
      'Task management',
      'Digital signatures'
    ]
  },
  {
    id: 5,
    name: 'Supply Chain Integration',
    description: 'Seamlessly connect with suppliers, carriers, and customers through our comprehensive integration platform.',
    price: '$299/month',
    rating: '4.9',
    badge: t('products.badges.enterprise'),
    category: 'integration',
    icon: LinkIcon,
    gradient: 'from-orange-500 to-orange-700',
    features: [
      'EDI integration',
      'API connectivity',
      'Real-time data sync',
      'Multi-carrier support',
      'Custom integrations'
    ]
  },
  {
    id: 6,
    name: 'Quality Management Suite',
    description: 'Comprehensive quality control system with inspection workflows, compliance tracking, and audit trail capabilities.',
    price: '$129/month',
    rating: '4.8',
    badge: t('products.badges.new'),
    category: 'management',
    icon: ShieldCheckIcon,
    gradient: 'from-rose-500 to-rose-700',
    features: [
      'Inspection checklists',
      'Photo documentation',
      'Compliance tracking',
      'Audit trails',
      'Corrective actions'
    ]
  }
])

const comparisonFeatures = ref([
  { name: 'Real-time Inventory Tracking', starter: true, professional: true, enterprise: true },
  { name: 'Basic Reporting', starter: true, professional: true, enterprise: true },
  { name: 'Mobile App Access', starter: false, professional: true, enterprise: true },
  { name: 'Advanced Analytics', starter: false, professional: true, enterprise: true },
  { name: 'Workflow Automation', starter: false, professional: false, enterprise: true },
  { name: 'Custom Integrations', starter: false, professional: false, enterprise: true },
  { name: '24/7 Priority Support', starter: false, professional: false, enterprise: true },
  { name: 'Multi-location Support', starter: false, professional: true, enterprise: true }
])

const filteredProducts = computed(() => {
  if (selectedCategory.value === 'all') {
    return products.value
  }
  return products.value.filter((product: any) => product.category === selectedCategory.value)
})
</script>