module.exports = {
  root: true,
  env: {
    "node": true
  },
  extends: [
    "plugin:vue/recommended",
    "eslint:recommended"
  ],
  // parserOptions: {
  //   "parser": "babel-eslint"
  // },
  rules: {
    "vue/html-button-has-type": "error",
    "vue/max-attributes-per-line": "off"
  }
}
