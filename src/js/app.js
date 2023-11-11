let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;

const cita = {
    id: '',
    nombre: '',
    fecha: '',
    hora: '',
    precio: 0,
    servicios: []

}

document.addEventListener('DOMContentLoaded', function() {
    iniciarApp();
});

function iniciarApp() {
    tabs();
    mostrarSeccion();
    paginador();
    paginaAnterior();
    paginaSiguiente();

    consultarAPI();
    llenarNombre();
    llenarId();
    llenarFecha();
    llenarHora();

    
    
}

function mostrarSeccion() {

    //Remover la clase
    seccionAnterior = document.querySelector(`.mostrar`)
    if(seccionAnterior) {
        seccionAnterior.classList.remove('mostrar')
    }

    //añadir la clase
    seccion = document.querySelector(`#paso-${paso}`)
    seccion.classList.add('mostrar')

    //Desseleccionar el anterior
    anterior = document.querySelector('.select')
    anterior.classList.remove('select')

    //Cambiar el boton seleccionado
    actual = document.querySelector(`[data-paso="${paso}"]`)
    if(actual) {
    actual.classList.add('select')
    }

   
}


function tabs() {
    const botones = document.querySelectorAll('.tabs button');
    botones.forEach ( (boton) => {
        boton.addEventListener('click', function(e){
            paso = parseInt( e.target.dataset.paso ),
            mostrarSeccion(); 
            paginador();
        })
    });
}

function paginador() {
    const paginaAnterior = document.querySelector('#anterior')
    const paginaSiguiente = document.querySelector('#siguiente')
    
    if(paso === 1) {
        paginaSiguiente.classList.remove('ocultar')
        paginaAnterior.classList.add('ocultar')
    } else if(paso === 3) {
        paginaAnterior.classList.remove('ocultar')
        paginaSiguiente.classList.add('ocultar')
        mostrarResumen();
    } else {
        paginaAnterior.classList.remove('ocultar')
        paginaSiguiente.classList.remove('ocultar')
    }
    mostrarSeccion();
}
function paginaAnterior() {
    const paginaAnterior = document.querySelector('#anterior')
    paginaAnterior.addEventListener('click', function() {
    if (paso <= pasoInicial) return;
    paso--;
    paginador();
    })
}

function paginaSiguiente() {
    const paginaSiguiente = document.querySelector('#siguiente')
    paginaSiguiente.addEventListener('click', function() {
    if (paso >= pasoFinal) return;
    paso++;
    paginador();
    })
}

async function consultarAPI() {

    try {
        const url = `/api/servicios`;
        const resultado = await fetch(url);
        const servicios = await resultado.json();
        mostrarServicios(servicios);
    
    } catch (error) {
        console.log(error);
    }
}

function mostrarServicios(servicios) {
    servicios.forEach(servicio =>{
        const {id, nombre, precio} = servicio
        
        const nombreServicio = document.createElement('P')
        nombreServicio.classList.add('nombre-servicio')
        nombreServicio.textContent = nombre

        const precioServicio = document.createElement('P')
        precioServicio.classList.add('precio-servicio')
        precioServicio.textContent = `$${precio}`
        
        const servicioDiv = document.createElement('DIV')
        servicioDiv.classList.add('servicio')
        servicioDiv.dataset.idServicio = id
        servicioDiv.onclick = function() {
            seleccionarServicio(servicio)
        }

        servicioDiv.appendChild(nombreServicio)
        servicioDiv.appendChild(precioServicio)

        document.querySelector('#servicios').appendChild(servicioDiv)
    })
}

function seleccionarServicio(servicio) {
    const {id} = servicio
    const { servicios } = cita;
    const divServicio =  document.querySelector(`[data-id-servicio="${id}"]`)

    if( servicios.some( agregado => agregado.id === id) ) {
        cita.servicios = servicios.filter( agregado => agregado.id !== id );
        divServicio.classList.remove('seleccionado')
        cita.precio = parseInt( cita.precio )- parseInt( servicio.precio )
        
    } else {
        cita.servicios = [...servicios, servicio]
        divServicio.classList.add('seleccionado')
        cita.precio = parseInt( cita.precio )+ parseInt( servicio.precio )
        }
    
}

function llenarNombre() {
    const nombre = document.querySelector('#nombre')
    cita.nombre = nombre.value
}
function llenarId() {
    const id = document.querySelector('#id').value
    cita.id = id
}

function llenarFecha() {
    const inputfecha = document.querySelector('#fecha')
    inputfecha.addEventListener('input', function(e) {
        const dia = new Date(e.target.value).getUTCDay();
        if ([0, 6].includes(dia) ) {
            e.target.value = ''
            mensajeAlerta('Cerrado Sabados y Domingos', 'error', '.formulario');
        } else {
            cita.fecha =  e.target.value
        }
        
    })

}

