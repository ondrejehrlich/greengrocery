// Router
import VueRouter from 'vue-router'

// Views
import Products from '../views/products/Products.vue'
import ProductsCreate from '../views/products/ProductsCreate'
import ProductsEdit from '../views/products/ProductsEdit'
import ProductsShow from '../views/products/ProductsShow'
import Boxes from '../views/boxes/Boxes.vue'
import BoxesCreate from '../views/boxes/BoxesCreate'
import BoxesEdit from '../views/boxes/BoxesEdit'
import NotFound from '../views/NotFound.vue'

Vue.use(VueRouter)

export default new VueRouter({
	mode: 'history',
	routes: [
		{
			path: '/',
			redirect: '/products'
		},

		// Products
		{
			path: '/products',
			component: Products
		},
		{
			path: '/products/create',
			component: ProductsCreate
		},
		{
			path: '/products/:id',
			component: ProductsShow
		},
		{
			path: '/products/:id/edit',
			component: ProductsEdit
		},

		// Boxes
		{
			path: '/boxes',
			component: Boxes
		},
		{
			path: '/boxes/create',
			component: BoxesCreate
		},
		{
			path: '/boxes/:id/edit',
			component: BoxesEdit
		},

		// Not Found
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
