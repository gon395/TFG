import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    const inputBusqueda = document.getElementById('busqueda');
    const tarjetas = document.querySelectorAll('.card-producto');

    inputBusqueda.addEventListener('input', () => {
        const texto = inputBusqueda.value.toLowerCase();
        tarjetas.forEach(card => {
            const nombre = card.querySelector('h3').textContent.toLowerCase();
            card.style.display = nombre.includes(texto) ? '' : 'none';
        });
    });
});

function agregarAlCarrito(productoId) {
    alert("Producto " + productoId + " añadido al carrito (ejemplo)");
    // Hacer una llamada AJAX para añadir realmente el producto
}

document.addEventListener('DOMContentLoaded', () => {
    // Confirmación al eliminar del carrito
    document.querySelectorAll('form[action*="carrito/eliminar"]').forEach(form => {
        form.addEventListener('submit', (e) => {
            if (!confirm('¿Deseas eliminar este producto del carrito?')) {
                e.preventDefault();
            }
        });
    });

    // Mensaje al finalizar compra
    const formFinalizar = document.querySelector('form[action*="carrito/finalizar"]');
    if (formFinalizar) {
        formFinalizar.addEventListener('submit', () => {
            alert('Compra finalizada. ¡Gracias por tu pedido!');
        });
    }
});
