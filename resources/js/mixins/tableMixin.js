import moment from 'moment'

export default {
	data() {
		return {
			data: [],
			search: ''
		}
	},
	methods: {
		shorten(text, len = 50) {
			return _.truncate(text, {
				length: len
			})
		},
		niceDate(datetime) {
			return moment(datetime).format('D.M.YYYY')
		}
	}
}
