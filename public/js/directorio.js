//Inicio validacion frontend
jQuery(function ($) {
    $("#usuarioForm").validate({
        rules: {
            nombre: {
                required: true,
                minlength: 4
            },
            apellido: {
                required: true,
                minlength: 3
            },
            email: {
                required: true,
                email: true
            },
            telefono: {
                required: true,
                minlength: 8,
                digits: true
            },
            old_password: {
                required: function () {
                    return $('#password').val() !== '' || $('#confirm_password').val() !== '';
                }
            },
            password: {
                required: function () {
                    return $('#old_password').val() !== '';
                },
                minlength: 8
            },
            confirm_password: {
                required: function () {
                    return $('#old_password').val() !== '';
                },
                minlength: 8,
                equalTo: "#password"
            }
        },
        messages: {
            nombre: {
                required: "Por favor, introduce el nombre del usuario",
                minlength: "El nombre debe tener al menos 4 caracteres"
            },
            apellido: {
                required: "Por favor, introduce el apellido del usuario",
                minlength: "El apellido debe tener al menos 3 caracteres"
            },
            email: {
                required: "Por favor, introduce el correo electrónico",
                email: "Por favor, introduce un correo electrónico válido"
            },
            telefono: {
                required: "Por favor, introduce el teléfono del usuario",
                minlength: "El teléfono debe tener al menos 8 caracteres",
                digits: "Por favor, ingresa un número de teléfono válido"
            },
            old_password: {
                required: "Por favor, introduce tu contraseña anterior para cambiarla"
            },
            password: {
                required: "Por favor, introduce una nueva contraseña",
                minlength: "La contraseña debe tener al menos 8 caracteres"
            },
            confirm_password: {
                required: "Por favor, confirma la nueva contraseña",
                minlength: "La contraseña debe tener al menos 8 caracteres",
                equalTo: "Las contraseñas no coinciden"
            }
        },
        submitHandler: function (form) {
            var formData = new FormData(form);

            if ($('#id_user').val() > 0) {
                urlSend = urlUpdate;
            } else {
                urlSend = urlSave;
            }
            $.ajax({
                url: urlSend,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    if (response.success) {
                        $('#usuarioModal').modal('hide');
                        toastGuardado(true, 'Registrado exitosamente');
                        loadTable();
                    } else {
                        toastGuardado(false, response.message);
                    }
                },
                error: function (xhr, status, error) {
                    var errors = xhr.responseJSON.errors;
                    for (const [key, value] of Object.entries(errors)) {
                        toastGuardado(false, value);
                    }
                }
            });
        }
    });
});
//Fin validación frontend

