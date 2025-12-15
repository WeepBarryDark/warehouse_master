<template>
  <EcommerceLayout>
    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-blue-50 to-purple-50 py-16">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
          Get in Touch
        </h1>
        <p class="text-xl text-gray-600">
          We'd love to hear from you. Send us a message and we'll respond as soon as possible.
        </p>
      </div>
    </section>

    <!-- Contact Methods -->
    <section class="py-20">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-16">
          <div v-for="method in contactMethods" :key="method.id" class="text-center group">
            <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-500 rounded-2xl flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
              <component :is="method.icon" class="w-8 h-8 text-white" />
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-3">{{ method.title }}</h3>
            <p class="text-gray-600 mb-4">{{ method.description }}</p>
            <div class="text-blue-600 font-medium">{{ method.contact }}</div>
          </div>
        </div>

        <!-- Contact Form and Office Info -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
          <!-- Contact Form -->
          <div class="bg-white rounded-2xl border border-gray-200 p-8 shadow-lg">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Send us a Message</h2>
            
            <form @submit.prevent="submitForm" class="space-y-6">
              <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                  <label for="firstName" class="block text-sm font-medium text-gray-700 mb-2">
                    First Name *
                  </label>
                  <input
                    id="firstName"
                    v-model="form.firstName"
                    type="text"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                    placeholder="John"
                  />
                </div>
                <div>
                  <label for="lastName" class="block text-sm font-medium text-gray-700 mb-2">
                    Last Name *
                  </label>
                  <input
                    id="lastName"
                    v-model="form.lastName"
                    type="text"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                    placeholder="Doe"
                  />
                </div>
              </div>

              <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                  Email Address *
                </label>
                <input
                  id="email"
                  v-model="form.email"
                  type="email"
                  required
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                  placeholder="john@company.com"
                />
              </div>

              <div>
                <label for="company" class="block text-sm font-medium text-gray-700 mb-2">
                  Company
                </label>
                <input
                  id="company"
                  v-model="form.company"
                  type="text"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                  placeholder="Your Company"
                />
              </div>

              <div>
                <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                  Subject *
                </label>
                <select
                  id="subject"
                  v-model="form.subject"
                  required
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                >
                  <option value="">Select a subject</option>
                  <option value="general">General Inquiry</option>
                  <option value="sales">Sales Question</option>
                  <option value="support">Technical Support</option>
                  <option value="partnership">Partnership</option>
                  <option value="demo">Request Demo</option>
                  <option value="other">Other</option>
                </select>
              </div>

              <div>
                <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                  Message *
                </label>
                <textarea
                  id="message"
                  v-model="form.message"
                  required
                  rows="5"
                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all resize-none"
                  placeholder="Tell us how we can help you..."
                ></textarea>
              </div>

              <div class="flex items-start">
                <input
                  id="newsletter"
                  v-model="form.newsletter"
                  type="checkbox"
                  class="mt-1 mr-3 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                />
                <label for="newsletter" class="text-sm text-gray-700">
                  I'd like to receive product updates and marketing communications
                </label>
              </div>

              <Button 
                type="submit" 
                :disabled="submitting"
                class="w-full text-lg py-3"
              >
                <span v-if="submitting">Sending...</span>
                <span v-else>Send Message</span>
              </Button>
            </form>
          </div>

          <!-- Office Information -->
          <div class="space-y-8">
            <!-- Global Offices -->
            <div class="bg-gray-50 rounded-2xl p-8">
              <h2 class="text-2xl font-bold text-gray-900 mb-6">Our Offices</h2>
              
              <div class="space-y-6">
                <div v-for="office in offices" :key="office.id" class="border-l-4 border-blue-500 pl-6">
                  <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ office.city }}</h3>
                  <p class="text-gray-600 mb-2">{{ office.address }}</p>
                  <div class="flex items-center text-sm text-gray-500 mb-1">
                    <PhoneIcon class="w-4 h-4 mr-2" />
                    {{ office.phone }}
                  </div>
                  <div class="flex items-center text-sm text-gray-500">
                    <ClockIcon class="w-4 h-4 mr-2" />
                    {{ office.hours }}
                  </div>
                </div>
              </div>
            </div>

            <!-- FAQ Quick Links -->
            <div class="bg-gradient-to-r from-blue-500 to-purple-500 rounded-2xl p-8 text-white">
              <h3 class="text-xl font-semibold mb-4">Quick Help</h3>
              <p class="mb-6 text-blue-100">
                Looking for immediate assistance? Check out these resources.
              </p>
              <div class="space-y-3">
                <a href="/help" class="flex items-center text-blue-100 hover:text-white transition-colors">
                  <QuestionMarkCircleIcon class="w-5 h-5 mr-3" />
                  Help Center & FAQ
                </a>
                <a href="#" class="flex items-center text-blue-100 hover:text-white transition-colors">
                  <DocumentTextIcon class="w-5 h-5 mr-3" />
                  Documentation
                </a>
                <a href="#" class="flex items-center text-blue-100 hover:text-white transition-colors">
                  <VideoCameraIcon class="w-5 h-5 mr-3" />
                  Video Tutorials
                </a>
                <a href="#" class="flex items-center text-blue-100 hover:text-white transition-colors">
                  <ChatBubbleLeftRightIcon class="w-5 h-5 mr-3" />
                  Live Chat Support
                </a>
              </div>
            </div>

            <!-- Response Time -->
            <div class="bg-green-50 rounded-2xl p-6 text-center">
              <ClockIcon class="w-12 h-12 text-green-500 mx-auto mb-4" />
              <h3 class="text-lg font-semibold text-gray-900 mb-2">Quick Response</h3>
              <p class="text-gray-600">
                We typically respond to all inquiries within 24 hours during business days.
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Map Section (Placeholder) -->
    <section class="py-20 bg-gray-50">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
          <h2 class="text-3xl font-bold text-gray-900 mb-4">Visit Our Headquarters</h2>
          <p class="text-xl text-gray-600">Located in the heart of San Francisco's tech district</p>
        </div>
        
        <!-- Map Placeholder -->
        <div class="bg-gray-300 rounded-2xl h-96 flex items-center justify-center">
          <div class="text-center">
            <MapIcon class="w-16 h-16 text-gray-500 mx-auto mb-4" />
            <p class="text-gray-600">Interactive map would be integrated here</p>
            <p class="text-sm text-gray-500 mt-2">
              123 Tech Street, San Francisco, CA 94105
            </p>
          </div>
        </div>
      </div>
    </section>
  </EcommerceLayout>
