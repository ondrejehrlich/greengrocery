<template>
	<div>
		<router-link class="button button-back" to="/products">
			Back to products
		</router-link>
		<h1 class="title">Product: {{ product.name }}</h1>
		<div class="content">
			<table class="table">
				<tbody>
					<tr>
						<td>ID:</td>
						<td>{{ product.id }}</td>
					</tr>
					<tr>
						<td>Name:</td>
						<td>{{ product.name }}</td>
					</tr>
					<tr>
						<td>Supplier:</td>
						<td>{{ product.supplier.name }}</td>
					</tr>
					<tr>
						<td>Last update:</td>
						<td>{{ niceDate(product.updated_at) }}</td>
					</tr>
					<tr>
						<td>Stock:</td>
						<td>{{ product.stock }}</td>
					</tr>
					<tr>
						<td>Price:</td>
						<td>{{ product.price }}</td>
					</tr>
					<tr>
						<td>List of box ids:</td>
						<td>
							<span v-for="box in product.boxes" :key="box.id">
								{{ box.id }},
							</span>
						</td>
					</tr>
				</tbody>
			</table>

			<div class="product-image">
				<img
					:src="
						product.image
							? '/storage/productImages/' + product.image
							: '/storage/productImages/no-image.jpg'
					"
				/>
			</div>
		</div>
		<router-link class="button" :to="`/products/${product.id}/edit`">
			Edit product
		</router-link>
	</div>
</template>

<script>
import tableMixin from '../../mixins/tableMixin'

export default {
	data() {
		return {
			product: {}
		}
	},

	mixins: [tableMixin],

	methods: {
		/**
		 * Initial loading of data about the product.
		 *
		 * @returns void
		 */
		loadData() {
			const loader = this.$loading.show()
			this.callApi('get', `/api/products/${this.$route.params.id}`).then(
				res => {
					this.product = res.data.data
					loader.hide()
					console.log(this.product)
				}
			)
		}
	},

	created() {
		this.loadData()
	}
}
</script>

<style lang="scss" scoped>
@import './../../../sass/_variables.scss';
.content {
	display: flex;
	@media screen and (max-width: $width-md) {
		flex-direction: column;
		align-items: center;
	}
}

.product-image {
	max-width: 400px;
	padding: {
		left: 1.5em;
		right: 1.5;
	}
}

.button-back {
	margin-bottom: 1.5em;
}
</style>
