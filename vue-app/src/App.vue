<template>
    <div class="app">
        <docupet-header @patch="patch"></docupet-header>
        <docupet-homepage></docupet-homepage>
    </div>
</template>

<script>
import Vue from "vue"
import DocupetHeader from './components/docupet-header'
import DocupetHomepage from './components/docupet-homepage'
import DocupetForm from './components/docupet-form'
import Buefy from 'buefy'

import { library } from '@fortawesome/fontawesome-svg-core'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import { faPaw } from '@fortawesome/free-solid-svg-icons'
import { faSearch } from '@fortawesome/free-solid-svg-icons'
import axios from 'axios'


let instance = axios.create({
  baseURL: 'http://localhost:80'
});
Vue.prototype.$http = instance

library.add(faPaw, faSearch)

Vue.component('font-awesome-icon', FontAwesomeIcon)


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

    },
    methods: {
        patch(){
            this.$buefy.toast.open({
                message: `Pet profile saved for later!`,
                type: 'is-success',
            })
        }
    }
}
</script>

<style>

    .app {
        font-family: 'Lato', sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        text-align: center;
        color: #2c3e50;
        display: grid;
        height: 100vh;
        grid-template:
            "header" max-content
            "main" 1fr
    }

    @media only screen and (max-width: 900px) {
        .app{
            display: block;
        }
    }
</style>
