<template>
  <div class="app">
    <docupet-header></docupet-header>
    <docupet-homepage></docupet-homepage>
  </div>
</template>

<script>
import Vue from "vue"
import DocupetHeader from './components/docupet-header'
import DocupetHomepage from './components/docupet-homepage'
import DocupetForm from './components/docupet-form'
import Buefy from 'buefy'

import 'buefy/dist/buefy.css'

Vue.use(Buefy, {
	defaultIconPack: 'fas',
	defaultFieldLabelPosition: 'inside',
})


Vue.component('docupet-header', DocupetHeader)
Vue.component('docupet-homepage', DocupetHomepage)
Vue.component('docupet-form', DocupetForm)

export default {
  name: 'App',
  components: {
    
  }
}
</script>

<style>

    .app {
      font-family: Avenir, Helvetica, Arial, sans-serif;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      text-align: center;
      color: #2c3e50;
      display: grid;
      height: 100vh;
      grid-template-rows: 5em;
      grid-auto-rows: 1fr;
    }

    @media only screen and (max-width: 800px) {
        .app{
            display: block;
        }
    }
</style>
