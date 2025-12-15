import { createI18n } from 'vue-i18n'
import en from './locales/en.json'
import zh from './locales/zh.json'

const messages = {
  en,
  'zh-CN': zh
}

export const SUPPORTED_LOCALES = [
  { code: 'en', name: 'English', flag: '🇺🇸' },
  { code: 'zh-CN', name: '中文', flag: '🇨🇳' }
]

export const SUPPORTED_TIMEZONES = [
  // Australia
  { code: 'Australia/Sydney', name: 'Australia - Sydney (AEDT/AEST)', offset: '+11:00', region: 'Australia' },
  { code: 'Australia/Melbourne', name: 'Australia - Melbourne (AEDT/AEST)', offset: '+11:00', region: 'Australia' },
  { code: 'Australia/Brisbane', name: 'Australia - Brisbane (AEST)', offset: '+10:00', region: 'Australia' },
  { code: 'Australia/Perth', name: 'Australia - Perth (AWST)', offset: '+08:00', region: 'Australia' },
  { code: 'Australia/Adelaide', name: 'Australia - Adelaide (ACDT/ACST)', offset: '+10:30', region: 'Australia' },
  { code: 'Australia/Hobart', name: 'Australia - Hobart (AEDT/AEST)', offset: '+11:00', region: 'Australia' },
  { code: 'Australia/Darwin', name: 'Australia - Darwin (ACST)', offset: '+09:30', region: 'Australia' },
  { code: 'Australia/Canberra', name: 'Australia - Canberra (AEDT/AEST)', offset: '+11:00', region: 'Australia' },

  // New Zealand
  { code: 'Pacific/Auckland', name: 'New Zealand - Auckland (NZDT/NZST)', offset: '+13:00', region: 'New Zealand' },
  { code: 'Pacific/Chatham', name: 'New Zealand - Chatham Islands (CHADT/CHAST)', offset: '+13:45', region: 'New Zealand' },

  // China
  { code: 'Asia/Shanghai', name: 'China - Shanghai (CST)', offset: '+08:00', region: 'China' },
  { code: 'Asia/Hong_Kong', name: 'Hong Kong (HKT)', offset: '+08:00', region: 'China' },

  // UTC (for reference)
  { code: 'UTC', name: 'UTC (Coordinated Universal Time)', offset: '+00:00', region: 'UTC' }
]

function getDefaultLocale() {
  // Check for stored preference
  const stored = localStorage.getItem('warehouse-locale')
  if (stored && messages[stored as keyof typeof messages]) {
    return stored
  }
  
  // Check browser language
  const browserLang = navigator.language
  if (messages[browserLang as keyof typeof messages]) {
    return browserLang
  }
  
  // Fallback to English
  return 'en'
}

export function getDefaultTimezone() {
  // Check for stored preference
  const stored = localStorage.getItem('warehouse-timezone')
  if (stored) {
    return stored
  }
  
  // Try to detect user's timezone
  try {
    const detected = Intl.DateTimeFormat().resolvedOptions().timeZone
    const supported = SUPPORTED_TIMEZONES.find(tz => tz.code === detected)
    if (supported) {
      return detected
    }
  } catch (e) {
    console.warn('Could not detect timezone:', e)
  }
  
  // Fallback to UTC
  return 'UTC'
}

export const i18n = createI18n({
  legacy: false,
  locale: getDefaultLocale(),
  fallbackLocale: 'en',
  messages,
  numberFormats: {
    en: {
      currency: {
        style: 'currency',
        currency: 'USD'
      },
      decimal: {
        style: 'decimal',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      }
    },
    'zh-CN': {
      currency: {
        style: 'currency',
        currency: 'CNY'
      },
      decimal: {
        style: 'decimal',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      }
    }
  },
  datetimeFormats: {
    en: {
      short: {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
      },
      long: {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        weekday: 'long',
        hour: 'numeric',
        minute: 'numeric'
      }
    },
    'zh-CN': {
      short: {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
      },
      long: {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        weekday: 'long',
        hour: 'numeric',
        minute: 'numeric'
      }
    }
  }
})

export function setLocale(locale: string) {
  i18n.global.locale.value = locale
  localStorage.setItem('warehouse-locale', locale)
  document.documentElement.setAttribute('lang', locale)
}

export function setTimezone(timezone: string) {
  localStorage.setItem('warehouse-timezone', timezone)
  // Optionally trigger a global event for components to react to timezone changes
  window.dispatchEvent(new CustomEvent('timezone-changed', { detail: { timezone } }))
}