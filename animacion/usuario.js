const btn = document.getElementsByClassName('boton')[0];
btn.addEventListener('click', enviarDatos);

function enviarDatos() {
    const nombre = document.getElementById('nombre').value;
    const apellido_paterno = document.getElementById('apellido_paterno').value;
    const apellido_materno = document.getElementById('apellido_materno').value;
    const email = document.getElementById('email').value;
    const telefono = document.getElementById('telefono').value;
    const tipoUsuario = document.querySelector('input[name="tipoUsuario"]:checked').value.toLowerCase();

    console.log(tipoUsuario);

    if(tipoUsuario === 'usuario'){
        console.log('entro');
        window.location.href = `usuario2.html?nombre=${nombre}&apellidos=${apellidos}&email=${email}&telefono=${telefono}&tipoUsuario=${tipoUsuario}`;
    }else{
        console.log('no entro');
        window.location.href = `Enfermera1.html?nombre=${nombre}&apellidoPaterno=${apellido_paterno}&apellidoMaterno=${apellido_materno}&email=${email}&telefono=${telefono}&tipoUsuario=${tipoUsuario}`;
    }

}