</template>

<script setup lang="ts">
import { ref, reactive } from 'vue'
import EcommerceLayout from '@/layouts/EcommerceLayout.vue'
import { Button } from '@/components/ui/button'
import { 
  PhoneIcon,
  EnvelopeIcon,
  MapPinIcon,
  ClockIcon,
  QuestionMarkCircleIcon,
  DocumentTextIcon,
  VideoCameraIcon,
  ChatBubbleLeftRightIcon,
  MapIcon
} from '@heroicons/vue/24/outline'

const submitting = ref(false)

const form = reactive({
  firstName: '',
  lastName: '',
  email: '',
  company: '',
  subject: '',
  message: '',
  newsletter: false
})

const contactMethods = ref([
  {
    id: 1,
    icon: PhoneIcon,
    title: 'Call Us',
    description: 'Speak directly with our support team',
    contact: '+1 (555) 123-4567'
  },
  {
    id: 2,
    icon: EnvelopeIcon,
    title: 'Email Us',
    description: 'Send us an email anytime',
    contact: 'hello@warehousemaster.com'
  },
  {
    id: 3,
    icon: MapPinIcon,
    title: 'Visit Us',
    description: 'Come to our office in San Francisco',
    contact: '123 Tech Street, SF, CA 94105'
  }
])

const offices = ref([
  {
    id: 1,
    city: 'San Francisco, CA',
    address: '123 Tech Street, San Francisco, CA 94105',
    phone: '+1 (555) 123-4567',
    hours: 'Mon-Fri 9:00 AM - 6:00 PM PST'
  },
  {
    id: 2,
    city: 'New York, NY',
    address: '456 Business Ave, New York, NY 10001',
    phone: '+1 (555) 987-6543',
    hours: 'Mon-Fri 9:00 AM - 6:00 PM EST'
  },
  {
    id: 3,
    city: 'London, UK',
    address: '789 Commerce Road, London, EC1A 1BB',
    phone: '+44 20 7946 0958',
    hours: 'Mon-Fri 9:00 AM - 5:00 PM GMT'
  }
])

const submitForm = async () => {
  submitting.value = true
  
  try {
    // Simulate form submission
    await new Promise(resolve => setTimeout(resolve, 2000))
    
    // Here you would typically send the form data to your backend
    console.log('Form submitted:', form)
    
    // Reset form
    Object.assign(form, {
      firstName: '',
      lastName: '',
      email: '',
      company: '',
      subject: '',
      message: '',
      newsletter: false
    })
    
    // Show success message (you might want to use a toast notification)
    alert('Thank you for your message! We\'ll get back to you soon.')
    
  } catch (error) {
    console.error('Error submitting form:', error)
    alert('Sorry, there was an error sending your message. Please try again.')
  } finally {
    submitting.value = false
  }
}
</script>