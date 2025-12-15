<template>
  <EcommerceLayout>
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-green-900 via-green-800 to-green-900 py-24">
      <div class="absolute inset-0 bg-slate-900/20"></div>
      <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl lg:text-6xl font-bold text-white mb-6">
          About Warehouse Master
        </h1>
        <p class="text-xl text-green-100 leading-relaxed">
          We're revolutionizing warehouse management with innovative technology that empowers businesses to optimize their operations and drive growth.
        </p>
      </div>
    </section>

    <!-- Mission & Vision -->
    <section class="py-20">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
          <div>
            <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-6">Our Mission</h2>
            <p class="text-lg text-gray-600 mb-6 leading-relaxed">
              To democratize advanced warehouse management technology and make it accessible to businesses of all sizes. 
              We believe every warehouse operation deserves the tools to maximize efficiency, reduce costs, and scale sustainably.
            </p>
            <p class="text-lg text-gray-600 leading-relaxed">
              Through intuitive design, cutting-edge automation, and unwavering support, we're transforming how warehouses operate in the digital age.
            </p>
          </div>
          <div class="relative">
            <div class="absolute inset-0 bg-gradient-to-r from-green-600 to-green-600 rounded-2xl transform rotate-3"></div>
            <div class="relative rounded-2xl shadow-2xl transform -rotate-1 hover:rotate-0 transition-transform duration-500 bg-gradient-to-br from-slate-100 to-slate-200 p-8 flex items-center justify-center min-h-[400px]">
              <!-- Warehouse illustration -->
              <svg viewBox="0 0 400 300" class="w-full h-full max-w-md text-slate-600">
                <!-- Warehouse building -->
                <rect x="50" y="120" width="300" height="120" fill="currentColor" opacity="0.1" rx="8"/>
                <rect x="50" y="120" width="300" height="120" fill="none" stroke="currentColor" stroke-width="2" rx="8"/>
                
                <!-- Roof -->
                <path d="M30 130 L200 60 L370 130 L350 130 L200 80 L70 130 Z" fill="currentColor" opacity="0.2"/>
                <path d="M30 130 L200 60 L370 130" fill="none" stroke="currentColor" stroke-width="2"/>
                
                <!-- Windows/doors -->
                <rect x="80" y="160" width="40" height="60" fill="currentColor" opacity="0.1" rx="4"/>
                <rect x="140" y="160" width="40" height="60" fill="currentColor" opacity="0.1" rx="4"/>
                <rect x="200" y="140" width="60" height="80" fill="currentColor" opacity="0.1" rx="4"/>
                <rect x="280" y="160" width="40" height="60" fill="currentColor" opacity="0.1" rx="4"/>
                
                <!-- Loading dock -->
                <rect x="180" y="220" width="100" height="20" fill="currentColor" opacity="0.2"/>
                
                <!-- Truck -->
                <rect x="300" y="200" width="80" height="30" fill="currentColor" opacity="0.3" rx="4"/>
                <circle cx="320" cy="235" r="8" fill="currentColor" opacity="0.4"/>
                <circle cx="360" cy="235" r="8" fill="currentColor" opacity="0.4"/>
                
                <!-- Boxes/inventory -->
                <rect x="70" y="200" width="15" height="15" fill="#f59e0b" opacity="0.8"/>
                <rect x="90" y="200" width="15" height="15" fill="#10b981" opacity="0.8"/>
                <rect x="110" y="200" width="15" height="15" fill="#3b82f6" opacity="0.8"/>
              </svg>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Our Story -->
    <section class="py-20 bg-gray-50">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-8">Our Story</h2>
        <div class="prose prose-lg mx-auto text-gray-600">
          <p class="mb-6">
            Founded in 2018 by a team of warehouse operations experts and software engineers, WarehouseMaster was born from the 
            frustration of watching businesses struggle with outdated, complex warehouse management systems.
          </p>
          <p class="mb-6">
            Our founders had seen firsthand how the right technology could transform warehouse operations, but existing solutions 
            were often too expensive, too complex, or too rigid for most businesses to implement successfully.
          </p>
          <p>
            Today, we're proud to serve over 10,000 warehouses worldwide, from small family businesses to large enterprise operations, 
            helping them streamline their processes, reduce errors, and grow their businesses.
          </p>
        </div>
      </div>
    </section>

    <!-- Values -->
    <section class="py-20">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Our Values</h2>
          <p class="text-xl text-gray-600">The principles that guide everything we do</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div v-for="value in values" :key="value.id" class="text-center group">
            <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-green-600 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
              <component :is="value.icon" class="w-8 h-8 text-white" />
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-3">{{ value.title }}</h3>
            <p class="text-gray-600 leading-relaxed">{{ value.description }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Team -->
    <section class="py-20 bg-gray-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">Meet Our Team</h2>
          <p class="text-xl text-gray-600">The passionate people behind WarehouseMaster</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div v-for="member in teamMembers" :key="member.id" class="bg-white rounded-2xl p-8 text-center shadow-lg hover:shadow-xl transition-shadow">
            <img 
              :src="member.avatar" 
              :alt="member.name" 
              class="w-24 h-24 rounded-full mx-auto mb-6 object-cover"
            />
            <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ member.name }}</h3>
            <p class="text-green-600 font-medium mb-4">{{ member.role }}</p>
            <p class="text-gray-600 mb-6">{{ member.bio }}</p>
            
            <div class="flex justify-center space-x-4">
              <a v-if="member.linkedin" :href="member.linkedin" class="text-gray-400 hover:text-green-600 transition-colors">
                <LinkedInIcon class="w-5 h-5" />
              </a>
              <a v-if="member.twitter" :href="member.twitter" class="text-gray-400 hover:text-green-600 transition-colors">
                <TwitterIcon class="w-5 h-5" />
              </a>
              <a v-if="member.email" :href="`mailto:${member.email}`" class="text-gray-400 hover:text-green-600 transition-colors">
                <EnvelopeIcon class="w-5 h-5" />
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Stats -->
    <section class="py-20 bg-gradient-to-r from-green-900 to-green-800">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
          <h2 class="text-3xl lg:text-4xl font-bold text-white mb-4">
            Warehouse Master by the Numbers
          </h2>
          <p class="text-xl text-green-100">
            Our impact in the warehouse management industry
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
          <div v-for="stat in companyStats" :key="stat.label" class="text-center">
            <div class="text-4xl lg:text-5xl font-bold text-white mb-2">
              {{ stat.value }}
            </div>
            <div class="text-green-100 text-lg">{{ stat.label }}</div>
            <div class="text-green-200 text-sm mt-2">{{ stat.description }}</div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA -->
    <section class="py-20">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-6">
          Ready to Join Our Success Story?
        </h2>
        <p class="text-xl text-gray-600 mb-8">
          Discover how Warehouse Master can transform your warehouse operations and help you achieve your business goals.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
          <Button size="lg" class="text-lg px-8 py-4">
            Start Your Free Trial
          </Button>
          <Button variant="outline" size="lg" class="text-lg px-8 py-4">
            Schedule a Demo
          </Button>
        </div>
      </div>
    </section>
  </EcommerceLayout>
