<template>
  <v-app dark>
    <v-navigation-drawer v-model="drawer" app clipped>
      <Menu />
    </v-navigation-drawer>
    <v-app-bar fixed app clipped-left>
      <v-app-bar-nav-icon @click.stop="drawer = !drawer" />
      <v-toolbar-title>
        <nuxt-link to="/" class="text-uppercase text-decoration-none text--primary">
          {{ title }}
        </nuxt-link>
      </v-toolbar-title>
      <v-spacer />
      <v-btn @click="logout">
        Logout
      </v-btn>
    </v-app-bar>
    <v-main>
      <v-container>
        <Nuxt />
      </v-container>
    </v-main>
    <v-footer absolute app>
      <span>&copy; {{ new Date().getFullYear() }}</span>
    </v-footer>
  </v-app>
</template>

<script>
export default {
  name: 'DefaultLayout',
  data () {
    return {
      drawer: null,
      title: 'AX Project'
    }
  },
  methods: {
    async logout () {
      await this.$auth.logout()
    }
  }
}
</script>
