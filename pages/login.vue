<template>
  <div class="d-flex justify-center align-center fill-height">
    <v-form @submit.prevent="login" @keydown="form.onKeydown($event)">
      <v-card elevation="2" style="min-width: 400px" :loading="loading">
        <v-card-title> Welcome</v-card-title>
        <v-card-subtitle>AX Project</v-card-subtitle>
        <v-card-text>
          <v-text-field v-model="email" label="Email" type="email" :error-messages="errors.email" />
          <v-text-field v-model="password" label="Password" required :type="passwordVisible ? 'text' : 'password'" autocomplete="new-password" :error-messages="errors.password"
                        :append-icon="passwordVisible ? 'mdi-eye' : 'mdi-eye-off'" @click:append="passwordVisible = !passwordVisible"
          />
        </v-card-text>
        <v-card-actions>
          <v-btn block text type="submit" :loading="loading" :disabled="loading">
            <v-icon left>
              mdi-login
            </v-icon>
            Login
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-form>
  </div>
</template>
<script>
export default {
  layout: 'simple',
  auth: 'guest',
  data () {
    return {
      loading: false,
      passwordVisible: false,
      errors: [],
      email: 'dev@ax.com',
      password: 'axdev*&'
    }
  },
  head () {
    return { title: 'Login' }
  },
  methods: {
    login () {
      this.loading = true
      this.erorrs = []
      const data = {
        email: this.email,
        password: this.password
      }
      this
        .$auth
        .loginWith('local', { data })
        .catch(this.handleError)
        .finally(() => (this.loading = false))
    },
    handleError ({ response }) {
      if (response.status === 419) {
        this.$toast.error(response.data.message)
      }
      if (response.status === 422) {
        this.errors = response.data.errors
      }
    },
    handleSuccess ({ data }) {
      // this.$auth.setUser(data)
      // this.$router.push('/')
    }
  }
}
</script>
