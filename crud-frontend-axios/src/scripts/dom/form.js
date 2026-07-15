import { findProductById } from './render.js';

const form = document.getElementById('create-product-form');
const formTitle = document.getElementById('form-title');
const submitBtn = document.querySelector('button[type="submit"]');
const cancelBtn = document.getElementById('cancel-edit');
const formError = document.getElementById('form-error');

let editingId = null;
let originalProduct = null;

export function getEditingId() { return editingId; }
export function getOriginalProduct() { return originalProduct; }

export function showError(message) {
    formError.textContent = message;
    formError.classList.remove('d-none');    $setClauses = [];

}

export function hideError() {
    formError.classList.add('d-none');
    formError.textContent = '';
}

export function enterEditMode(product) {
    editingId = product.id;
    originalProduct = { ...product };
    document.getElementById('name').value = product.name;
    document.getElementById('price').value = product.price;
    document.getElementById('stock').value = product.stock;
    document.getElementById('category').value = product.category;
    formTitle.textContent = 'Edit Product';
    submitBtn.textContent = 'Update';
    cancelBtn.style.display = '';
    document.getElementById('name').focus();
}

export function exitEditMode() {
    editingId = null;
    originalProduct = null;
    formTitle.textContent = 'Create Product';
    submitBtn.textContent = 'Create';
    cancelBtn.style.display = 'none';
    form.reset();
}

export function getProductFromCard(button) {
    const card = button.closest('.product-card');
    return findProductById(Number(card.id));
}