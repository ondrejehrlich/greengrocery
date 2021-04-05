<template>
	<div>
		<h1 class="title">Create new box</h1>
		<form>
			<!-- Discount field -->
			<div class="field">
				<label class="label">Discount (%):</label>
				<div class="control">
					<input
						class="input"
						type="number"
						:class="{ 'is-danger': errors.discount }"
						min="0"
						max="100"
						placeholder="Discount"
						v-model="discount"
					/>
				</div>
				<div v-if="errors.discount">
					<div v-for="(error, index) in errors.discount" :key="index">
						<p class="help is-danger">{{ error }}</p>
					</div>
				</div>
			</div>

			<!-- Buttons -->
			<div class="field is-grouped submit-buttons">
				<div class="control">
					<button
						@click.prevent="handleFormSubmit()"
						class="button is-primary"
					>
						Submit
					</button>
				</div>
				<div class="control">
					<router-link to="/boxes" class="button is-text">
						Cancel
					</router-link>
				</div>
			</div>
		</form>
		<p>
			After creating a new box, you need to add some products to it to see
			it in the list of boxes.
		</p>
	</div>
</template>

<script>
export default {
	data() {
		return {
			errors: {},
			discount: ''
		}
	},

	methods: {
		/**
		 * Handle form submit.
		 *
		 * @returns void
		 */
		handleFormSubmit() {
			this.callApi('post', '/api/boxes', {
				discount: this.discount
			}).then(res => {
				if (res.status == 201) {
					this.$root.$emit('flash-message', {
						message: res.data.message
					})
					this.$router.push('/boxes')
				} else {
					this.errors = res.data.errors
				}
			})
		}
	}
}
</script>

<style lang="scss" scoped>
.field {
	max-width: 15em;
}
</style>
