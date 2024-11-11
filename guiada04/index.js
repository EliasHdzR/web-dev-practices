const sFechaHora = document.querySelector('#s-fecha');
const btnGetFechaHora = document.querySelector('#btn-get-fecha-hora');

btnGetFechaHora.addEventListener('click', btnGetFechaHoraAsync_click);

function btnGetFechaHora_click(e){
    fetch('get_fecha_hora.php')
        .then(res => res.json())
        .then(resObj => {
            sFechaHora.textContent = resObj.fechaHora;
        });
}

async function btnGetFechaHoraAsync_click(e){
    btnGetFechaHora.disabled = true;
    const res = await fetch('get_fecha_hora.php');
    const resObj = await res.json();
    sFechaHora.textContent = resObj.fechaHora;
    btnGetFechaHora.disabled = false;
}