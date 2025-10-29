import api from '@/lib/api'

export async function listUsers() {
    const { data } = await api.get('/users')
    return data.data ?? []
}



export async function createUser(payload) {
    const { data } = await api.post('/users', payload)
    return data
}

export async function deleteUser(id) {
    const { data } = await api.delete(`/users/${id}`)
    return data
}
