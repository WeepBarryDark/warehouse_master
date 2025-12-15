<template>
  <EcommerceLayout>
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-50 to-purple-50 py-16">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
          Help Center
        </h1>
        <p class="text-xl text-gray-600 mb-8">
          Find answers to your questions and get the support you need
        </p>
        
        <!-- Search Bar -->
        <div class="max-w-2xl mx-auto relative">
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Search for help articles, tutorials, or FAQs..."
            class="w-full px-6 py-4 pr-12 text-lg border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent shadow-lg"
          />
          <MagnifyingGlassIcon class="absolute right-4 top-1/2 transform -translate-y-1/2 w-6 h-6 text-gray-400" />
        </div>
      </div>
    </section>

    <!-- Quick Links -->
    <section class="py-20">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
          <h2 class="text-3xl font-bold text-gray-900 mb-4">Popular Help Topics</h2>
          <p class="text-xl text-gray-600">Quick access to the most requested information</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div
            v-for="topic in quickTopics"
            :key="topic.id"
            class="bg-white rounded-2xl border border-gray-200 p-6 hover:shadow-xl hover:border-blue-300 transition-all duration-300 cursor-pointer group"
          >
            <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-500 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
              <component :is="topic.icon" class="w-6 h-6 text-white" />
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ topic.title }}</h3>
            <p class="text-gray-600 mb-4">{{ topic.description }}</p>
            <div class="flex items-center text-blue-600 font-medium">
              <span>Learn more</span>
              <ArrowRightIcon class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" />
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-20 bg-gray-50">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
          <h2 class="text-3xl font-bold text-gray-900 mb-4">Frequently Asked Questions</h2>
          <p class="text-xl text-gray-600">Find quick answers to common questions</p>
        </div>

        <!-- FAQ Categories -->
        <div class="flex flex-wrap justify-center gap-4 mb-8">
          <Button
            v-for="category in faqCategories"
            :key="category.id"
            :variant="selectedFaqCategory === category.id ? 'default' : 'outline'"
            @click="selectedFaqCategory = category.id"
            class="px-6 py-2"
          >
            {{ category.name }}
          </Button>
        </div>

        <!-- FAQ Items -->
        <div class="space-y-4">
          <div
            v-for="faq in filteredFaqs"
            :key="faq.id"
            class="bg-white rounded-2xl border border-gray-200 overflow-hidden"
          >
            <button
              @click="toggleFaq(faq.id)"
              class="w-full px-6 py-4 text-left flex items-center justify-between hover:bg-gray-50 transition-colors"
            >
              <span class="font-semibold text-gray-900">{{ faq.question }}</span>
              <ChevronDownIcon 
                :class="[
                  'w-5 h-5 text-gray-500 transition-transform',
                  openFaqs.includes(faq.id) ? 'rotate-180' : ''
                ]"
              />
            </button>
            <div 
              v-if="openFaqs.includes(faq.id)"
              class="px-6 pb-4 text-gray-600 leading-relaxed"
            >
              {{ faq.answer }}
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Resources Section -->
    <section class="py-20">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
          <h2 class="text-3xl font-bold text-gray-900 mb-4">Additional Resources</h2>
          <p class="text-xl text-gray-600">Dive deeper with our comprehensive guides and tutorials</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <div
            v-for="resource in resources"
            :key="resource.id"
            class="bg-white rounded-2xl border border-gray-200 overflow-hidden hover:shadow-xl transition-shadow"
          >
            <div class="p-6">
              <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-500 rounded-xl flex items-center justify-center mb-4">
                <component :is="resource.icon" class="w-6 h-6 text-white" />
              </div>
              <h3 class="text-xl font-semibold text-gray-900 mb-3">{{ resource.title }}</h3>
              <p class="text-gray-600 mb-4">{{ resource.description }}</p>
              <div class="flex items-center justify-between">
                <span class="text-sm text-gray-500">{{ resource.articles }} articles</span>
                <Button variant="outline" size="sm">
                  Browse
                </Button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Contact Support -->
    <section class="py-20 bg-gradient-to-r from-blue-900 to-purple-900">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl lg:text-4xl font-bold text-white mb-6">
          Still Need Help?
        </h2>
        <p class="text-xl text-blue-100 mb-8">
          Our support team is here to help you succeed. Get in touch with us directly.
        </p>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
          <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 text-white">
            <ChatBubbleLeftRightIcon class="w-8 h-8 mx-auto mb-4" />
            <h3 class="font-semibold mb-2">Live Chat</h3>
            <p class="text-blue-100 text-sm mb-4">Get instant help from our support team</p>
            <Button variant="outline" class="border-white text-white hover:bg-white hover:text-blue-900">
              Start Chat
            </Button>
          </div>
          
          <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 text-white">
            <EnvelopeIcon class="w-8 h-8 mx-auto mb-4" />
            <h3 class="font-semibold mb-2">Email Support</h3>
            <p class="text-blue-100 text-sm mb-4">Send us a detailed message</p>
            <Button variant="outline" class="border-white text-white hover:bg-white hover:text-blue-900">
              Send Email
            </Button>
          </div>
          
          <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 text-white">
            <PhoneIcon class="w-8 h-8 mx-auto mb-4" />
            <h3 class="font-semibold mb-2">Phone Support</h3>
            <p class="text-blue-100 text-sm mb-4">Speak directly with our experts</p>
            <Button variant="outline" class="border-white text-white hover:bg-white hover:text-blue-900">
              Call Now
            </Button>
          </div>
        </div>

        <div class="text-blue-100">
          <p class="mb-2">Our support hours: Monday - Friday, 9:00 AM - 6:00 PM PST</p>
          <p>Average response time: Less than 2 hours</p>
        </div>
      </div>
    </section>
  </EcommerceLayout>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue'
