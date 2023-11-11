let paso=1;const pasoInicial=1,pasoFinal=3,cita={id:"",nombre:"",fecha:"",hora:"",precio:0,servicios:[]};function iniciarApp(){tabs(),mostrarSeccion(),paginador(),paginaAnterior(),paginaSiguiente(),consultarAPI(),llenarNombre(),llenarId(),llenarFecha(),llenarHora()}function mostrarSeccion(){seccionAnterior=document.querySelector(".mostrar"),seccionAnterior&&seccionAnterior.classList.remove("mostrar"),seccion=document.querySelector("#paso-"+paso),seccion.classList.add("mostrar"),anterior=document.querySelector(".select"),anterior.classList.remove("select"),actual=document.querySelector(`[data-paso="${paso}"]`),actual&&actual.classList.add("select")}function tabs(){document.querySelectorAll(".tabs button").forEach(e=>{e.addEventListener("click",(function(e){paso=parseInt(e.target.dataset.paso),mostrarSeccion(),paginador()}))})}function paginador(){const e=document.querySelector("#anterior"),t=document.querySelector("#siguiente");1===paso?(t.classList.remove("ocultar"),e.classList.add("ocultar")):3===paso?(e.classList.remove("ocultar"),t.classList.add("ocultar"),mostrarResumen()):(e.classList.remove("ocultar"),t.classList.remove("ocultar")),mostrarSeccion()}function paginaAnterior(){document.querySelector("#anterior").addEventListener("click",(function(){paso<=1||(paso--,paginador())}))}function paginaSiguiente(){document.querySelector("#siguiente").addEventListener("click",(function(){paso>=3||(paso++,paginador())}))}async function consultarAPI(){try{const e="/api/servicios",t=await fetch(e);mostrarServicios(await t.json())}catch(e){console.log(e)}}function mostrarServicios(e){e.forEach(e=>{const{id:t,nombre:a,precio:o}=e,n=document.createElement("P");n.classList.add("nombre-servicio"),n.textContent=a;const c=document.createElement("P");c.classList.add("precio-servicio"),c.textContent="$"+o;const r=document.createElement("DIV");r.classList.add("servicio"),r.dataset.idServicio=t,r.onclick=function(){seleccionarServicio(e)},r.appendChild(n),r.appendChild(c),document.querySelector("#servicios").appendChild(r)})}function seleccionarServicio(e){const{id:t}=e,{servicios:a}=cita,o=document.querySelector(`[data-id-servicio="${t}"]`);a.some(e=>e.id===t)?(cita.servicios=a.filter(e=>e.id!==t),o.classList.remove("seleccionado"),cita.precio=parseInt(cita.precio)-parseInt(e.precio)):(cita.servicios=[...a,e],o.classList.add("seleccionado"),cita.precio=parseInt(cita.precio)+parseInt(e.precio))}function llenarNombre(){const e=document.querySelector("#nombre");cita.nombre=e.value}function llenarId(){const e=document.querySelector("#id").value;cita.id=e}function llenarFecha(){document.querySelector("#fecha").addEventListener("input",(function(e){const t=new Date(e.target.value).getUTCDay();[0,6].includes(t)?(e.target.value="",mensajeAlerta("Cerrado Sabados y Domingos","error",".formulario")):cita.fecha=e.target.value}))}function llenarHora(){document.querySelector("#hora").addEventListener("input",(function(e){const t=e.target.value.split(":")[0];t<9||t>19?(e.target.value="",cita.hora=e.target.value,mensajeAlerta("Abrimos desde las 9 a las 19hs","error",".formulario")):cita.hora=e.target.value}))}function mensajeAlerta(e,t,a,o=!0){const n=document.querySelector(".alerta");n&&n.remove();const c=document.querySelector(a),r=document.createElement("DIV");r.classList.add(t),r.classList.add("alertas"),r.classList.add("alerta"),r.textContent=e,c.appendChild(r),o&&setTimeout(()=>{r.remove()},3e3)}function mostrarResumen(){const e=document.querySelector("#paso-3");for(;e.firstChild;)e.removeChild(e.firstChild);if(Object.values(cita).includes("")||0===cita.servicios.length)return void mensajeAlerta("Seleccione los servicios y Complete los datos para la cita","error","#paso-3",!1);const t=document.createElement("H3");t.textContent="Resumen de tus servicios",e.appendChild(t);const{nombre:a,fecha:o,hora:n,precio:c,servicios:r}=cita;r.forEach(t=>{const{id:a,precio:o,nombre:n}=t,c=document.createElement("DIV");c.classList.add("contenedor-servicio");const r=document.createElement("P");r.innerHTML="$"+o;const i=document.createElement("P");i.textContent=n,c.appendChild(i),c.appendChild(r),e.appendChild(c)});const i=new Date(o),s=i.getDate()+2,l=i.getMonth(),d=i.getFullYear();fechaUTC=new Date(Date.UTC(d,l,s));const u=fechaUTC.toLocaleDateString("es-AR",{weekday:"long",year:"numeric",month:"long",day:"numeric"}),m=document.createElement("P");m.classList.add("nombre-cliente"),m.innerHTML="<span>Nombre:</span> "+a;const p=document.createElement("P");p.innerHTML="<span>Fecha:</span> "+u;const v=document.createElement("P");v.innerHTML="<span>Hora:</span> "+n;const h=document.createElement("P");h.innerHTML="<span>Precio Total:</span> $"+c;const f=document.createElement("BUTTON");f.classList.add("boton"),f.dataset.existe="existe",f.textContent="Reservar cita",f.onclick=reservarCita,e.appendChild(m),e.appendChild(p),e.appendChild(v),e.appendChild(h);if(!document.querySelector('[data-existe="existe"]')){document.querySelector(".paginacion").appendChild(f)}}async function reservarCita(){const{nombre:e,fecha:t,hora:a,servicios:o,id:n,precio:c}=cita,r=new FormData;r.append("usuarioId",n),r.append("hora",a),r.append("fecha",t),r.append("precio",c);const i=o.map(e=>e.id);r.append("servicios",i);try{const e="/api/citas",t=await fetch(e,{method:"POST",body:r}),a=await t.json();console.log(a.resultado),a.resultado&&Swal.fire({icon:"success",title:"Cita Creada",text:"Tu cita fue creada correctamente",width:600}).then(()=>{setTimeout(()=>{window.location.reload()},1e3)})}catch(e){Swal.fire({icon:"error",title:"Hubo un problema",text:"No pudimos reservar tu cita",width:600})}}document.addEventListener("DOMContentLoaded",(function(){iniciarApp()}));