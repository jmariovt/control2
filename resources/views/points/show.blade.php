@extends('layouts.app')

@section('content')
@include('common.success')
<div class="list-group">
    
        <li class="list-group-item">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">
                Nombre:
                </h5>
            </div>
            <p class="mb-1"> {{$point->name}}</p>
        </li>
         <li class="list-group-item">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">
                RUC:
                </h5>
            </div>
            <p class="mb-1"> {{$company->number}}</p>
        </li>
         <li class="list-group-item">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">
                Estado:
                </h5>
            </div>
            <p class="mb-1"> {{$company->status}}</p>
        </li>
         <li class="list-group-item">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">
                Direccion:
                </h5>
            </div>
            <p class="mb-1"> {{$company->address}}</p>
        </li>
         <li class="list-group-item">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">
                Teléfono 1:
                </h5>
            </div>
            <p class="mb-1"> {{$company->phone1}}</p>
        </li>
         <li class="list-group-item">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">
                Teléfono 2:
                </h5>
            </div>
            <p class="mb-1"> {{$company->phone2}}</p>
        </li>
         <li class="list-group-item">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">
                Nombre de contacto:
                </h5>
            </div>
            <p class="mb-1"> {{$company->contactName}}</p>
        </li>
         <li class="list-group-item">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">
                Teléfono de contacto:
                </h5>
            </div>
            <p class="mb-1"> {{$company->contactPhone}}</p>
        </li>
         <li class="list-group-item">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">
                Se encuentra al día:
                </h5>
            </div>
            <p class="mb-1"> {{$company->onDay}}</p>
        </li>
         <li class="list-group-item">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">
                Tiene empleado genérico:
                </h5>
            </div>
            <p class="mb-1"> {{$company->hasGenericEmployee}}</p>
        </li>


       
    
    
</div>
<div class="text-center">
<a href="/companies" class="btn btn-secondary">Regresar</a>
<a href="/companies/{{$company->slug}}/edit" class="btn btn-primary">Editar</a>
</div>
<modal-button></modal-button>

<create-form-sentinel></create-form-sentinel>
<list-of-sentinels></list-of-sentinels>

@endsection