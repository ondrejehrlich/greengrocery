<template>
	<div>
		<h1 class="title">Create new product</h1>
		<div class="products-form-container">
			<ProductsForm
				:errors="errors"
				@post-form-submitted="submitForm"
				:suppliers="suppliers"
				@form-submitted="submitForm($event)"
			/>
		</div>
	</div>
</template>

<script>
import ProductsForm from './components/ProductsForm'

export default {
	components: {
		ProductsForm
	},
	data() {
		return {
			errors: {},
			suppliers: []
		}
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

			this.callApi(
				'post',
				'/api/products/',
				data.formData,
				{},
				headers
			).then(res => {
				if (res.status == 201) {
					this.$root.$emit('flash-message', {
						message: res.data.message
					})
					console.log(res)
					this.$router.push('/products')
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
		}
	},

	created() {
		this.loadSuppliers()
	}
}
</script>

<style lang="scss" scoped>
.products-form-container {
	max-width: 30em;
}
</style>
