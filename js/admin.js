
function confirmAction(action, orderID) {
    if (confirm("Are you sure you want to " + action + " this order?")) {
        const form = document.createElement("form");
        form.method = "POST";
        form.action = "admin.php";

        const inputOrderID = document.createElement("input");
        inputOrderID.type = "hidden";
        inputOrderID.name = "orderID";
        inputOrderID.value = orderID;

        const inputAction = document.createElement("input");
        inputAction.type = "hidden";
        inputAction.name = "action";
        inputAction.value = action;

        form.appendChild(inputOrderID);
        form.appendChild(inputAction);
        document.body.appendChild(form);
        form.submit();
    }
}

function confirmDelete(productID) {
    if (confirm("Are you sure you want to delete this product?")) {
        const form = document.createElement("form");
        form.method = "POST";
        form.action = "admin.php";

        const inputProductID = document.createElement("input");
        inputProductID.type = "hidden";
        inputProductID.name = "productID";
        inputProductID.value = productID;

        const inputDelete = document.createElement("input");
        inputDelete.type = "hidden";
        inputDelete.name = "delete_product";
        inputDelete.value = "1";

        form.appendChild(inputProductID);
        form.appendChild(inputDelete);
        document.body.appendChild(form);
        form.submit();
    }
}

function editProduct(productID, productName, manufacturer, price, stock, category) {
    document.getElementById('productID').value = productID;
    document.getElementById('productName').value = productName;
    document.getElementById('manufacturer').value = manufacturer;
    document.getElementById('price').value = price;
    document.getElementById('stock').value = stock;
    document.getElementById('category').value = category;
    document.getElementById('edit_product_button').style.display = 'inline';
    document.getElementById('add_product_button').style.display = 'none';
}

function resetForm() {
    document.getElementById('productID').value = '';
    document.getElementById('productName').value = '';
    document.getElementById('manufacturer').value = '';
    document.getElementById('price').value = '';
    document.getElementById('stock').value = '';
    document.getElementById('category').value = '';
    document.getElementById('edit_product_button').style.display = 'none';
    document.getElementById('add_product_button').style.display = 'inline';
}
