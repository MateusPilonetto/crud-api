import { renderProducts } from './scripts/dom/render.js';
import {
    enterEditMode, exitEditMode, getEditingId, getOriginalProduct,
    getProductFromCard, showError, hideError,
} from './scripts/dom/form.js';
import { createProduct } from './scripts/api/create.js';
import { updateProduct } from './scripts/api/update.js';
import { deleteProduct } from './scripts/api/delete.js';

const apiUrl = 'http://localhost:8000/api/products';

const form = document.getElementById('create-product-form');
const cancelBtn = document.getElementById('cancel-edit');
const productsSection = document.getElementById('products');

const searchForm = document.getElementById('search-product-form');
const yesModalDelete = document.getElementById('yes-modal-delete');
const modal = document.getElementById('exampleModal');

let productToDeleteId = null;

productsSection.addEventListener('click', (event) => {
    const target = event.target;

    if (target.dataset.action === 'edit') {
        enterEditMode(getProductFromCard(target));
    }

    if (target.dataset.action === 'delete') {
        const product = getProductFromCard(target);
        productToDeleteId = product.id;
    }
});

yesModalDelete.addEventListener('click', async () => {
    if (productToDeleteId === null) return;

    await deleteProduct(apiUrl, productToDeleteId);
    if (getEditingId() === productToDeleteId) exitEditMode();
    await renderProducts(apiUrl);

    $('#exampleModal').modal('hide');    
});

document.addEventListener('DOMContentLoaded', () => renderProducts(apiUrl));
cancelBtn.addEventListener('click', exitEditMode);

form.addEventListener('submit', async (event) => {
    event.preventDefault();

    const name = document.getElementById('name').value;
    const price = document.getElementById('price').value;
    const stock = document.getElementById('stock').value;
    const category = document.getElementById('category').value;

    hideError();

    try {
        const editingId = getEditingId();
        const productData = { name, price, stock, category };

        if (editingId !== null) {
            const result = await updateProduct(apiUrl, editingId, productData, getOriginalProduct());
            if (result === null) { exitEditMode(); return; }
        } else {
            await createProduct(apiUrl, productData);
        }

        exitEditMode();
        renderProducts(apiUrl);
    } catch (error) {
        showError(error.message);
    }
});

searchForm.addEventListener('input', (event) => {
    
    event.preventDefault();

    const searchTerm = document.getElementById('search').value.trim();

    const searchUrl = searchTerm
        ? `${apiUrl}?search=${encodeURIComponent(searchTerm)}`
        : apiUrl;

    renderProducts(searchUrl);
});