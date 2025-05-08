document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('termo');
    searchInput.addEventListener('input', function() {
        console.log('Busca: ' + this.value);
        // Adicione lógica de filtro aqui (ex.: AJAX para buscar sem recarregar)
    });
});