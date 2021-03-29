// Router
import VueRouter from 'vue-router'

// Views
import Home from '../views/Home.vue'
import NotFound from '../views/NotFound.vue'

Vue.use(VueRouter)

export default new VueRouter({
	mode: 'history',
	routes: [
		// Dashboard
		{
			path: '/',
			name: 'home',
			component: Home
		},

		{
			path: '/404',
			component: NotFound
		},
		{
			path: '*',
			redirect: '/404'
		}
	]
})