</template>

<script setup lang="ts">
import { ref, h } from 'vue'
import EcommerceLayout from '@/layouts/EcommerceLayout.vue'
import { Button } from '@/components/ui/button'
import { 
  HeartIcon,
  LightBulbIcon,
  ShieldCheckIcon,
  RocketLaunchIcon,
  UsersIcon,
  SparklesIcon,
  EnvelopeIcon
} from '@heroicons/vue/24/outline'

// Simple icons for social media
const LinkedInIcon = () => h('svg', { fill: 'currentColor', viewBox: '0 0 20 20' }, [
  h('path', { fillRule: 'evenodd', d: 'M16.338 16.338H13.67V12.16c0-.995-.017-2.277-1.387-2.277-1.39 0-1.601 1.086-1.601 2.207v4.248H8.014v-8.59h2.559v1.174h.037c.356-.675 1.227-1.387 2.526-1.387 2.703 0 3.203 1.778 3.203 4.092v4.711zM5.005 6.575a1.548 1.548 0 11-.003-3.096 1.548 1.548 0 01.003 3.096zm-1.337 9.763H6.34v-8.59H3.667v8.59zM17.668 1H2.328C1.595 1 1 1.581 1 2.298v15.403C1 18.418 1.595 19 2.328 19h15.34c.734 0 1.332-.582 1.332-1.299V2.298C19 1.581 18.402 1 17.668 1z', clipRule: 'evenodd' })
])

