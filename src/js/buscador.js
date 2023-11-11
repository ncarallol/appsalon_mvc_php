document.addEventListener('DOMContentLoaded', function() {
    iniciarApp();
})

function iniciarApp() {
    buscarFecha();
}

function buscarFecha() {
    fechaInput = document.querySelector('#date')
    document.addEventListener('input', function(e){
        fechaSeleccionada =  e.target.value
        window.location = `?fecha=${fechaSeleccionada}`
    })
}