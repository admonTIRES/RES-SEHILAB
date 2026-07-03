
$("#boton_guardar_evidencia_planos").click(function (e) {
    e.preventDefault();


    formularioValido = validarFormulario3($('#form_evidencia_planos'))

    if (formularioValido) {

    if (ID_PLANOS_ERGO == 0) {
        
        alertMensajeConfirm({
            title: "¿Desea guardar la información?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('boton_guardar_evidencia_planos')
            await ajaxAwaitFormData({ api: 1,RECO_ID: recsensorial, ID_PLANOS_ERGO: ID_PLANOS_ERGO }, 'planosergo', 'form_evidencia_planos', 'boton_guardar_evidencia_planos', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                    ID_PLANOS_ERGO = data.planos.ID_PLANOS_ERGO
                    alertMensaje('success','Información guardada correctamente', 'Esta información esta lista para usarse',null,null, 1500)
                     $('#modal_evidencia_planos').modal('hide')
                    document.getElementById('form_evidencia_planos').reset();
                    Tablaplanoergo.ajax.reload()
                
            })
            
            
            
        }, 1)
        
    } else {
            alertMensajeConfirm({
            title: "¿Desea editar la información de este formulario?",
            text: "Al guardarla, se podra usar",
            icon: "question",
        },async function () { 

            await loaderbtn('boton_guardar_evidencia_planos')
            await ajaxAwaitFormData({ api: 1, RECO_ID: recsensorial, ID_PLANOS_ERGO: ID_PLANOS_ERGO }, 'planosergoplanosergo', 'form_evidencia_planos', 'boton_guardar_evidencia_planos', { callbackAfter: true, callbackBefore: true }, () => {
        
                Swal.fire({
                    icon: 'info',
                    title: 'Espere un momento',
                    text: 'Estamos guardando la información',
                    showConfirmButton: false
                })

                $('.swal2-popup').addClass('ld ld-breath')
        
                
            }, function (data) {
                    
                setTimeout(() => {

                    ID_PLANOS_ERGO = data.planos.ID_PLANOS_ERGO
                    alertMensaje('success', 'Información editada correctamente', 'Información guardada')
                     $('#modal_evidencia_planos').modal('hide')
                    document.getElementById('form_evidencia_planos').reset();
                    Tablaplanoergo.ajax.reload()

                }, 300);  
            })
        }, 1)
    }

} else {
    alertToast('Por favor, complete todos los campos del formulario.', 'error', 2000)

}
    
});
