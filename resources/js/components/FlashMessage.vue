<template>
	<div v-show="message" class="notification is-success">
		<button @click="hideMessage" class="delete"></button>
		{{ message }}
	</div>
</template>

<script>
export default {
	props: {
		message: {
			type: String,
			default: ''
		}
	},
	methods: {
		// showMessage(message) {
		// 	this.message = message
		// 	setTimeout(this.hideMessage, 3000)
		// },
		hideMessage() {
			this.$emit('hide-message')
		}
	}
}
</script>

<style lang="scss" scoped>
.notification {
	width: 100%;
}
</style>
