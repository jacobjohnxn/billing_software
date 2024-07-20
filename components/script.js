let selectedProducts = [];

function addToSelection(product, button) {
    const quantityInput = button.parentNode.previousElementSibling.querySelector('.quantity-input');
    const quantity = parseInt(quantityInput.value);
    
    if (quantity > 0 && quantity <= product.quantity) {
        const existingProductIndex = selectedProducts.findIndex(p => p.id === product.id);
        
        if (existingProductIndex !== -1) {
            selectedProducts[existingProductIndex].quantity += quantity;
        } else {
            selectedProducts.push({...product, quantity: quantity});
        }
        
        updateSelectedProductsDisplay();
        quantityInput.value = 1; // Reset quantity input
    } else {
        alert('Please enter a valid quantity.');
    }
}

function updateSelectedProductsDisplay() {
    const selectedProductsDiv = document.getElementById('selectedProducts');
    selectedProductsDiv.innerHTML = '';
    
    if (selectedProducts.length === 0) {
        selectedProductsDiv.innerHTML = '<p>No products selected yet.</p>';
        return;
    }
    
    const ul = document.createElement('ul');
    ul.className = 'space-y-2';
    
    selectedProducts.forEach(product => {
        const li = document.createElement('li');
        li.className = 'flex justify-between items-center';
        li.innerHTML = `
            <span>${product.name}: ${product.quantity} item(s)</span>
            <button onclick="removeProduct(${product.id})" class="text-red-500 hover:text-red-700">Remove</button>
        `;
        ul.appendChild(li);
    });
    
    selectedProductsDiv.appendChild(ul);
}

function removeProduct(productId) {
    selectedProducts = selectedProducts.filter(p => p.id !== productId);
    updateSelectedProductsDisplay();
}