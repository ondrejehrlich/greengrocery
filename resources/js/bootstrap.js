import lodash from 'lodash'
import axios from 'axios'
import Vue from 'vue'

window._ = lodash
window.axios = axios
window.Vue = Vue

// Default headers for Axios requests (including csrf token)
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

let token = document.head.querySelector('meta[name="csrf-token"]')

if (token) {
	window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content
}
