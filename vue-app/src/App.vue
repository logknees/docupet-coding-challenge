<template>
  <div id="app">
    <docupet-homepage></docupet-homepage>
  </div>
</template>

<script>
import Vue from "vue"
import DocupetHomepage from './components/docupet-homepage'
import DocupetForm from './components/docupet-form'

Vue.component('docupet-homepage', DocupetHomepage)
Vue.component('docupet-form', DocupetForm)

export default {
  name: 'App',
  components: {
    
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
