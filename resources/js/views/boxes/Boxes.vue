<template>
	<div>
		<h1 class="title">Boxes</h1>
		<router-link class="button is-success" to="/boxes/create">
			New box
		</router-link>
		<div class="cards">
			<div class="card" v-for="box in boxes" :key="box.id">
				<header class="card-header card-title">
					<p class="card-header-title">Box id: {{ box.id }}</p>
					<p class="card-header-title">
						<router-link :to="`/boxes/${box.id}/edit`">
							<span class="icon">
								<i class="mdi mdi-pencil-outline"></i>
							</span>
						</router-link>

						<a @click="deleteBox({ id: box.id })">
							<span class="icon">
								<i class="mdi mdi-trash-can-outline"></i>
							</span>
						</a>
					</p>
				</header>
				<div class="card-content">
					<div class="content">
						<h5>Discount: {{ box.discount }}%</h5>
						<h5>Products:</h5>
						<table class="table">
							<thead>
								<tr>
									<th>Product</th>
									<th>Count</th>
								</tr>
							</thead>
							<tbody>
								<tr
									v-for="(product, index) in box.content"
									:key="index"
								>
									<td>
										{{ product.name }} (id:
										{{ product.id }})
									</td>
									<td>{{ product.count }}x</td>
								</tr>
							</tbody>
						</table>
						<h5>Final price: ${{ box.price }}</h5>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	data() {
		return {
			boxes: []
		}
	},

	methods: {
		/**
		 * Load boxes
		 *
		 * @returns void
		 */
		loadBoxes() {
			const loader = this.$loading.show()
			this.callApi('get', '/api/boxes', {}, { empty_boxes: false }).then(
				res => {
					this.boxes = res.data.data
					loader.hide()
				}
			)
		},

		/**
		 * Delete box.
		 *
		 * @returns void
		 */
		deleteBox(box) {
			if (window.confirm('Are you sure? There`s no going back!')) {
				let loader = this.$loading.show()

				this.callApi('delete', `/api/boxes/${box.id}`).then(res => {
					// Remove the box from the boxes array
					this.boxes = this.boxes.filter(b => b.id !== box.id)

					// Emit flash message
					this.$root.$emit('flash-message', {
						message: res.data.message
					})

					// Hide loader
					loader.hide()
				})
			}
		}
	},

	created() {
		// Initial loading of boxes
		this.loadBoxes()
	}
}
</script>

<style lang="scss" scoped>
.cards {
	display: flex;
	flex-direction: row;
	flex-wrap: wrap;
}

.card {
	min-width: 18em;
	max-width: 20em;
	margin: 0.5em;
}

.cart-title {
	display: flex;
	justify-content: space-between;
}
</style>
