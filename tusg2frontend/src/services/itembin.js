import api from '@/lib/api'  // 假设你有 axios 封装

// GET all mappings
export async function listItemBin() {
    const res = await api.get('/itembin')
    return res.data
}

// CREATE mapping
export async function createItemBin(data) {
    const res = await api.post('/itembin', data)
    return res.data
}

// UPDATE mapping (since the PK is composite, pass both IDs)
export async function updateItemBin(itemID, binTypeID, data) {
    const res = await api.put(`/itembin/${itemID}/${binTypeID}`, data)
    return res.data
}

// DELETE mapping
export async function deleteItemBin(itemID, binTypeID) {
    const res = await api.delete(`/itembin/${itemID}/${binTypeID}`)
    return res.data
}