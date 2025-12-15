<template>
  <div class="min-h-screen bg-gray-50">
    <EcommerceNavbar />
    
    <!-- Secondary Navigation -->
    <nav class="bg-white border-b border-gray-200 shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-center items-center h-12 space-x-8">
          <Link 
            :href="route('home')" 
            :class="[
              'px-3 py-2 text-sm font-medium transition-colors duration-200 border-b-2',
              route().current('home') 
                ? 'text-blue-600 border-blue-600' 
                : 'text-gray-600 border-transparent hover:text-blue-600 hover:border-blue-300'
            ]"
          >
            {{ $t('nav.home') }}
          </Link>
          <Link 
            :href="route('products')" 
            :class="[
              'px-3 py-2 text-sm font-medium transition-colors duration-200 border-b-2',
              route().current('products') 
                ? 'text-blue-600 border-blue-600' 
                : 'text-gray-600 border-transparent hover:text-blue-600 hover:border-blue-300'
            ]"
          >
            {{ $t('nav.products') }}
          </Link>
          <Link 
            :href="route('pricing')" 
            :class="[
              'px-3 py-2 text-sm font-medium transition-colors duration-200 border-b-2',
              route().current('pricing') 
                ? 'text-blue-600 border-blue-600' 
                : 'text-gray-600 border-transparent hover:text-blue-600 hover:border-blue-300'
            ]"
          >
            {{ $t('nav.pricing') }}
          </Link>
          <Link 
            :href="route('about')" 
            :class="[
              'px-3 py-2 text-sm font-medium transition-colors duration-200 border-b-2',
              route().current('about') 
                ? 'text-blue-600 border-blue-600' 
                : 'text-gray-600 border-transparent hover:text-blue-600 hover:border-blue-300'
            ]"
          >
            {{ $t('nav.about') }}
          </Link>
          <Link 
            :href="route('contact')" 
            :class="[
              'px-3 py-2 text-sm font-medium transition-colors duration-200 border-b-2',
              route().current('contact') 
                ? 'text-blue-600 border-blue-600' 
                : 'text-gray-600 border-transparent hover:text-blue-600 hover:border-blue-300'
            ]"
          >
            {{ $t('nav.contact') }}
          </Link>
          <Link 
            :href="route('help')" 
            :class="[
              'px-3 py-2 text-sm font-medium transition-colors duration-200 border-b-2',
              route().current('help') 
                ? 'text-blue-600 border-blue-600' 
                : 'text-gray-600 border-transparent hover:text-blue-600 hover:border-blue-300'
            ]"
          >
            {{ $t('nav.help') }}
          </Link>
        </div>
      </div>
    </nav>
    
    <main>
      <slot />
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
          <!-- Company Info -->
          <div class="col-span-1 md:col-span-2">
            <div class="flex items-center space-x-2 mb-4">
              <div class="w-8 h-8 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg flex items-center justify-center">
                <span class="text-white font-bold text-sm">WM</span>
              </div>
              <span class="text-xl font-bold">WarehouseMaster</span>
            </div>
            <p class="text-gray-400 mb-4 max-w-md">
              Streamline your warehouse operations with our comprehensive management platform. 
              Built for efficiency, designed for growth.
            </p>
            <div class="flex space-x-4">
              <a href="#" class="text-gray-400 hover:text-white transition-colors">
                <TwitterIcon class="w-5 h-5" />
              </a>
              <a href="#" class="text-gray-400 hover:text-white transition-colors">
                <FacebookIcon class="w-5 h-5" />
              </a>
              <a href="#" class="text-gray-400 hover:text-white transition-colors">
                <LinkedInIcon class="w-5 h-5" />
              </a>
              <a href="#" class="text-gray-400 hover:text-white transition-colors">
                <GitHubIcon class="w-5 h-5" />
              </a>
            </div>
          </div>

          <!-- Quick Links -->
          <div>
            <h3 class="text-sm font-semibold text-gray-200 tracking-wider uppercase mb-4">
              Quick Links
            </h3>
            <ul class="space-y-2">
              <li><Link href="/products" class="text-gray-400 hover:text-white transition-colors">Products</Link></li>
              <li><Link href="/pricing" class="text-gray-400 hover:text-white transition-colors">Pricing</Link></li>
              <li><Link href="/about" class="text-gray-400 hover:text-white transition-colors">About Us</Link></li>
              <li><Link href="/contact" class="text-gray-400 hover:text-white transition-colors">Contact</Link></li>
            </ul>
          </div>

          <!-- Support -->
          <div>
            <h3 class="text-sm font-semibold text-gray-200 tracking-wider uppercase mb-4">
              Support
            </h3>
            <ul class="space-y-2">
              <li><Link href="/help" class="text-gray-400 hover:text-white transition-colors">Help Center</Link></li>
              <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Documentation</a></li>
              <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Status</a></li>
              <li><a href="#" class="text-gray-400 hover:text-white transition-colors">API</a></li>
            </ul>
          </div>
        </div>

        <div class="border-t border-gray-800 mt-8 pt-8 flex flex-col md:flex-row justify-between items-center">
          <div class="text-gray-400 text-sm">
            © {{ currentYear }} WarehouseMaster. All rights reserved.
          </div>
          <div class="flex space-x-6 mt-4 md:mt-0">
            <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Privacy Policy</a>
            <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Terms of Service</a>
            <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">Cookie Policy</a>
          </div>
        </div>
      </div>
    </footer>
  </div>
