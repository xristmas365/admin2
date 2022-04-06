import colors from 'vuetify/es5/util/colors'

export default {
  ssr: false,
  name: 'AX Project',
  head: {
    titleTemplate: '%s - live-song',
    title: 'live-song',
    meta: [
      { charset: 'utf-8' },
      { name: 'viewport', content: 'width=device-width, initial-scale=1' },
      { hid: 'description', name: 'description', content: '' },
      {
        name: 'format-detection',
        content: 'telephone=no'
      }],
    link: [{ rel: 'icon', type: 'image/x-icon', href: '/favicon.ico' }]
  },
  css: [],
  plugins: [
    {
      src: '~/plugins/draggable.js',
      mode: 'client'
    }
  ],
  components: true,
  buildModules: [
    '@nuxtjs/vuetify'
  ],
  modules: [
    '@nuxtjs/axios',
    '@nuxtjs/auth-next',
    'vue-toastification/nuxt'
  ],
  axios: {
    baseURL: '/',
    proxy: true
  },
  proxy: {
    '/api/': { target: process.env.API_URL }
  },
  auth: {
    redirect: {
      login: '/login',
      logout: '/login',
      user: '/account',
      home: '/admin',
      callback: '/'
    },
    strategies: {
      local: {
        token: {
          property: 'token',
          global: true,
          required: true,
          type: 'Bearer'
        },
        user: {
          property: 'user',
          autoFetch: true
        },
        endpoints: {
          login: { url: '/api/login', method: 'post' },
          logout: { url: '/api/auth/logout', method: 'post' },
          user: { url: '/api/auth/user', method: 'get' }
        }
      }
    }
  },
  vuetify: {
    customVariables: ['~/assets/variables.scss'],
    theme: {
      themes: {
        dark: {
          primary: colors.blue.darken2,
          accent: colors.grey.darken3,
          secondary: colors.amber.darken3,
          info: colors.teal.lighten1,
          warning: colors.amber.base,
          error: colors.deepOrange.accent4,
          success: colors.green.accent3
        }
      }
    }
  },
  build: {}
}
