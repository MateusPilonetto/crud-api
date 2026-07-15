import axios from 'https://cdn.jsdelivr.net/npm/axios@1.6.7/+esm';

export async function deleteProduct(apiUrl, id) {
    try {
        const response = await axios.delete(`${apiUrl}?id=${id}`);
        return response.data;
    } catch (error) {
        const message = error.response?.data?.error || 'Failed to delete product';
        throw new Error(message);
    }
}