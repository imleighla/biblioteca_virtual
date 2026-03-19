document.addEventListener("DOMContentLoaded", function () {
    const formularioRegistro = document.getElementById("formRegistro");
    const formularioLogin = document.getElementById("formLogin");
    const formularioLibro = document.getElementById("formLibro");

    if (formularioRegistro) {
        formularioRegistro.addEventListener("submit", function (e) {
            const nombre = document.getElementById("nombre").value.trim();
            const email = document.getElementById("email").value.trim();
            const password = document.getElementById("password").value.trim();
            const confirmarPassword = document.getElementById("confirmar_password").value.trim();

            if (nombre === "" || email === "" || password === "" || confirmarPassword === "") {
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

            if (password.length < 6) {
                alert("La contraseña debe tener al menos 6 caracteres.");
                e.preventDefault();
                return;
            }

            if (password !== confirmarPassword) {
                alert("Las contraseñas no coinciden.");
                e.preventDefault();
                return;
            }
        });
    }

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

    if (formularioLibro) {
        formularioLibro.addEventListener("submit", function (e) {
            const titulo = document.getElementById("titulo").value.trim();
            const autor = document.getElementById("autor").value.trim();
            const anio = document.getElementById("anio_publicacion").value.trim();
            const estado = document.getElementById("estado").value.trim();
            const categoria = document.getElementById("categoria_id").value.trim();

            if (titulo === "" || autor === "" || anio === "" || estado === "" || categoria === "") {
                alert("Todos los campos obligatorios deben completarse.");
                e.preventDefault();
                return;
            }

            if (isNaN(anio) || anio.length !== 4) {
                alert("El año de publicación no es válido.");
                e.preventDefault();
                return;
            }
        });
    }
});