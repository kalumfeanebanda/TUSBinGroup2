import api from '@/lib/api'

// This file implements the actual API calls for the Steps resource.

/**
 * Fetches all steps from the API.
 * @returns {Promise<Array>} List of steps.
 */
export async function listSteps() {
    // Corresponds to GET /api/steps
    const r = await api.get('/steps')
    return r.data.data // Assuming the API returns { status: 'ok', data: [...] }
}

/**
 * Creates a new step.
 * @param {object} data - { stepTitle, stepDesc }
 */
export async function createStep(data) {
    // Corresponds to POST /api/steps
    const r = await api.post('/steps', data)
    return r.data
}

/**
 * Updates an existing step.
 * @param {number} id - The ID of the step to update.
 * @param {object} data - { stepTitle, stepDesc }
 */
export async function updateStep(id, data) {
    // Corresponds to PUT /api/steps/{id}
    const r = await api.put(`/steps/${id}`, data)
    return r.data
}

/**
 * Deletes a step.
 * @param {number} id - The ID of the step to delete.
 */
export async function deleteStep(id) {
    // Corresponds to DELETE /api/steps/{id}
    await api.delete(`/steps/${id}`)
}