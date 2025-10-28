import api from '@/lib/api'



export async function listBins() {
    const { data } = await api.get('/bins')
    return data.data ?? []
}


export async function createBin(payload) {
    const { data } = await api.post('/bins', payload)
    return data
}



export async function deleteBin(id) {
    const { data } = await api.delete(`/bins/${id}`)
    return data
}

