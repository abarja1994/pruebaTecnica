<div class="table-responsive">
    <table class="table table-bordered table-hover table-conf" id="table" style="">
        <thead style="background-color: #EBF2FB">
            <tr>
                <th class="text-center ">CÓDIGO</th>
                <th class="text-center">NOMBRE</th>
                <th class="text-center">APELLIDO</th>
                <th class="text-center">CORREO</th>
                <th class="text-center">TELÉFONO</th>
                <th class="text-center">ESTADO</th>
                <th class="text-center">GESTIÓN</th>
            </tr>
        </thead>
        <tbody>
            @if (count($usuarios) > 0)
                @foreach ($usuarios as $usuario)
                    <tr>
                        <td class="text-center">{{ $usuario->user->id }}</td>
                        <td class="text-center">{{ $usuario->nombre }} </td>
                        <td class="text-center">{{ $usuario->apellido }} </td>
                        <td class="text-center">{{ $usuario->user->email }} </td>
                        <td class="text-center">{{ $usuario->telefono }} </td>
                        <td class="text-center">
                            @if ($usuario->user->status == 1)
                                <span class="badge bg-success">Activo</span>
                            @else
                                <span class="badge bg-danger">Inactivo</span>
                            @endif
                        </td>


                        <td class="text-center tdOpciones">
                            <button class="btn btn-primary text-white button-table" id="edit" title="Editar"
                                onclick="editRegister({{ $usuario->user->id }})">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="deleteRegister({{ $usuario->user->id }})" title="Eliminar"
                                class="btn btn-danger button-table" id="btnEliminar">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
