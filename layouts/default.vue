<template>
  <v-app>
    <v-app-bar fixed app flat>
      <h3>
        <nuxt-link to="/" class="text-uppercase text-decoration-none text--primary">
          {{ title }}
        </nuxt-link>
      </h3>
      <v-spacer />
      <template v-if="$auth.loggedIn">
        <v-btn to="/admin" class="mr-2">
          Admin
        </v-btn>
        <v-btn @click="logout">
          Logout
        </v-btn>
      </template>
      <v-btn v-else to="/login">
        Login
      </v-btn>
    </v-app-bar>
    <v-main>
      <Nuxt />
    </v-main>
    <v-footer fixed app>
      <span>IndustrialAX LLC &copy; {{ new Date().getFullYear() }}</span>
    </v-footer>
  </v-app>
</template>
<script>
export default {
  name: 'DefaultLayout',
  data () {
    return {
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
