<template>
	<div class="search-container">
		<div class="left-column">
			<!-- Search by ID -->
			<div class="field has-addons">
				<label class="label" for="search-by-id">Search by ID: </label>
				<p class="control">
					<input
						id="search-by-id"
						class="input"
						type="text"
						placeholder="Search by ID"
						v-model="idSearch"
						@input="emitNewSearchParameters"
					/>
				</p>
				<p
					class="control"
					v-show="idSearch"
					@click="
						idSearch = ''
						emitNewSearchParameters()
					"
				>
					<button class="button">
						x
					</button>
				</p>
			</div>

			<!-- Search by name -->
			<div class="field has-addons">
				<label class="label" for="search-by-name"
					>Search by name:
				</label>

				<p class="control">
					<input
						id="search-by-name"
						class="input"
						type="text"
						placeholder="Search by name"
						v-model="nameSearch"
						@input="emitNewSearchParameters"
					/>
				</p>
				<p
					class="control"
					v-show="nameSearch"
					@click="
						nameSearch = ''
						emitNewSearchParameters()
					"
				>
					<button class="button">
						x
					</button>
				</p>
			</div>

			<!-- Search by supplier -->
			<div class="field has-addons">
				<label class="label" for="search-by-supplier"
					>Search by supplier:
				</label>
				<p class="control">
					<input
						id="search-by-supplier"
						class="input"
						type="text"
						placeholder="Search by supplier"
						v-model="supplierSearch"
						@input="emitNewSearchParameters"
					/>
				</p>
				<p class="control">
					<button
						class="button"
						v-show="supplierSearch"
						@click="
							supplierSearch = ''
							emitNewSearchParameters()
						"
					>
						x
					</button>
				</p>
			</div>

			<!-- Order by -->
			<div class="field has-addons">
				<label class="label" for="order-by">Order by:</label>
				<div class="select">
					<select
						id="order-by"
						v-model="orderBy"
						@change="emitNewSearchParameters()"
					>
						<option value="id">ID</option>
						<option value="last_edit">Last edit</option>
					</select>
				</div>
			</div>

			<!-- Order direction -->
			<div class="field has-addons">
				<label class="label" for="order-dir">Order direction:</label>
				<div class="select">
					<select
						id="order-dir"
						v-model="orderDir"
						@change="emitNewSearchParameters()"
					>
						<option value="asc">a - z</option>
						<option value="desc">z - a</option>
					</select>
				</div>
			</div>

			<!-- In stock -->
			<div class="field has-addons">
				<label for="in-stock" class="label checkbox">
					In stock:
				</label>
				<input
					id="in-stock"
					type="checkbox"
					v-model="inStock"
					@change="emitNewSearchParameters"
				/>
			</div>
		</div>
		<div class="right-column">
			<router-link to="/products/create" class="button is-success"
				>New product</router-link
			>
		</div>
	</div>
</template>

<script>
export default {
	data() {
		return {
			idSearch: '',
			nameSearch: '',
			supplierSearch: '',
			orderBy: 'id',
			orderDir: 'asc',
			inStock: false
		}
	},

	methods: {
		emitNewSearchParameters: _.debounce(function() {
			// Non-arrow function has to be here because of "this"

			this.$emit('search-products', {
				// Snake case because they will be in the query string
				id_search: this.idSearch,
				name_search: this.nameSearch,
				supplier_search: this.supplierSearch,
				order_by: this.orderBy,
				order_dir: this.orderDir,
				in_stock: this.inStock
			})
		}, 370)
	}
}
</script>

<style lang="scss" scoped>
.search-container {
	margin-bottom: 1em;
	display: flex;
	flex-direction: row;
	flex-wrap: nowrap;
	justify-content: space-between;
}

.left-column {
	& > * {
		margin-bottom: 1em;
	}
}

.right-column {
	display: flex;
	align-items: flex-end;
}

.label {
	margin-right: 1em;
	display: inline-block;
	min-width: 10em;
}
</style>
