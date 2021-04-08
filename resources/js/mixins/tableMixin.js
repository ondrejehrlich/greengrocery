import moment from 'moment'

export default {
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
