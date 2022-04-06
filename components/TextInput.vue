<template>
  <v-text-field
    v-model="val"
    :hint="label"
    :type="type"
    :placeholder="label"
    :disabled="disabled"
    :dense="dense"
    :prefix="prefix"
    :error-messages="errors"
    :persistent-hint="persistentHint"
  />
</template>
<script>
export default {
  name: 'TextInput',
  props: {
    value: {
      type: [String, Number],
      default: null
    },
    label: {
      type: String,
      default: ''
    },
    prefix: {
      type: String,
      default: ''
    },
    type: {
      type: String,
      default: 'text'
    },
    disabled: {
      type: Boolean,
      default: false
    },
    persistentHint: {
      type: Boolean,
      default: true
    },
    dense: {
      type: Boolean,
      default: false
    },
    errors: {
      type: Array,
      default: () => ([])
    }
  },
  computed: {
    val: {
      get () {
        return this.value
      },
      set (v) {
        this.$emit('input', v)
      }
    }
  }
}
</script>