function llenarHora() {
    const inputHora =  document.querySelector('#hora')
    inputHora.addEventListener('input', function(e){

        const hora =  e.target.value.split(":")[0]
        if(hora < 9 || hora > 19) {
            e.target.value = ''
            cita.hora = e.target.value
            mensajeAlerta('Abrimos desde las 9 a las 19hs', 'error', '.formulario')
        } else {
            cita.hora = e.target.value
        }
    })

}

function mensajeAlerta(mensaje, tipo, elemento , tiempo = true) {
    const existeAlerta = document.querySelector('.alerta')
    if (existeAlerta) {
        existeAlerta.remove()
    }
    const alerta = document.querySelector(elemento)
    const divAlerta = document.createElement('DIV')
    divAlerta.classList.add(tipo)
    divAlerta.classList.add('alertas')
    divAlerta.classList.add('alerta')
    divAlerta.textContent = mensaje

    alerta.appendChild(divAlerta)

    if(tiempo) {
        setTimeout(() =>{
            divAlerta.remove()
        }, 3000)
    }
}

function mostrarResumen() {
    const resumen = document.querySelector('#paso-3')

    while(resumen.firstChild) {
        resumen.removeChild(resumen.firstChild)
    }
    if (Object.values(cita).includes('') || cita.servicios.length === 0) {
        mensajeAlerta('Seleccione los servicios y Complete los datos para la cita', 'error', '#paso-3', false)
        return;
    } 
    //Heading
    const titulo = document.createElement('H3')
    titulo.textContent = "Resumen de tus servicios"
    resumen.appendChild(titulo)

    const { nombre, fecha, hora, precio, servicios} = cita

        servicios.forEach(servicio => {
        const {id, precio, nombre} = servicio
        const contenedorServicio = document.createElement('DIV')
        contenedorServicio.classList.add('contenedor-servicio')
        const precioServicio = document.createElement('P')
        precioServicio.innerHTML = `$${precio}`
        const nombreServicio = document.createElement('P')
        nombreServicio.textContent = nombre 
        

        contenedorServicio.appendChild(nombreServicio)
        contenedorServicio.appendChild(precioServicio)
        resumen.appendChild(contenedorServicio)
        
    })

        //Formatear fecha en español
        const fechaObj = new Date(fecha)
        const dia = fechaObj.getDate() + 2;
        const mes = fechaObj.getMonth();
        const year = fechaObj.getFullYear();
        fechaUTC = new Date(Date.UTC(year, mes, dia))
        
        const opciones = {weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }
        const fechaFormateada = fechaUTC.toLocaleDateString('es-AR', opciones)
        
        //Mostrando los servicios

        
        const nombreCita = document.createElement('P')
        nombreCita.classList.add('nombre-cliente')
        nombreCita.innerHTML = `<span>Nombre:</span> ${nombre}`
        const fechaCita = document.createElement('P')
        fechaCita.innerHTML = `<span>Fecha:</span> ${fechaFormateada}`
        const horaCita = document.createElement('P')
        horaCita.innerHTML = `<span>Hora:</span> ${hora}`
        const precioCita = document.createElement('P')
        precioCita.innerHTML = `<span>Precio Total:</span> $${precio}`

        
        const botonReservar = document.createElement('BUTTON')
        botonReservar.classList.add('boton')
        botonReservar.dataset.existe = 'existe'
        botonReservar.textContent = 'Reservar cita'
        botonReservar.onclick = reservarCita

        resumen.appendChild(nombreCita)
        resumen.appendChild(fechaCita)
        resumen.appendChild(horaCita)
        resumen.appendChild(precioCita)

        const existeBoton = document.querySelector(`[data-existe="existe"]`)
        if(!existeBoton) { 
            const paginacion = document.querySelector('.paginacion')
            paginacion.appendChild(botonReservar)
        
        } 
}
async function reservarCita() {
    const {nombre, fecha, hora, servicios, id, precio} = cita
    const datos = new FormData();
    datos.append('usuarioId', id);
    datos.append('hora', hora);
    datos.append('fecha', fecha);
    datos.append('precio', precio);

    const servicioId = servicios.map(servicio => servicio.id)
    
    datos.append('servicios', servicioId)

    // console.log([...datos])
    // return

    try {
        //Peticion a la api
    const url = `/api/citas`;
    const respuesta = await fetch(url, {
        method: 'POST',
        body: datos
    })
    const resultado = await respuesta.json();
    console.log(resultado.resultado)

    if(resultado.resultado) {
        Swal.fire({
            icon: 'success',
            title: 'Cita Creada',
            text: 'Tu cita fue creada correctamente',
            width: 600,
          }).then(() => {
            setTimeout(() => {
                window.location.reload();
            }, 1000);
          })
    }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Hubo un problema',
            text: 'No pudimos reservar tu cita',
            width: 600,
          })
    }
}
