<template>
	<div>
		<form enctype="multipart/form-data" method="post">
			<!-- Name field -->
			<div class="field">
				<label class="label">Name:</label>
				<div class="control">
					<input
						class="input"
						:class="{ 'is-danger': errors.name }"
						type="text"
						placeholder="Name"
						v-model="name"
					/>
				</div>
				<div v-if="errors.name">
					<div v-for="(error, index) in errors.name" :key="index">
						<p class="help is-danger">{{ error }}</p>
					</div>
				</div>
			</div>

			<!-- Stock field -->
			<div class="field">
				<label class="label">Stock (Pieces):</label>
				<div class="control">
					<input
						class="input"
						:class="{ 'is-danger': errors.stock }"
						type="number"
						min="0"
						placeholder="Stock"
						v-model="stock"
					/>
				</div>
				<div v-if="errors.stock">
					<div v-for="(error, index) in errors.stock" :key="index">
						<p class="help is-danger">{{ error }}</p>
					</div>
				</div>
			</div>

			<!-- Price field -->
			<div class="field">
				<label class="label">Price ($):</label>
				<div class="control">
					<input
						class="input"
						:class="{ 'is-danger': errors.price }"
						type="number"
						min="0.00"
						max="any"
						step="0.01"
						placeholder="Price"
						v-model="price"
					/>
				</div>
				<div v-if="errors.price">
					<div v-for="(error, index) in errors.price" :key="index">
						<p class="help is-danger">{{ error }}</p>
					</div>
				</div>
			</div>

			<!-- Supplier field -->
			<div class="field">
				<label class="label">Supplier:</label>

				<p class="control">
					<span class="select">
						<select
							v-model="supplier_id"
							:class="{ 'is-danger': errors.supplier_id }"
						>
							<option value="" disabled selected hidden
								>Please Choose...</option
							>
							<option
								v-for="supplier in suppliers"
								:key="supplier.id"
								:value="supplier.id"
							>
								{{ supplier.name }}
							</option>
						</select>
					</span>
				</p>
				<div v-if="errors.supplier_id">
					<div
						v-for="(error, index) in errors.supplier_id"
						:key="index"
					>
						<p class="help is-danger">{{ error }}</p>
					</div>
				</div>
			</div>

			<!-- Upload image -->
			<p class="label">Image:</p>
			<div class="file has-name">
				<p class="control">
					<label class="file-label">
						<input
							class="file-input"
							type="file"
							name="image"
							@change="handleImageUpload()"
							ref="image"
						/>
						<span class="file-cta">
							<span class="file-icon">
								<i class="fas fa-upload"></i>
							</span>
							<span class="file-label">
								Choose a file…
							</span>
						</span>
						<span class="file-name">
							{{ imageName }}
						</span>
					</label>
				</p>
				<br />
				<div v-if="errors.image">
					<div v-for="(error, index) in errors.image" :key="index">
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
					<router-link to="/products" class="button is-text">
						Cancel
					</router-link>
				</div>
			</div>
		</form>
	</div>
</template>

<script>
export default {
	props: {
		errors: {
			type: Object,
			default() {
				return {}
			}
		},
		suppliers: {
			type: Array,
			default() {
				return []
			}
		},
		values: {
			type: Object,
			default() {
				return {}
			}
		}
	},

	data() {
		return {
			name: '',
			stock: 0,
			price: 0.0,
			image: '',
			supplier_id: '',
			imageName: ''
		}
	},

	methods: {
		/**
		 * Handle image upload
		 *
		 * @returns void
		 */
		handleImageUpload() {
			if (this.$refs.image.files[0].size < 3000000) {
				this.image = this.$refs.image.files[0]
				this.imageName = this.$refs.image.files[0].name
			} else {
				this.imageName = 'File is too big!'
			}
		},

		/**
		 * Build form data
		 *
		 * @returns FormData formData
		 */
		buildFormData() {
			let formData = new FormData()

			formData.append('name', this.name)
			formData.append('stock', this.stock)
			formData.append('price', this.price)
			formData.append('supplier_id', this.supplier_id)

			if (this.image) {
				formData.append('image', this.image)
			}
			return formData
		},

		/**
		 * Handle form submit
		 *
		 * @returns void
		 */
		handleFormSubmit() {
			this.$emit('form-submitted', { formData: this.buildFormData() })
		},

		/**
		 * Fill the form with values if product is edited
		 *
		 * @returns void
		 */
		fillValues() {
			this.name = this.values.name || ''
			this.price = this.values.price || 0
			this.stock = this.values.stock || 0
			this.supplier_id = this.values.supplier_id || ''
			this.imageName = this.values.image || 'No image selected'
		}
	},

	watch: {
		values() {
			// Fill the form with initial values
			this.fillValues()
		}
	}
}
</script>

<style lang="scss" scoped>
.submit-buttons {
	margin-top: 1.5em;
}
</style>
