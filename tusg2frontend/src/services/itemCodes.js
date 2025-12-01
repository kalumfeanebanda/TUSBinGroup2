import api from '@/lib/api'

export async function listItemCodes() {
    const r = await api.get('/itemcodes')
    return r.data.data
}

export async function createItemCode(data) {
    const r = await api.post('/itemcodes', data)
    return r.data
}

export async function updateItemCode(id, data) {
    const r = await api.put(`/itemcodes/${id}`, data)
    return r.data
}

export async function deleteItemCode(id) {
    await api.delete(`/itemcodes/${id}`)
}
