import api from '@/lib/api'
export async function listBins() {
    const { data } = await api.get('/bins')
    return data.data ?? []
}
