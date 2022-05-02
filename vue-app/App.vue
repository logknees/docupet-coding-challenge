<template>
<div class="app">
	<div class="app-header">
		<p class="dev-warning has-background-danger has-text-light has-text-centered" v-if="is_dev">THIS IS A DEVELOPMENT BUILD!</p>
		<global-nav/>
	</div>
	<div class="app-sidebar">
		<global-sidebar-nav/>
	</div>

	<div class="app-main grid-pane">
		<router-view></router-view>
	</div>

	<b-button
		v-if="wip_command"

		class="WipCommand"
		type="is-primary"
		rounded
		:icon-left="wip_command.icon"
		@click="open_wip_command"></b-button>

	<div class="pins" v-if="pins.length">
		<pinned-task v-for="pin in pins" :key="pin.id" :pin="pin"/>
	</div>

	<lp-overlay-backdrop/>

	<tearsheet :open="$route.meta.tearsheet" @close="tearsheet_closed" v-slot="{ close }">
		<component
			v-if="$route.meta.tearsheet"
			class="p-2"
			@close="close"
			:is="tearsheet_component"
			v-bind="tearsheet_props"
		/>
	</tearsheet>
</div>
</template>




<script>
import Vue from "vue"
import VueRouter from "vue-router"
import Vuex from "vuex"
import Buefy from 'buefy'
import EventSourcingPlugin from "@/shared/EventSourcingPlugin"

import { extend, setInteractionMode } from 'vee-validate';
import * as rules from 'vee-validate/dist/rules';
import en from 'vee-validate/dist/locale/en';

// NOTE: remove if we need customization
import 'buefy/dist/buefy.css'

import { moment_filter, capitalize_filter, number_filter } from "@/shared/filters"
import AutoExpand from "@/ui/auto-expand.directive"
import IdTag from "@/ui/IdTag.vue"
import LpAutocomplete from "@/ui/LpAutocomplete.vue"
import LpPublisherSidebar from "@/publishing/PublisherSidebar.vue"
import SearchDetails from "./components/SearchDetails.vue"
import ApiSocket from "@/shared/ApiSocket"
import PersonImg from "@/ui/PersonImg.vue"
import VueMarkdown from "vue-markdown"
import LpMarkdown from "@/ui/LpMarkdown.vue"
import LpEditable from "@/ui/LpEditable.vue"
import LpSectionHeader from "@/ui/LpSectionHeader.vue"
import LpPointEditor from "@/ui/LpPointEditor.vue"
import LpProgressBar from "@/ui/LpProgressBar.vue"
import LpCompletedTasks from "@/tasks/CompletedTasks.vue"
import LpReportsCampaignsByType from "@/reports/ReportsCampaignsByType.vue"
import LpReportsLateTasks from "@/reports/ReportsLateTasks.vue"
import { ScrollOver, ScrollUnder } from "@/ui/scrolled.directive"
import LpPetWidget from "@/pets/components/PetWidget.vue"

import "@/_initializers/task_types.init"
import "@/_initializers/meta.init"

// TEMP
import VueTextHighlight from "vue-text-highlight"

// common task components
import Task from "@/ui/Task/Task.vue"
import TaskHeader from "@/ui/Task/TaskHeader.vue"
import TaskBody from "@/ui/Task/TaskBody.vue"
import TaskNav from "@/ui/Task/TaskNav.vue"
import TaskComponent from "@/ui/Task/TaskComponent.vue"

Vue.component('task', Task)
Vue.component('task-header', TaskHeader)
Vue.component('task-body', TaskBody)
Vue.component('task-nav', TaskNav)
Vue.component('task-component', TaskComponent)

import LpTearsheet from "@/ui/LpTearsheet.vue"

Vue.component('tearsheet', LpTearsheet)




// Websocket Setup
ApiSocket.connect()

// Framework Setup
Vue.use(VueRouter)
Vue.use(Vuex)
Vue.use(Buefy, {
	defaultIconPack: 'fas',
	defaultFieldLabelPosition: 'inside',
})
Vue.use(EventSourcingPlugin)

Vue.filter('moment', moment_filter)
Vue.filter('capitalize', capitalize_filter)
Vue.filter('json', value => JSON.stringify(value, null, 4))
Vue.filter('debug', value => {
	console.log('DEBUG filter:', value)
	return value
})
Vue.filter('yesno', v => v ? 'Yes' : 'No')
Vue.filter('number', number_filter)

Vue.directive('auto-expand', AutoExpand)
Vue.component('id-tag', IdTag)
Vue.component('lp-autocomplete', LpAutocomplete)
Vue.component('lp-publisher-sidebar', LpPublisherSidebar)
Vue.component('lp-search-details', SearchDetails)
Vue.component('lp-editable', LpEditable)
Vue.component('person-img', PersonImg)
Vue.component('vue-markdown', VueMarkdown)
Vue.component('lp-markdown', LpMarkdown)
Vue.component('text-highlight', VueTextHighlight)
Vue.component('lp-section-header', LpSectionHeader)
Vue.component('lp-completed-tasks', LpCompletedTasks)
Vue.component('lp-point-editor', LpPointEditor)
Vue.component('lp-progress-bar', LpProgressBar)

Vue.component('lp-pet-widget', LpPetWidget)

//modular reports
Vue.component('lp-reports-campaigns-by-type', LpReportsCampaignsByType)
Vue.component('lp-reports-late-tasks', LpReportsLateTasks)

