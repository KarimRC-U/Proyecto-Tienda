const apiURL = 'http://localhost:8888/Proyecto-Tienda/src/index.php'
const alertContainer = document.getElementById('alertContainer')

const iniciarSesion = async () => {

    const data = {
        usuario: document.getElementById('usuario').value,
        password: document.getElementById('password').value
    };

    const url = `${apiURL}/cuenta/iniciarSesion`;
    const method = 'POST';
    const respuesta = await fetch(url, {
        method: method,
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    });
    const resultado = await respuesta.json();

    alert(resultado.message);
    console.log(resultado);
    if (resultado.status === 'success') {
        sessionStorage.setItem('loggedIn', 'true');
        sessionStorage.setItem('usuarioid', resultado.usuarioid);
        sessionStorage.setItem('nombre', resultado.nombre);
        sessionStorage.setItem('usuario', resultado.usuario);
        sessionStorage.setItem('correo', resultado.correo);
        sessionStorage.setItem('isVendedor', resultado.vendedor);
        window.location.href = resultado.redirect;
        
    }

    console.log(resultado);
}