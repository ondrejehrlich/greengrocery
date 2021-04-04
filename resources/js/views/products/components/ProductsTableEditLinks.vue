<template>
	<div>
		<router-link :to="`/products/${id}`">
			<span class="icon">
				<i class="mdi mdi-eye-outline"></i>
			</span>
		</router-link>

		<router-link :to="`/products/${id}/edit`">
			<span class="icon">
				<i class="mdi mdi-pencil-outline"></i>
			</span>
		</router-link>

		<a @click="deleteProduct">
			<span class="icon">
				<i class="mdi mdi-trash-can-outline"></i>
			</span>
		</a>
	</div>
</template>

<script>
export default {
	props: {
		id: {
			type: Number
		}
	},
	methods: {
		/**
		 * Emit delete-product event to the parent.
		 *
		 * @returns void
		 */
		deleteProduct() {
			if (window.confirm('Are you sure? There`s no going back!')) {
				this.$emit('delete-product', { id: this.id })
			}
		}
	}
}
</script>

<style lang="scss" scoped>
div {
	display: flex;
	justify-content: center;
}
a {
	color: rgb(34, 34, 34);
	border: none;
}
</style>
