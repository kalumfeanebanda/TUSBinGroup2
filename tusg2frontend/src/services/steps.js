import api from '@/lib/api'

/**
 * Fetch all steps
 */
export async function listSteps() {
    const r = await api.get('/steps')
    return r.data.data
}

/**
 * Create new Step
 */
export async function createStep(data) {
    const r = await api.post(
        '/steps',
        {
            itemCodeID: data.itemCodeID,
            stepTitle: data.stepTitle,
            stepLongDesc: data.stepLongDesc
        },
        {
            headers: { "Content-Type": "application/json" }
        }
    )
    return r.data
}

/**
 * Update Step
 */
export async function updateStep(id, data) {
    const r = await api.put(
        `/steps/${id}`,
        {
            itemCodeID: data.itemCodeID,
            stepTitle: data.stepTitle,
            stepLongDesc: data.stepLongDesc
        },
        {
            headers: { "Content-Type": "application/json" }
        }
    )
    return r.data
}

/**
 * Delete Step
 */
export async function deleteStep(id) {
    await api.delete(`/steps/${id}`)
}