// Inicio Carga de los registros de forma asíncrona
function loadTable() {
    $.ajax({
        url: urlDataUsuarios,
        type: 'GET',
        success: function (response) {
            if (response.success) {
                let tableHtml =
                    '<thead style="background-color: #EBF2FB">' +
                    '<tr>' +
                    '<th class="text-center">Nombre</th>' +
                    '<th class="text-center">Apellido</th>' +
                    '<th class="text-center">Email</th>' +
                    '<th class="text-center">Telefono</th>' +
                    '<th class="text-center">Estado</th>' +
                    '<th class="text-center">Opciones</th>' +
                    '</tr>' +
                    '</thead><tbody>';

                if (response.users && response.users.length > 0) {
                    response.users.forEach(function (user) {
                        tableHtml += `
                    <tr>
                        <td class="text-center">${user.user.id}</td>
                        <td class="text-center">${user.nombre}</td>
                        <td class="text-center">${user.apellido}</td>
                        <td class="text-center">${user.user.email}</td>
                        <td class="text-center">${user.telefono}</td>
                        <td class="text-center">
                            <span class="badge ${user.user.status == 1 ? 'bg-success' : 'bg-danger'}">
                                ${user.user.status == 1 ? 'Activo' : 'Inactivo'}
                            </span>
                        </td>                                 
                        <td class="text-center tdOpciones">
                            <button class="btn btn-primary text-white btn-sm" title="Editar"
                                    onclick="editRegister(${user.user.id})">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" title="Eliminar"
                                    onclick="deleteRegister(${user.user.id})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                    });
                } else {
                    tableHtml +=
                        `<tr><td colspan="6" class="text-center">No hay usuarios disponibles</td></tr>`;
                }

                tableHtml += "</tbody>";
                $('#table').html(tableHtml);
                if ($.fn.dataTable.isDataTable('#table')) {
                    $('#table').DataTable().clear().destroy();
                }
                $('#table').DataTable({
                    paging: true,
                    searching: true,
                    ordering: true,
                    info: true,
                    "order": [
                        [0, "desc"]
                    ]
                });
            } else {
                console.error('No se pudo cargar los usuarios.');
            }
        },
        error: function (xhr, status, error) {
            console.error("Error al cargar la tabla:", error);
            alert("Hubo un error al cargar los datos.");
        }
    });
}
//Fin Carga de los registros de forma asíncrona

//Inicio Registrar
$('#addUsuario').click(function () {
    emptyForm();
    $("#editForm").hide();

    $('#usuarioModal').modal('show', true);
    /* $("#save").prop('disabled', true); */

    $('#update').hide();
    $('#save').show();
    $('#usuarioModalLabel').html('Registrar Usuario');
});
// Fin Registrar

//Inicio Editar
function editRegister(a) {
    emptyForm();
    $('#usuarioModal').modal('show', true);
    $.ajax({
        type: 'GET',
        url: urlEdit,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                'content')
        },
        data: {
            id: a
        },
        beforeSend: function () { },
        success: function (response) {
            if (response.responseCode == 200) {

                $("#nombre").val(response.data.nombre);
                $("#apellido").val(response.data.apellido);
                $("#telefono").val(response.data.telefono);
                $("#email").val(response.data.email);
                $("#status").val(response.data.status);
                $("#id_user").val(response.data.id);
                $("#editForm").show();
                $("#update").show();
                $('#save').hide();

            }
        },
        error: function (xhr, status, error) {
            alert(error)
        }
    });
}
//Fin Editar


//Inicio Eliminar Registro
function deleteRegister(id) {
    $('#id_delete').val(id);
    $('#deleteConfirmModal').modal('show', true);
    $('#confirmDelete').prop('disabled', false);
}

$('#confirmDelete').click(function () {
    var id = $('#id_delete').val();
    $('#confirmDelete').prop('disabled', true);

    $.ajax({
        type: 'POST',
        url: urlDelete,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                'content')
        },
        data: {
            id: id
        },
        beforeSend: function () { },
        success: function (response) {
            if (response.responseCode == 200) {
                toastGuardado(true, 'Servicio eliminado exitosamente');
                $('#deleteConfirmModal').modal('hide');
                loadTable();

            }
            $('#update').prop('disabled', false);
        },
        error: function (xhr, status, error) { }
    });
});
// Fin Eliminar Registro

//Inicio Toast
function toastGuardado(mensaje, text) {
    if (mensaje == true) {
        Toastify({
            text: text,
            className: "success",
            style: {
                background: "linear-gradient(to right, #00b09b, #96c93d)",
            },
            duration: 500,
            close: true,
        }).showToast();

    } else {
        Toastify({
            text: text,
            className: "error",
            style: {
                background: "linear-gradient(to right, #ff5f6d, #ffc371)",
            },
            duration: 800,
            close: true,
        }).showToast();
    }
}
//Fin toast

//Inicio limpiar form
function emptyForm() {
    $("#nombre").val('');
    $("#apellido").val('');
    $("#email").val('');
    $("#telefono").val('');
    $("#password").val('');
    $("#id_user").val('');
    $("#confirm_password").val('');
}
//Fin Limpiar form