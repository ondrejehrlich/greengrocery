export default {
	methods: {
		async callApi(method, url, data, params) {
			try {
				return await axios({
					method,
					url,
					data,
					params
				})
			} catch (e) {
				return e.response
			}
		}
	}
}