import EcommerceLayout from '@/layouts/EcommerceLayout.vue'
import { Button } from '@/components/ui/button'
import { 
  MagnifyingGlassIcon,
  ArrowRightIcon,
  ChevronDownIcon,
  ChatBubbleLeftRightIcon,
  EnvelopeIcon,
  PhoneIcon,
  CogIcon,
  QuestionMarkCircleIcon,
  DocumentTextIcon,
  VideoCameraIcon,
  AcademicCapIcon,
  BugAntIcon,
  RocketLaunchIcon,
  ShieldCheckIcon,
  CreditCardIcon,
  UsersIcon
} from '@heroicons/vue/24/outline'

const searchQuery = ref('')
const selectedFaqCategory = ref('all')
const openFaqs = ref<number[]>([])

const toggleFaq = (id: number) => {
  if (openFaqs.value.includes(id)) {
    openFaqs.value = openFaqs.value.filter(faqId => faqId !== id)
  } else {
    openFaqs.value.push(id)
  }
}

const quickTopics = ref([
  {
    id: 1,
    icon: RocketLaunchIcon,
    title: 'Getting Started',
    description: 'Learn the basics of setting up and using WarehouseMaster'
  },
  {
    id: 2,
    icon: CogIcon,
    title: 'System Setup',
    description: 'Configure your warehouse settings and preferences'
  },
  {
    id: 3,
    icon: UsersIcon,
    title: 'User Management',
    description: 'Add team members and manage user permissions'
  },
  {
    id: 4,
    icon: DocumentTextIcon,
    title: 'Integrations',
    description: 'Connect with your existing tools and systems'
  },
  {
    id: 5,
    icon: ShieldCheckIcon,
    title: 'Security',
    description: 'Keep your data safe with our security features'
  },
  {
    id: 6,
    icon: CreditCardIcon,
    title: 'Billing & Plans',
    description: 'Manage your subscription and payment information'
  }
])

const faqCategories = ref([
  { id: 'all', name: 'All Questions' },
  { id: 'general', name: 'General' },
  { id: 'technical', name: 'Technical' },
  { id: 'billing', name: 'Billing' },
  { id: 'integrations', name: 'Integrations' }
])

const faqs = ref([
  {
    id: 1,
    category: 'general',
    question: 'How do I get started with WarehouseMaster?',
    answer: 'Getting started is easy! Sign up for a free trial, complete the onboarding process, and our team will help you set up your first warehouse. We provide step-by-step guidance and can migrate your existing data.'
  },
  {
    id: 2,
    category: 'general',
    question: 'What types of warehouses can use WarehouseMaster?',
    answer: 'WarehouseMaster works for all types of warehouses including e-commerce fulfillment centers, retail distribution centers, manufacturing warehouses, and third-party logistics providers.'
  },
  {
    id: 3,
    category: 'technical',
    question: 'Do you offer mobile apps?',
    answer: 'Yes! We have mobile apps for both iOS and Android that allow your warehouse staff to scan items, update inventory, and manage tasks on the go. The apps work offline and sync when connected.'
  },
  {
    id: 4,
    category: 'technical',
    question: 'What barcode formats do you support?',
    answer: 'We support all major barcode formats including UPC, EAN, Code 128, Code 39, and QR codes. You can also generate custom barcodes for your internal inventory.'
  },
  {
    id: 5,
    category: 'billing',
    question: 'Can I change my plan at any time?',
    answer: 'Absolutely! You can upgrade or downgrade your plan at any time. Changes take effect immediately, and we handle all the billing adjustments automatically.'
  },
  {
    id: 6,
    category: 'billing',
    question: 'Do you offer discounts for annual billing?',
    answer: 'Yes, we offer a 20% discount when you choose annual billing. This applies to all our plans and helps you save significantly on your warehouse management costs.'
  },
  {
    id: 7,
    category: 'integrations',
    question: 'Which e-commerce platforms do you integrate with?',
    answer: 'We integrate with all major e-commerce platforms including Shopify, WooCommerce, Amazon, eBay, Magento, and BigCommerce. Custom integrations are available for Enterprise customers.'
  },
  {
    id: 8,
    category: 'integrations',
    question: 'Can you integrate with our existing ERP system?',
    answer: 'Yes! We have pre-built integrations with popular ERP systems like SAP, Oracle, and NetSuite. For custom ERP systems, our team can develop a tailored integration solution.'
  }
])

const resources = ref([
  {
    id: 1,
    icon: AcademicCapIcon,
    title: 'Getting Started Guide',
    description: 'Step-by-step tutorials for new users',
    articles: 12
  },
  {
    id: 2,
    icon: VideoCameraIcon,
    title: 'Video Tutorials',
    description: 'Watch and learn with our video library',
    articles: 25
  },
  {
    id: 3,
    icon: DocumentTextIcon,
    title: 'API Documentation',
    description: 'Technical docs for developers',
    articles: 48
  },
  {
    id: 4,
    icon: BugAntIcon,
    title: 'Troubleshooting',
    description: 'Solutions to common issues',
    articles: 18
  },
  {
    id: 5,
    icon: CogIcon,
    title: 'Advanced Features',
    description: 'Make the most of WarehouseMaster',
    articles: 32
  },
  {
    id: 6,
    icon: ShieldCheckIcon,
    title: 'Security Guide',
    description: 'Best practices for data security',
    articles: 8
  }
])

const filteredFaqs = computed(() => {
  if (selectedFaqCategory.value === 'all') {
    return faqs.value
  }
  return faqs.value.filter(faq => faq.category === selectedFaqCategory.value)
})
</script>