// similar to v-on with object syntax, but allows native bindings. Sheesh.
Vue.directive('on-native', {
	inserted(el, binding, vNode) {
		for (let event_name in binding.value) {
			if (event_name.includes('.native')) {
				el.addEventListener(event_name.replace('.native', ''), binding.value[event_name])
			}
			else {
				vNode.componentInstance.$on(event_name, binding.value[event_name])
			}
		}
	},
	unbind(el, binding) {
		for (let event_name in binding.value) {
			if (event_name.includes('.native')) {
				el.removeEventListener(event_name.replace('.native', ''), binding.value[event_name])
			}
		}
	}
})

Vue.component('lp-title', {
	mounted() {
		this.$app.title(this.$slots.default[0].text)
	},
	render() {
		return null
	}
})

Vue.directive('scroll-over', ScrollOver)
Vue.directive('scroll-under', ScrollUnder)



// Global services added to Vue components
// USE SPARINGLY!
Vue.mixin({
	beforeCreate() {
		this.$app = App
	},
})
Vue.prototype.$can = function (task) {
	return this.$store.state.permissions.includes(task)
}




// validation config
setInteractionMode('eager')

// loop over all rules
for (let rule in rules) {
  extend(rule, {
    ...rules[rule], // add the rule
    message: en.messages[rule] // add its message
  });
}

const URL_PATTERN = /.+\..+/
extend('url', value => URL_PATTERN.test(value))

// global styles
import "./styles/global.css"

// components
import GlobalNav from "./components/GlobalNav.vue"
import GlobalSidebarNav from "./components/GlobalSidebarNav.vue"

// code
import App from "@/shared/app.service"

Vue.prototype.$modal = function (component, args) {
	App.modal(this, component, args)
}
Vue.prototype.$modal_promise = function (component, args) {
	return App.modal_promise(this, component, args)
}

import routes from "./routes"
import store from "./store/store"
import { vanish_query_param } from "@/shared/utils"
import { mapState } from "vuex"

import PinnedTask from "@/ui/PinnedTask.vue"
import _ from "lodash"
import LpOverlayBackdrop from '@/ui/LpOverlayBackdrop.vue'


const router = new VueRouter({
	mode: 'history',
	routes,
})

router.afterEach((to, from) => {
	App.is_fresh_boot = (!from.name && from.path === '/')
	App.prev_state = from
})

export const Store = new Vuex.Store(store())

export default {
	name: 'seotool',
	router,
	store: Store,
	components: {
		GlobalNav,
		GlobalSidebarNav,
		PinnedTask,
		LpOverlayBackdrop,
	},
	data() {
		return {
			is_dev: window.location.href.includes('-dev')
		}
	},
	computed: {
		...mapState(['wip_command', 'pins']),
		tearsheet_component() {
			if (!this.$route.matched.length) return
			return this.$route.matched[this.$route.matched.length - 1].components.default
		},
		tearsheet_props() {
			if (!this.$route.matched.length) return
			return this.$route.matched[this.$route.matched.length - 1].props.default
				? this.$route.matched[this.$route.matched.length - 1].props.default(this.$route)
				: this.$route.params
		}
	},
	methods: {
		fetch_users() {
			this.$app.api('users')
				.then(({ users }) => {
					this.$store.commit('user_index_loaded', { index: _.keyBy(users, 'id') })
				})
				.catch(() => {
					console.error('WARNING! Could not load the user list!')
				})
		},

		fetch_teams() {
			this.$app.api('users/teams')
				.then(({ teams }) => {
					this.$store.commit('team_index_loaded', { index: _.keyBy(teams, 'id') })
				})
				.catch(() => {
					console.error('WARNING! Could not load the team list!')
				})
		},

		open_wip_command() {
			this.$app.open_wip_command(this)
		},

		tearsheet_closed() {
			// If the tearsheet close btn was clicked, the route will still be the tearsheet one;
			// it will have a fallback defined, and we need to update the route after.
			// If the back/forward button is clicked, the route will already be the non-tearsheet one;
			// and we should NOT update the route.
			if (!this.$route.meta.tearsheet) return

			this.$router.push(this.$route.meta.home)
		},
	},
	mounted() {
		this.fetch_users()
		this.fetch_teams()
	},
	beforeCreate() {
		App.init(this.$store)
		vanish_query_param(this, 'attempting_login')
	},
}

</script>




<style scoped>

.app {
	display: grid;
	height: 100vh;
	grid-template:
		"header header" max-content
		"sidebar main" 1fr /
		max-content 1fr;
}

.app-header {
	grid-area: header;
}

.app-sidebar {
	grid-area: sidebar;
	background: var(--nav-color);
}

.app-main {
	grid-area: main;
}

.dev-warning {
	font-size: 0.8rem;

}

.WipCommand {
	position: absolute;
	right: 2rem;
	bottom: 2rem;
	box-shadow: 0 4px 8px -5px #000;
}

.pins {
	position: absolute;
	max-width: 100vw;
	overflow-y: none;
	overflow-x: auto;

	right: 0;
	bottom: 0;
	padding: .5rem;

	background: var(--nav-color);
	border-top-left-radius: 7px;
	box-shadow: -4px 1px 8px -5px #000;

	display: flex;
	gap: 0.75rem;
}

</style>
