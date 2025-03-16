export function validaCorreo(elemento) {
    let validEmail = /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;
    
    if (elemento.value === "") {
        mostrarMensaje(elemento, "El campo es obligatorio", false);
        return false;
    } else if (validEmail.test(elemento.value)) {
        mostrarMensaje(elemento, "Correcto!", true);
        return true;
    } else {
        mostrarMensaje(elemento, "Correo no válido!", false);
        return false;
    }
}
export function validaTelefono(elemento) {
    let validTelefono = /^\d{10}$/; // Solo acepta 10 dígitos numéricos

    if (elemento.value === "") {
        mostrarMensaje(elemento, "El campo es obligatorio", false);
        return false;
    } else if (validTelefono.test(elemento.value.trim())) {
        mostrarMensaje(elemento, "Número válido!", true);
        return true;
    } else {
        mostrarMensaje(elemento, "El número debe tener exactamente 10 dígitos.", false);
        return false;
    }
}
export function validaLargo(elemento, largo) {
    if (elemento.value === "") {
        mostrarMensaje(elemento, "El campo es obligatorio", false);
        return false;
    } else if (elemento.value.length !== largo) {
        mostrarMensaje(elemento, `Debe ser de ${largo} caracteres!`, false);
        return false;
    } else {
        mostrarMensaje(elemento, "Correcto!", true);
        return true;
    }
}

export function validaRango(elemento, min, max) {
    if (elemento.value === "") {
        mostrarMensaje(elemento, "El campo es obligatorio", false);
        return false;
    } else if (elemento.value.length < min || elemento.value.length > max) {
        mostrarMensaje(elemento, `Debe ser de mínimo ${min} caracteres y máximo ${max} caracteres!`, false);
        return false;
    } else {
        mostrarMensaje(elemento, "Correcto!", true);
        return true;
    }
}
export function validaSoloLetras(elemento) {
    let validLetras = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/;

    if (elemento.value === "") {
        mostrarMensaje(elemento, "El campo es obligatorio", false);
        return false;
    } else if (!validLetras.test(elemento.value)) {
        mostrarMensaje(elemento, "Solo se permiten letras!", false);
        return false;
    } else {
        mostrarMensaje(elemento, "Correcto!", true);
        return true;
    }
}
export function validaContrasena(elemento) {
    let validContrasena = /[!@#$%^&*()_+{}\[\]:;<>,.?~\\-]/;

    if (elemento.value === "") {
        mostrarMensaje(elemento, "El campo es obligatorio", false);
        return false;
    } else if (!validContrasena.test(elemento.value)) {
        mostrarMensaje(elemento, "Debe contener al menos un carácter especial!", false);
        return false;
    } else {
        mostrarMensaje(elemento, "Correcto!", true);
        return true;
    }
}

function mostrarMensaje(elemento, mensaje, esValido) {
    let mensajeElemento = elemento.parentElement.querySelector(esValido ? ".valid-feedback" : ".invalid-feedback");
    mensajeElemento.innerText = mensaje;
    
    elemento.classList.remove(esValido ? "is-invalid" : "is-valid");
    elemento.classList.add(esValido ? "is-valid" : "is-invalid");
}