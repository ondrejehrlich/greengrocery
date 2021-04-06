<template>
	<div>
		<h1 class="title">Boxes</h1>
		<router-link class="button is-success" to="/boxes/create">
			New box
		</router-link>
		<div class="cards">
			<BoxesCard
				v-for="box in boxes"
				:key="box.id"
				:box="box"
				@delete-box="deleteBox($event.id)"
				@discount-updated="loadBoxes"
			/>
		</div>
	</div>
</template>

<script>
import BoxesCard from './components/BoxesCard'

export default {
	data() {
		return {
			boxes: []
		}
	},

	components: {
		BoxesCard
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
		deleteBox(id) {
			if (window.confirm('Are you sure? There`s no going back!')) {
				let loader = this.$loading.show()

				this.callApi('delete', `/api/boxes/${id}`).then(res => {
					// Remove the box from the boxes array
					this.boxes = this.boxes.filter(b => b.id !== id)

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
