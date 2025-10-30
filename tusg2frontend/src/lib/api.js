import axios from 'axios'
const api = axios.create({ baseURL: '/api', timeout: 10000 })

api.interceptors.response.use(
    r => r,
    err => {
        const status = err?.response?.status
        const body   = err?.response?.data
        console.error('[API ERROR]', status, body)
        // attach a friendly message for UI
        const msg = body?.message || body?.error || body?.errors?.binName || err.message || 'Request failed.'
        err.friendlyMessage = `${status || '??'}: ${msg}`
        return Promise.reject(err)
    }
)

export default api
