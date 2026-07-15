import axios from 'https://cdn.jsdelivr.net/npm/axios@1.6.7/+esm';

export async function createProduct(apiUrl, product) {
    try {
        const response = await axios.post(apiUrl, {
            name: product.name,
            price: parseFloat(product.price),
            stock: Number(product.stock),
            category: product.category,
        });

        return response.data;

    } catch (error) {
        const message = error.response?.data?.error || 'Failed to create product';
        console.error('Error creating product:', message);
        throw new Error(message);
    }
}