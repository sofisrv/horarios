let verificar = false;
const inputs = document.querySelectorAll('#frmLogin input');
const expresiones = {
    usuario: /^[a-zA-Z0-9\_\-]{4,16}$/, // Letras, numeros, guion y guion_bajo
    clave: /^.{4,12}$/, // 4 a 12 digitos.
}
const campos = {
    usuario: false,
    clave: false
}
const validarFormulario = (e) => {
    switch (e.target.name) {
        case "usuario":
            validarCampo(expresiones.usuario, e.target, 'usuario');
            break;
        case "clave":
            validarCampo(expresiones.clave, e.target, 'clave');
            break;
    }
}
const validarCampo = (expresion, input, campo) => {
    if (expresion.test(input.value)) {
        document.getElementById(campo).classList.remove('is-invalid');
        document.getElementById(campo).classList.add('is-valid');
        campos[campo] = true;
    } else {
        document.getElementById(campo).classList.add('is-invalid');
        document.getElementById(campo).classList.remove('is-valid');
        campos[campo] = false;
    }
}
inputs.forEach((input) => {
    input.addEventListener('keyup', validarFormulario);
    input.addEventListener('blur', validarFormulario);
});

function frmLogin(e) {
    e.preventDefault();
    const usuario = document.getElementById('usuario');
    const clave = document.getElementById('clave');
    if (usuario.campos) {
        usuario.classList.add('is-invalid');
        usuario.focus();
    } else if (clave.campos) {
        clave.classList.add('is-invalid');
        clave.focus();
    } else {
        const url = base_url + 'usuarios/validar';
        const frm = document.getElementById('frmLogin');
        const http = new XMLHttpRequest();
        http.open("POST", url, true);
        http.upload.addEventListener('progress', function () {
            document.getElementById('btnAccion').textContent = 'Procesando';
        });
        http.send(new FormData(frm));
        http.addEventListener('load', function () {
            if (verificar) {
                window.location = base_url + 'admin';
            }
            document.getElementById('btnAccion').textContent = 'Login';
        });
        http.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                const res = JSON.parse(this.responseText);
                if (res.msg == 'ok') {
                    verificar = true;
                }else{
                    alerta(res.msg, res.icono);
                }
            }
        }
    }
}
function alerta(msg, icono) {
    Swal.fire({
        position: 'top-end',
        icon: icono,
        title: msg,
        showConfirmButton: false,
        timer: 3000
    });
}