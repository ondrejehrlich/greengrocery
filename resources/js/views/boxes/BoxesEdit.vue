<template>
	<div>
		<h1 class="title">Edit box id: {{ boxId }}</h1>
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

	computed: {
		boxId() {
			return this.$route.params.id
		}
	},

	methods: {
		/**
		 * Handle form submit.
		 *
		 * @returns void
		 */
		handleFormSubmit() {
			this.callApi('patch', `/api/boxes/${this.$route.params.id}`, {
				discount: this.discount
			}).then(res => {
				if (res.status == 201) {
					this.$root.$emit('flash-message', {
						message: res.data.message
					})
					this.$router.push(`/boxes/${this.$route.params.id}`)
				} else {
					this.errors = res.data.errors
				}
			})
		},

		/**
		 * Initial loading of values.
		 *
		 * @returns void
		 */
		loadOriginalValues() {
			const loader = this.$loading.show()
			this.callApi('get', `/api/boxes/${this.$route.params.id}`).then(
				res => {
					this.discount = res.data.data.discount
					loader.hide()
				}
			)
		}
	},

	created() {
		//  Initial loading of values
		this.loadOriginalValues()
	}
}
</script>

<style lang="scss" scoped>
.field {
	max-width: 15em;
}
</style>
