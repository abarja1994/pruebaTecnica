@extends('layouts.adminLte')
@section('subtitle', 'Dashboard')
@section('content_header_title', 'Usuarios')
@section('content_header_subtitle', 'Inicio')
@section('content_body')

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('directorio.resources.modal')
    @include('utilitarios.modal_delete')

    <div class="col-md-12 mt-3">
        <p class="title-index"> GESTIÓN DE USUARIOS &nbsp
            <button class="btn btn-primary" id="addUsuario"> <i class="fas fa-plus"></i>
            </button>
        </p>
    </div>

    <div class="row ">
        <div class="card col-md-12">
            <div class="card-body">
                @include('directorio.resources.table')
            </div>
        </div>
    </div>
@stop

@push('js')
    <script>
        let urlSave = '{{ route('directorio.register', '') }}';
        let urlEdit = '{{ route('directorio.edit', '') }}';
        let urlUpdate = '{{ route('directorio.update', '') }}';
        let urlDelete = '{{ route('directorio.delete', '') }}';
        let urlDataUsuarios = '{{ route('directorio.getUsers') }}';
    </script>
    <script src="{{ asset('js/directorio.js') }}"></script>
@endpush

@push('css')
@endpush
