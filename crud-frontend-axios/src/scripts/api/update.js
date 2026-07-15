import axios from 'https://cdn.jsdelivr.net/npm/axios@1.6.7/+esm';

export async function putProduct(apiUrl, id, product) {
    try {
        const response = await axios.put(`${apiUrl}?id=${id}`, {
            name: product.name,
            price: Number(product.price),
            stock: Number(product.stock),
            category: product.category,
        });
        return response.data;
    } catch (error) {
        const message = error.response?.data?.error || 'Failed to update product';
        throw new Error(message);
    }
}

export async function patchProduct(apiUrl, id, fields) {
    try {
        const response = await axios.patch(`${apiUrl}?id=${id}`, fields);
        return response.data;
    } catch (error) {
        const message = error.response?.data?.error || 'Failed to patch product';
        throw new Error(message);
    }
}

export async function updateProduct(apiUrl, id, product, originalProduct) {
    const changedFields = {};
    if (product.name !== originalProduct.name) changedFields.name = product.name;
    if (Number(product.price) !== originalProduct.price) changedFields.price = Number(product.price);
    if (Number(product.stock) !== originalProduct.stock) changedFields.stock = Number(product.stock);
    if (product.category !== originalProduct.category) changedFields.category = product.category;

    if (Object.keys(changedFields).length === 0) return null;

    const allChanged = Object.keys(changedFields).length === 3;
    if (allChanged) {
        return putProduct(apiUrl, id, product);
    } else {
        return patchProduct(apiUrl, id, changedFields);
    }
}