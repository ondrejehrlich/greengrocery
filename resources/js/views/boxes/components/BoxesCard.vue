<template>
	<div class="card">
		<header class="card-header card-title">
			<p class="card-header-title">Box id: {{ box.id }}</p>
			<p class="card-header-title">
				<a @click="editDiscount">
					<span class="icon">
						<i class="mdi mdi-pencil-outline"></i>
					</span>
				</a>

				<a @click="deleteBox">
					<span class="icon">
						<i class="mdi mdi-trash-can-outline"></i>
					</span>
				</a>
			</p>
		</header>
		<div class="card-content">
			<div class="content">
				<div class="is-size-5">
					<div class="discount-word">Discount:</div>
					<div
						class="discount-value"
						ref="discount"
						:contenteditable="discountEditing"
						@keydown.enter.exact.prevent
						@keydown.enter="updateDiscount"
						@keydown.esc="resetDiscount"
						@input="discountChanged()"
					>{{ box.discount }}</div>%
				</div>
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
							<td>{{ product.name }} (id: {{ product.id }})</td>
							<td>{{ product.count }}x</td>
						</tr>
					</tbody>
				</table>
				<p class="is-size-5">Final price: ${{ box.price }}</p>
			</div>
		</div>
	</div>
</template>

<script>
export default {
	props: {
		box: {
			type: Object,
			default() {
				return {}
			}
		}
	},

	data() {
		return {
			discountEditing: false,
			oldDiscount: '',
			newDiscount: ''
		}
	},

	methods: {
		/**
		 * Emit event 'delete-box' to the parent.
		 *
		 * @returns void
		 */
		deleteBox() {
			this.$emit('delete-box', { id: this.box.id })
		},

		/**
		 * Start editing discount.
		 *
		 * @returns void
		 */
		editDiscount() {
			this.discountEditing = true
			this.selectDiscount()
		},

		/**
		 * Select discount for quick editing.
		 *
		 * @returns void
		 */
		selectDiscount() {
			setTimeout(() => {
				let p = this.$refs.discount,
					s = window.getSelection(),
					r = document.createRange()
				r.setStart(p, 0)
				r.setEnd(p, 1)
				s.removeAllRanges()
				s.addRange(r)
				p.focus()
			}, 0)
		},

		/**
		 * Reset discount to its old value.
		 *
		 * @returns void
		 */
		resetDiscount() {
			if ((this.discountEditing = true)) {
				this.discountEditing = false
				this.$refs.discount.innerText = this.oldDiscount
			}
		},

		/**
		 * Discount changed.
		 *
		 * @returns void
		 */
		discountChanged() {
			this.newDiscount = this.$refs.discount.innerText
		},

		/**
		 * Update discount.
		 *
		 * @returns void
		 */
		updateDiscount() {
			if (
				this.newDiscount != '' &&
				this.newDiscount >= 0 &&
				this.newDiscount <= 100
			) {
				this.discountEditing = false
				this.callApi('patch', `/api/boxes/${this.box.id}`, {
					discount: this.newDiscount
				}).then(res => {
					if (res.status == 201) {
						this.$root.$emit('flash-message', {
							message: res.data.message
						})

						// Info to parent to update prices of boxes
						this.$emit('discount-updated')
					}
				})

				this.oldDiscount = this.newDiscount
			} else {
				this.resetDiscount()
			}
		}
	},

	mounted() {
		// Set up initial values of discount
		this.oldDiscount = this.newDiscount = this.box.discount
	}
}
</script>

<style lang="scss" scoped>
i {
	color: black;
}

[contenteditable='true'] {
	outline: none;
	border-bottom: 1px solid rgb(7, 7, 7);
}

.discount-value,
.discount-word {
	display: inline;
}
</style>
