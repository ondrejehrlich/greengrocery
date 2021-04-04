<template>
	<nav>
		<li class="navbar-item">
			<router-link to="/products">
				Products
			</router-link>
		</li>
		<li class="navbar-item">
			<router-link to="/boxes">
				Boxes
			</router-link>
		</li>
	</nav>
</template>

<script>
export default {}
</script>

<style lang="scss" scoped>
.navbar-item {
	display: block;
	width: 100%;
}

.navbar-item a {
	border-radius: 0.2em;

	color: rgb(12, 12, 12);

	padding: {
		top: 0.4em;
		right: 0.7em;
		bottom: 0.4em;
		left: 0.7em;
	}
}

.navbar-item a:hover,
.router-link-active {
	background-color: #636363;
}
</style>
