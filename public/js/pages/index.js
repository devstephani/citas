const frm= document.querySelector('#formulario');
document.addEventListener('DOMContentLoaded', function(){
    $( '.select-auto' ).select2( {
    theme: 'bootstrap-5'
    } );
   // VALIDAR CAMPOS
    frm.addEventListener('submit', function(e){
        e.preventDefault();
        if (frm.f_reserva.value == '' 
            || frm.hora.value =='' 
            || frm.servicio.value == '') {
            alertaSW('Todos los campos son requeridos', 'warning')
        }else{
            this.submit();
        }
    });
})



