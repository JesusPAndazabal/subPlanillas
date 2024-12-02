//Funciones para el llamado de las alertas

//Funcion alterna para el uso de las alertas
function alertSuccess(texto){
    Swal.fire({
        icon: 'success',
        titleText : 'QuerySheet',
        text: texto,
        color:'#ffff',
        iconColor : '#ffff',
        timer : 2500,
        timerProgressBar : true,
        toast: true,
        showConfirmButton : false,
        position : 'top-end',
        background : '#329261'  
    })
}

function alertInfo(texto){
    Swal.fire({
        icon: 'info',
        text: texto,
        titleText : 'QuerySheet',
        color:'#000',
        iconColor : '#ffff',
        timer : 2500,
        timerProgressBar : true,
        toast: true,
        showConfirmButton : false,
        position : 'top-end',
        background : '#5DADE2'  
    })
}

function alertWarning(texto){
    Swal.fire({
        icon: 'warning',
        text: texto,
        titleText : 'QuerySheet',
        color:'#000',
        iconColor : '#ffff',
        timer : 2500,
        timerProgressBar : true,
        toast: true,
        showConfirmButton : false,
        position : 'top-end',
        background : '#F4D03F'  
    })
}

function alertError(texto){
    Swal.fire({
        icon: 'error',
        text: texto,
        titleText : 'QuerySheet',
        color:'#ffff',
        iconColor : '#ffff',
        timer : 2500,
        timerProgressBar : true,
        toast: true,
        showConfirmButton : false,
        position : 'top-end',
        background : '#EC7063'  
    })
}