const TwitterIcon = () => h('svg', { fill: 'currentColor', viewBox: '0 0 20 20' }, [
  h('path', { d: 'M6.29 18.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0020 3.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.073 4.073 0 01.8 7.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 010 16.407a11.616 11.616 0 006.29 1.84' })
])

const values = ref([
  {
    id: 1,
    icon: HeartIcon,
    title: 'Customer-Centric',
    description: 'Every decision we make is guided by what\'s best for our customers and their success.'
  },
  {
    id: 2,
    icon: LightBulbIcon,
    title: 'Innovation',
    description: 'We continuously push the boundaries of what\'s possible in warehouse management technology.'
  },
  {
    id: 3,
    icon: ShieldCheckIcon,
    title: 'Reliability',
    description: 'Our customers depend on us, and we take that responsibility seriously with 99.9% uptime.'
  },
  {
    id: 4,
    icon: RocketLaunchIcon,
    title: 'Growth',
    description: 'We help our customers grow, and we grow alongside them as trusted partners.'
  },
  {
    id: 5,
    icon: UsersIcon,
    title: 'Collaboration',
    description: 'Great solutions come from working closely with our customers and listening to their needs.'
  },
  {
    id: 6,
    icon: SparklesIcon,
    title: 'Excellence',
    description: 'We strive for excellence in everything we do, from code quality to customer support.'
  }
])

const teamMembers = ref([
  {
    id: 1,
    name: 'Sarah Chen',
    role: 'CEO & Co-Founder',
    bio: 'Former operations director with 15+ years in supply chain management. Passionate about making warehouse operations more efficient.',
    avatar: 'https://images.unsplash.com/photo-1494790108755-2616b612b786?w=150&h=150&fit=crop&crop=face',
    linkedin: '#',
    twitter: '#',
    email: 'sarah@warehousemaster.com'
  },
  {
    id: 2,
    name: 'Michael Rodriguez',
    role: 'CTO & Co-Founder',
    bio: 'Software architect with expertise in scalable systems. Previously led engineering teams at major logistics companies.',
    avatar: 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150&h=150&fit=crop&crop=face',
    linkedin: '#',
    twitter: '#',
    email: 'michael@warehousemaster.com'
  },
  {
    id: 3,
    name: 'Emily Johnson',
    role: 'VP of Product',
    bio: 'Product strategist focused on user experience. Ensures our platform remains intuitive and powerful for all users.',
    avatar: 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150&h=150&fit=crop&crop=face',
    linkedin: '#',
    email: 'emily@warehousemaster.com'
  },
  {
    id: 4,
    name: 'David Kim',
    role: 'Head of Engineering',
    bio: 'Full-stack developer passionate about building robust, scalable solutions for complex warehouse operations.',
    avatar: 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150&h=150&fit=crop&crop=face',
    linkedin: '#',
    twitter: '#',
    email: 'david@warehousemaster.com'
  },
  {
    id: 5,
    name: 'Lisa Thompson',
    role: 'Customer Success Director',
    bio: 'Dedicated to ensuring every customer achieves their goals. 10+ years in customer success and account management.',
    avatar: 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=150&h=150&fit=crop&crop=face',
    linkedin: '#',
    email: 'lisa@warehousemaster.com'
  },
  {
    id: 6,
    name: 'James Wilson',
    role: 'Head of Sales',
    bio: 'Sales leader with deep understanding of warehouse operations. Helps businesses find the right solution for their needs.',
    avatar: 'https://images.unsplash.com/photo-1560250097-0b93528c311a?w=150&h=150&fit=crop&crop=face',
    linkedin: '#',
    twitter: '#',
    email: 'james@warehousemaster.com'
  }
])

const companyStats = ref([
  {
    value: '10,000+',
    label: 'Active Warehouses',
    description: 'Across 45 countries worldwide'
  },
  {
    value: '99.9%',
    label: 'System Uptime',
    description: 'Reliable 24/7 operations'
  },
  {
    value: '50M+',
    label: 'Items Tracked',
    description: 'Processed monthly'
  },
  {
    value: '6 Years',
    label: 'Industry Experience',
    description: 'Continuous innovation'
  }
])
</script>