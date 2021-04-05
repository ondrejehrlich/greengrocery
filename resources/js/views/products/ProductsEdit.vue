<template>
	<div>
		<h1 class="title">Edit product id: {{ values.id }}</h1>
		<div class="products-form-container">
			<ProductsForm
				:errors="errors"
				@post-form-submitted="submitForm"
				:suppliers="suppliers"
				@form-submitted="submitForm($event)"
				:values="values"
			/>
		</div>
	</div>
</template>

<script>
import ProductsForm from './components/ProductsForm'
export default {
	data() {
		return {
			errors: {},
			suppliers: [],
			values: {}
		}
	},

	components: {
		ProductsForm
	},

	methods: {
		/**
		 * Submit form.
		 *
		 * @returns void
		 */
		submitForm(data) {
			const headers = {
				'Content-Type': 'multipart/form-data'
			}

			// Append method patch to formData
			data.formData.append('_method', 'PATCH')

			this.callApi(
				'post',
				`/api/products/${this.$route.params.id}`,
				data.formData,
				{},
				headers
			).then(res => {
				if (res.status == 201) {
					this.$root.$emit('flash-message', {
						message: res.data.message
					})
					console.log(res)
					this.$router.push(`/products/${this.values.id}`)
				} else {
					this.errors = res.data.errors
				}
			})
		},

		/**
		 * Load list of suppliers
		 *
		 * @returns void
		 */
		loadSuppliers() {
			this.callApi('get', '/api/suppliers').then(res => {
				this.suppliers = res.data.data
			})
		},

		/**
		 * Load original values of the product.
		 *
		 * @returns void
		 */
		loadOriginalValues() {
			const loader = this.$loading.show()
			this.callApi('get', `/api/products/${this.$route.params.id}`).then(
				res => {
					this.values = res.data.data
					loader.hide()
				}
			)
		}
	},

	created() {
		// Load Suppliers
		this.loadSuppliers()

		// Load original values
		this.loadOriginalValues()
	}
}
</script>

<style lang="scss" scoped>
.products-form-container {
	max-width: 30em;
}
</style>
