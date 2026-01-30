<?php
// admin/includes/footer.php - Scripts y cierre del HTML
?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="../assets/js/panel.js"></script>
    <script>
    // Script para manejar el botón de editar
    $(document).ready(function() {
        // Cuando se hace clic en el botón editar
        $('.btn-editar').on('click', function(e) {
            e.preventDefault();
            var clienteId = $(this).data('id');
            cargarClienteParaEditar(clienteId);
        });
        
        // Función para cargar datos del cliente en el modal de edición
        function cargarClienteParaEditar(clienteId) {
            // Mostrar mensaje de carga
            showToast('⏳ Cargando datos del cliente...', 'info');
            
            // Obtener datos del cliente desde la base de datos
            $.ajax({
                url: '../obtener_cliente.php',
                type: 'GET',
                data: {id: clienteId},
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Llenar el formulario con los datos
                        $('#editar_cliente_id').val(response.cliente.id);
                        $('#editar_nombre').val(response.cliente.nombre);
                        $('#editar_correo').val(response.cliente.correo);
                        $('#editar_telefono').val(response.cliente.telefono);
                        $('#editar_tipo_evento').val(response.cliente.tipo_boda);
                        $('#editar_fecha_evento').val(response.cliente.fecha_evento);
                        $('#editar_mensaje').val(response.cliente.mensaje || '');
                        
                        // Cerrar cualquier modal abierto
                        $('.modal').modal('hide');
                        
                        // Limpiar cualquier backdrop residual
                        $('.modal-backdrop').remove();
                        
                        // Mostrar el modal de edición después de un breve retraso
                        setTimeout(() => {
                            var modal = new bootstrap.Modal(document.getElementById('modalEditarCliente'));
                            modal.show();
                            showToast('✅ Datos cargados correctamente', 'success');
                        }, 300);
                    } else {
                        showToast('❌ Error al cargar los datos: ' + response.message, 'error');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error AJAX:', error);
                    showToast('❌ Error de conexión al cargar los datos', 'error');
                }
            });
        }
        
        // Fix para el botón cancelar del modal de editar
        $('#btnCancelarEditar').on('click', function() {
            // Cerrar el modal correctamente
            var modal = bootstrap.Modal.getInstance(document.getElementById('modalEditarCliente'));
            if (modal) {
                modal.hide();
            }
            
            // Limpiar el backdrop residual
            setTimeout(() => {
                $('.modal-backdrop').remove();
                $('body').removeClass('modal-open');
                $('body').css('overflow', '');
                $('body').css('padding-right', '');
            }, 300);
        });
        
        // También para el botón cancelar en el footer
        $('#modalEditarCliente .btn-secondary').on('click', function() {
            $('#btnCancelarEditar').click();
        });
        
        // Función para mostrar notificaciones
        function showToast(message, type = 'info') {
            const types = {
                'success': {bg: '#28a745', icon: '✅'},
                'error': {bg: '#dc3545', icon: '❌'},
                'warning': {bg: '#ffc107', icon: '⚠️'},
                'info': {bg: '#17a2b8', icon: 'ℹ️'}
            };
            
            const config = types[type] || types.info;
            
            $('.toast-notification').remove();
            
            const toast = $(`
                <div class="toast-notification" style="
                    position: fixed;
                    top: 20px;
                    right: 20px;
                    background: white;
                    border-left: 4px solid ${config.bg};
                    padding: 15px 20px;
                    border-radius: 8px;
                    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
                    z-index: 99999;
                    max-width: 350px;
                    display: flex;
                    align-items: center;
                    animation: slideIn 0.3s ease;
                ">
                    <span style="font-size: 20px; margin-right: 10px;">${config.icon}</span>
                    <span style="font-size: 14px;">${message}</span>
                </div>
            `);
            
            $('body').append(toast);
            
            setTimeout(() => {
                toast.fadeOut(300, () => toast.remove());
            }, 4000);
        }
    });
    </script>
</body>
</html>