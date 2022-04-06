module.exports = {
  root: true,
  parserOptions: {
    parser: '@babel/eslint-parser',
    requireConfigFile: false
  },
  extends: [
    '@nuxtjs'
  ],
  rules: {
    'vue/max-attributes-per-line': 'off',
    'vue/valid-v-slot': ['error', { allowModifiers: true }],
    'no-console': ['error', { allow: ['warn', 'error', 'log', 'table', 'info'] }]
  }
}
