const apiURL = 'http://localhost:8888/tienda-php/src/index.php'
const productForm = document.getElementById('productForm')
const alertContainer = document.getElementById('alertContainer')
const productTableBody = document.getElementById('productTableBody')
const btnSubmit = document.getElementById('submitBtn')

document.addEventListener('DOMContentLoaded', () => {
    const botonesAgregar = document.querySelectorAll('.btn-agregar');

    botonesAgregar.forEach(boton => {
        boton.addEventListener('click', () => {
            alert('Producto agregado al carrito');
            agregarAlCarrito();
        });
    });
});


const loadProductos = async () => {
    try {
        const res = await fetch(apiURL + '/usuario', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            }
        })
        const productos = await res.json()
        productTableBody.innerHTML = ''
        productos.forEach((item) => {
            const row = document.createElement('tr')
            row.innerHTML =
                `
            <td>${item.idproducto}</td>
            <td>${item.nombre}</td>
            <td>${item.descripcion}</td>
            <td>${item.tipo}</td>
            <td>${item.precio}</td>
            <img src="${item.imagen}" width="100">
            <td>
            <button class="btn btn-warning btn-sm" data_id="${item.idproducto}">Editar</button>
            <button class="btn btn-danger btn-sm" data_id="${item.idproducto}">Borrar</button>
            </td>
            `
            productTableBody.appendChild(row)
        })
    } catch (error) {
        console.error('Error:', error);
    }
}

const agregarAlCarrito = async () => {
    const productId = document.getElementById('productId').value
    
    const producto = {
        usuario: document.getElementById('nombre').value || 'N/A',
        producto: document.getElementById('descripcion').value || 'Descripción no disponible'
    }

    if (productId) {
        producto.idproducto = productId
    }

    const url = `${apiURL}/usuario`
    const method = productId ? 'PUT' : 'POST'

    console.log('ruta y metodo => ', url, method, producto)
    const resultado = await fetch(url, {
        method: method,
        body: JSON.stringify(producto)
    })
    
    const response = await resultado.json()
    if (response.mensaje === 'Producto Creado') {
        showAlert('Producto Agregado', 'success')
        loadProductos()
        productForm.reset()
    } else if (response.mensaje === 'Producto Actualizado') {
        showAlert('Producto Actualizado', 'success')
        loadProductos()
        productForm.reset()
    } else {
        showAlert('Error al agregar el producto', 'danger')
    }
    document.getElementById('productId').value = ''

    console.log('@@@ response => ', response)
}