</template>

<script setup lang="ts">
import { computed, h } from 'vue'
import { Link } from '@inertiajs/vue3'
import { useI18n } from 'vue-i18n'
import EcommerceNavbar from '@/components/EcommerceNavbar.vue'

const { t } = useI18n()

// Simple icons as components for the footer
const TwitterIcon = () => h('svg', { fill: 'currentColor', viewBox: '0 0 20 20' }, [
  h('path', { d: 'M6.29 18.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0020 3.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.073 4.073 0 01.8 7.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 010 16.407a11.616 11.616 0 006.29 1.84' })
])

const FacebookIcon = () => h('svg', { fill: 'currentColor', viewBox: '0 0 20 20' }, [
  h('path', { fillRule: 'evenodd', d: 'M20 10C20 4.477 15.523 0 10 0S0 4.477 0 10c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V10h2.54V7.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V10h2.773l-.443 2.89h-2.33v6.988C16.343 19.128 20 14.991 20 10z', clipRule: 'evenodd' })
])

const LinkedInIcon = () => h('svg', { fill: 'currentColor', viewBox: '0 0 20 20' }, [
  h('path', { fillRule: 'evenodd', d: 'M16.338 16.338H13.67V12.16c0-.995-.017-2.277-1.387-2.277-1.39 0-1.601 1.086-1.601 2.207v4.248H8.014v-8.59h2.559v1.174h.037c.356-.675 1.227-1.387 2.526-1.387 2.703 0 3.203 1.778 3.203 4.092v4.711zM5.005 6.575a1.548 1.548 0 11-.003-3.096 1.548 1.548 0 01.003 3.096zm-1.337 9.763H6.34v-8.59H3.667v8.59zM17.668 1H2.328C1.595 1 1 1.581 1 2.298v15.403C1 18.418 1.595 19 2.328 19h15.34c.734 0 1.332-.582 1.332-1.299V2.298C19 1.581 18.402 1 17.668 1z', clipRule: 'evenodd' })
])

const GitHubIcon = () => h('svg', { fill: 'currentColor', viewBox: '0 0 20 20' }, [
  h('path', { fillRule: 'evenodd', d: 'M10 0C4.477 0 0 4.484 0 10.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0110 4.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.203 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.942.359.31.678.921.678 1.856 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0020 10.017C20 4.484 15.522 0 10 0z', clipRule: 'evenodd' })
])

const currentYear = computed(() => new Date().getFullYear())
</script>