import api from '@/lib/api'

// ===============================
// Fetch all steps
// GET /api/steps
// ===============================
export async function listSteps() {
    const r = await api.get('/steps')
    return r.data.data
}

// ===============================
// Create a new step
// POST /api/steps
// ===============================
export async function createStep(data) {
    return (await api.post('/steps', {
        itemCodeID: data.itemCodeID,
        stepTitle: data.stepTitle,
        stepDesc: data.stepDesc
    })).data
}

// ===============================
// Update existing step
// PUT /api/steps/{id}
// ===============================
export async function updateStep(id, data) {
    return (await api.put(`/steps/${id}`, {
        itemCodeID: data.itemCodeID,
        stepTitle: data.stepTitle,
        stepDesc: data.stepDesc
    })).data
}

// ===============================
// Delete step
// DELETE /api/steps/{id}
// ===============================
export async function deleteStep(id) {
    return await api.delete(`/steps/${id}`)
}
