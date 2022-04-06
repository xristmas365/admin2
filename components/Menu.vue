<template>
  <div v-if="$auth.user" class="mt-4">
    <v-list v-for="(item, i) in menu" :key="'section-'+i" dense nav subheader>
      <v-subheader v-if="item.section" v-text="item.section" />
      <template v-for="(link, j) in item.items">
        <v-list-item v-if="!link.items" :key="'link-'+j" :to="link.to" nuxt exact-path>
          <v-list-item-icon>
            <v-icon :color="link.color" v-text="link.icon" />
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title class="text-uppercase" v-text="link.title" />
          </v-list-item-content>
        </v-list-item>
      </template>
    </v-list>
  </div>
</template>
<script>

export default {
  name: 'Menu',
  data () {
    return {
      menu: [
        {
          section: 'AX Project',
          items: [
            {
              icon: 'mdi-view-dashboard',
              title: 'Dashboard',
              to: '/admin',
              access: 'users',
              color: 'purple'
            }
          ]
        },
        {
          section: 'Users',
          items: [
            {
              icon: 'mdi-account-multiple',
              title: 'Users',
              to: '/admin/users',
              access: 'users',
              color: 'purple'
            }
          ]
        },
        {
          section: 'Account',
          items: [
            {
              icon: 'mdi-account',
              color: 'indigo',
              title: 'Account',
              to: '/admin/account'
            }
          ]
        }
      ]
    }
  }
}
</script>
