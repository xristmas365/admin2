<template>
  <div>
    <v-card :loading="loading">
      <v-card-title>{{ title }}</v-card-title>
      <v-card-subtitle>Information About Your Account</v-card-subtitle>
      <v-card-text>
        <text-input
          v-model="user.email"
          label="Email"
          :errors="errors.email"
        />
        <text-input
          v-model="user.name"
          label="Name"
          :errors="errors.name"
        />
        <FileManager v-model="user.files" label="Profile Photos" cols="3" :limit="4" />
      </v-card-text>
      <v-card-actions>
        <v-spacer />
        <v-btn color="primary" depressed :loading="loading" :disabled="loading" @click="handleSave">
          Save
        </v-btn>
      </v-card-actions>
    </v-card>
  </div>
</template>
<script>
export default {
  name: 'Account',
  layout: 'admin',
  data () {
    return {
      title: 'Account',
      user: {},
      errors: [],
      messageError: null,
      roleItems: [{
        value: 1,
        text: 'Developer'
      }],
      loading: false,
      rules: [v => !!v || 'This field is required']
    }
  },
  async fetch () {
    this.loading = true
    const { user } = await this.$axios.$get('/api/auth/user')
    this.user = user
    this.loading = false
  },
  head () {
    return {
      title: this.title
    }
  },
  computed: {
    valid: {
      get () {
        return !!(this.user.name && this.user.email)
      },
      set () {
      }
    }
  },
  methods: {
    handleSave () {
      this.loading = true
      this.errors = []
      this.messageError = null
      this.$axios
        .post('/api/auth/user-save', { User: this.user })
        .then(async () => {
          await this.$auth.fetchUser()
        })
        .catch((e) => {
          if (e.response.status >= 400 && e.response.status <= 500) {
            this.errors = e.response.data.errors
            this.messageError = e.response.data.message
          }
        })
        .finally(() => {
          this.loading = false
        })
    }
  }
}
</script>
<style lang="scss" scoped></style>
