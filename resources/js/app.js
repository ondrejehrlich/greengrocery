// bootstrap
import './bootstrap'

// Vue main component
import App from './App.vue'

// Vue router
import router from './router/index.js'

// vue instance
const app = new Vue({
	router,
	render: h => h(App)
}).$mount('#app')
