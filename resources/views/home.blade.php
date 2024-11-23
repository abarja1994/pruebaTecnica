@extends('layouts.adminLte')
@section('subtitle', 'Dashboard')

@section('content_body')

    <div class="row ">
        <div class="col-md-4">
            <div class="card bg-primary text-white mb-4">
                <a href="{{ route('directorio.index')}}" class="text-white text-decoration-none">
                    <div class="card-body">
                        <h5 class="card-title">Usuarios</h5>
                        <p class="card-text card-dashboard-icon"><i class="fas fa-user"></i>&nbsp;
                            {{ $numUsuarios }}</p>
                    </div>
                </a>
            </div>
        </div>
        
    </div>
@stop


<style>
/*     .main-sidebar { background-color: #546F70 !important }
 */</style>
@push('css')
@endpush

@push('js')
@endpush
