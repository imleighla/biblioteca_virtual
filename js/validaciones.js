// Archivo que contiene las validaciones del lado del cliente para los formularios del sistema.
// Se espera a que el contenido de la página cargue completamente antes de ejecutar el script.
document.addEventListener("DOMContentLoaded", function () {
    // Se obtienen las referencias a los formularios para validarlos según la página.
    const formularioRegistro = document.getElementById("formRegistro");
    const formularioLogin = document.getElementById("formLogin");
    const formularioLibro = document.getElementById("formLibro");
    // Validaciones del formulario de registro.
    if (formularioRegistro) {
        formularioRegistro.addEventListener("submit", function (e) {
            const nombre = document.getElementById("nombre").value.trim();
            const email = document.getElementById("email").value.trim();
            const password = document.getElementById("password").value.trim();
            const confirmarPassword = document.getElementById("confirmar_password").value.trim();
            // Se verifica que todos los campos obligatorios del registro estén completos.
            if (nombre === "" || email === "" || password === "" || confirmarPassword === "") {
                alert("Todos los campos son obligatorios.");
                e.preventDefault();
                return;
            }
            // Expresión regular utilizada para validar el formato del correo electrónico.
            const expresionEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!expresionEmail.test(email)) {
                alert("Ingrese un correo electrónico válido.");
                e.preventDefault();
                return;
            }
            // Se valida que la contraseña tenga una longitud mínima aceptable.
            if (password.length < 6) {
                alert("La contraseña debe tener al menos 6 caracteres.");
                e.preventDefault();
                return;
            }
            // Se comprueba que la contraseña coincida con la confirmación.
            if (password !== confirmarPassword) {
                alert("Las contraseñas no coinciden.");
                e.preventDefault();
                return;
            }
        });
    }
    // Validaciones del formulario de inicio de sesión.
    if (formularioLogin) {
        formularioLogin.addEventListener("submit", function (e) {
            const email = document.getElementById("email").value.trim();
            const password = document.getElementById("password").value.trim();

            if (email === "" || password === "") {
                alert("Todos los campos son obligatorios.");
                e.preventDefault();
                return;
            }

            const expresionEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!expresionEmail.test(email)) {
                alert("Ingrese un correo electrónico válido.");
                e.preventDefault();
                return;
            }
        });
    }
    // Validaciones del formulario de agregar o editar libros.
    if (formularioLibro) {
        formularioLibro.addEventListener("submit", function (e) {
            const titulo = document.getElementById("titulo").value.trim();
            const autor = document.getElementById("autor").value.trim();
            const edicion = document.getElementById("edicion").value.trim();
            const anio = document.getElementById("anio_publicacion").value.trim();
            const estado = document.getElementById("estado").value.trim();
            const categoria = document.getElementById("categoria_id").value.trim();

            if (titulo === "" || autor === "" || edicion === "" || anio === "" || estado === "" || categoria === "") {
                alert("Todos los campos obligatorios deben completarse.");
                e.preventDefault();
                return;
            }
            // Se valida que el año de publicación tenga formato numérico de cuatro dígitos.  
            if (isNaN(anio) || anio.length !== 4) {
                alert("El año de publicación no es válido.");
                e.preventDefault();
                return;
            }
        });
    }
});