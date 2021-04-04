<template>
	<div>
		<section class="comments-page">
			<h1 class="title is-4">
				Products
			</h1>
			<ProductsTableSearch
				@search-products="loadFilteredProducts($event)"
			/>

			<table class="table is-bordered is-striped is-hoverable">
				<thead>
					<tr>
						<th>ID</th>
						<th>Name</th>
						<th>Supplier</th>
						<th>Last update</th>
						<th>Stock</th>
						<th>Price</th>
						<th>Add to box</th>
						<th></th>
					</tr>
				</thead>
				<tbody ref="productsTable">
					<tr v-for="product in products" :key="product.id">
						<td>{{ product.id }}</td>
						<td>
							<router-link :to="`/products/${product.id}`">
								{{ shorten(product.name, 80) }}
							</router-link>
						</td>
						<td>{{ product.supplier.name }}</td>
						<td>{{ niceDate(product.updated_at) }}</td>
						<td>{{ product.stock }}</td>
						<td>{{ product.price }}</td>
						<td>
							<div
								v-if="product.stock > 0"
								class="navbar-item has-dropdown is-hoverable"
							>
								<a class="navbar-link">
									Select box
								</a>
								<div class="navbar-dropdown">
									<a
										v-for="box in boxes"
										:key="box.id"
										class="navbar-item"
										@click.prevent="
											addToBox(box.id, product.id)
										"
									>
										Box id: {{ box.id }}
									</a>
								</div>
							</div>
							<p class="out-of-stock" v-if="product.stock === 0">
								Out of stock
							</p>
						</td>
						<td>
							<ProductsTableEditLinks
								:id="product.id"
								@delete-product="deleteProduct($event.id)"
							/>
						</td>
					</tr>
				</tbody>
			</table>
			<a
				@click.prevent="loadNextProducts()"
				v-if="productsNextPageUrl"
				class="button"
				:class="{ 'is-loading': loadingMore }"
			>
				Load more
			</a>
		</section>
	</div>
</template>

<script>
import tableMixin from '../../mixins/tableMixin'
import ProductsTableEditLinks from './components/ProductsTableEditLinks'
import ProductsTableSearch from './components/ProductsTableSearch'

export default {
	data() {
		return {
			products: [],
			boxes: [],
			productsNextPageUrl: '',
			loadingMore: false
		}
	},

	mixins: [tableMixin],

	components: {
		ProductsTableEditLinks,
		ProductsTableSearch
	},

	methods: {
		/**
		 * Initial loading of resources (products, boxes)
		 *
		 * @returns void
		 */
		async loadResources() {
			let loader = this.$loading.show()

			const resProducts = await this.callApi('get', '/api/products')
			const resBoxes = await this.callApi('get', '/api/boxes')

			this.products = resProducts.data.data.data
			this.productsNextPageUrl = resProducts.data.data.next_page_url
			this.boxes = resBoxes.data.data

			await Promise.all([resProducts, resBoxes]).then(() => {
				loader.hide()
			})
		},

		/**
		 * Load next products
		 *
		 * @returns void
		 */
		loadNextProducts() {
			this.loadingMore = true

			this.callApi('get', this.productsNextPageUrl).then(res => {
				this.loadingMore = false

				// After response comes, add next products to products array
				this.products = [...this.products, ...res.data.data.data]

				// After presponse comes, change productsNextPageUrl to a new one
				this.productsNextPageUrl = res.data.data.next_page_url
			})
		},

		/**
		 * Add the product to a selected box
		 *
		 * @param integer boxId
		 * @param integer productId
		 * @returns void
		 */
		addToBox(boxId, productId) {
			this.callApi(
				'post',
				`/api/products/${productId}/add-to-box/${boxId}`
			).then(res => {
				this.$root.$emit('flash-message', {
					message: res.data.message
				})

				// Decrement the stock of the right product
				this.products = this.products.map(p => {
					if (p.id === productId) {
						p.stock = p.stock > 0 ? p.stock - 1 : 0
					}
					return p
				})
			})
		},

		/**
		 * Delete product and remove it from products array
		 *
		 * @param integer id
		 * @returns void
		 */
		deleteProduct(id) {
			let loader = this.$loading.show()

			this.callApi('delete', `/api/products/${id}`).then(res => {
				// Remove the product from the products array
				this.products = this.products.filter(p => p.id !== id)

				// Emit flash message
				this.$root.$emit('flash-message', {
					message: res.data.message
				})

				// Hide loader
				loader.hide()
			})
		},

		/**
		 * Load products according params from the search form
		 *
		 * @param Object searchQuery
		 * @returns void
		 */
		loadFilteredProducts(searchQuery) {
			this.callApi('get', '/api/products/', {}, searchQuery).then(res => {
				this.products = res.data.data.data
				this.productsNextPageUrl = res.data.data.next_page_url
			})
		}
	},

	created() {
		// Initial loading of products
		this.loadResources()
	}
}
</script>

<style lang="scss" scoped>
.products-table {
	overflow-x: scroll;
}
td {
	vertical-align: middle;
}
.nowrap,
th {
	white-space: nowrap;
}
thead tr {
	background-color: rgb(175, 175, 175);
}

.out-of-stock {
	color: rgb(185, 2, 2);
}
</style>
