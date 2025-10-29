import api from '@/lib/api'



export async function listBins() {
    const { data } = await api.get('/bins')       // -> { status, data: [...] }
    return data.data ?? []
}

export async function createBin(payload) {
    const { data } = await api.post('/bins', payload)  // -> { status, data: {...} }
    return data.data
}

export async function updateBin(id, payload) {
    const { data } = await api.put(`/bins/${id}`, payload) // -> { status, data: {...} }
    return data.data
}

export async function deleteBin(id) {
    const { data } = await api.delete(`/bins/${id}`)  // -> { status, ... }
    return data
}