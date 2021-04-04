// bootstrap
import './bootstrap'

// Vue main component
import App from './App.vue'

// Vue router
import router from './router/index.js'

// Vue mixins
import generalMixin from './mixins/generalMixin'

Vue.mixin(generalMixin)

// Vue plugins
import VueLoading from 'vue-loading-overlay'
import 'vue-loading-overlay/dist/vue-loading.css'

Vue.use(VueLoading, {
	isFullPage: true,
	color: '#000000',
	loader: 'spinner',
	width: 80,
	height: 80,
	backgroundColor: '#ffffff',
	opacity: 0.5,
	zIndex: 999
})

// vue instance
const app = new Vue({
	router,
	render: h => h(App)
}).$mount('#app')
