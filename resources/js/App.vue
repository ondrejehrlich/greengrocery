<template>
	<div class="main-container">
		<header class="main-header">
			<div class="logo">
				<router-link to="/">
					<img src="/img/logo.svg" alt="logo" />
				</router-link>
			</div>
			<TheNavigation />
		</header>
		<main>
			<Transition name="slide-fade">
				<FlashMessage
					class="flash-message"
					v-show="flashMessaging"
					:message="flashMessage"
					@hide-message="hideFlashMessage()"
				/>
			</Transition>

			<router-view />
		</main>
	</div>
</template>

<script>
import TheNavigation from './components/TheNavigation'
import FlashMessage from './components/FlashMessage'

export default {
	components: {
		TheNavigation,
		FlashMessage
	},

	data() {
		return {
			flashMessage: '',
			flashMessaging: false
		}
	},

	methods: {
		showFlashMessage(message) {
			this.flashMessage = message
			this.flashMessaging = true

			setTimeout(() => {
				this.hideFlashMessage()
			}, 2500)
		},

		hideFlashMessage() {
			this.flashMessaging = false
		}
	},

	mounted() {
		this.$root.$on('flash-message', $event => {
			this.showFlashMessage($event.message)
		})
	}
}
</script>

<style src="./App.scss" lang="scss" scoped></style>
