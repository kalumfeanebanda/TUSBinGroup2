import api from '@/lib/api'

export async function listItems() {
    const r = await api.get('/items')
    return r.data.data
}

export async function createItem(data) {
    const r = await api.post('/items', data)
    return r.data
}

export async function updateItem(id, data) {
    const r = await api.put(`/items/${id}`, data)
    return r.data
}

export async function deleteItem(id) {
    await api.delete(`/items/${id}`)
}

// search functions
export async function searchNames(q) {
    const r = await api.get('/items/search-names', {
        params: { q }
    })
    return r.data
}


export async function getItem(id) {
    const r = await api.get(`/items/${id}`)
    return r.data
}
