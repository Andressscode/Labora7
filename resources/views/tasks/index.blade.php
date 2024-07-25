@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-between align-items-center mb-4">
        <div class="col-lg-6">
            @auth
                <h4>Bienvenido, {{ auth()->user()->name }}</h4>
            @endauth
            <h2 class="mt-2">Tareas</h2>
        </div>
        <div class="col-lg-6 text-lg-end">
            @auth
                <a href="{{ route('tasks.create') }}" class="btn btn-outline-primary">Nueva Tarea</a>
            @else
                <div class="alert alert-warning" role="alert">
                    Inicia sesión para crear una nueva tarea.
                </div>
            @endauth
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ $message }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @guest
        <div class="alert alert-danger" role="alert">
            Debes iniciar sesión para ver y gestionar tareas.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Prioridad</th>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Usuario</th>
                        <th>Etiquetas</th>
                        <th>Acciones</th>
                        <th>Configuraciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr>
                            <td>{{ $task->id }}</td>
                            <td>{{ $task->name }}</td>
                            <td>
                                @if ($task->priority == 'baja')
                                    <span class="text-success">{{ $task->priority }}</span>
                                @elseif ($task->priority == 'media')
                                    <span class="text-warning">{{ $task->priority }}</span>
                                @elseif ($task->priority == 'alta')
                                    <span class="text-danger">{{ $task->priority }}</span>
                                @endif
                            </td>
                            <td>{{ Str::limit($task->description, 30) }}</td>
                            <td>
                                @if ($task->completed)
                                    <span class="badge bg-success">Completada</span>
                                @else
                                    <span class="badge bg-danger">Pendiente</span>
                                @endif
                            </td>
                            <td>{{ $task->user ? $task->user->name : 'Sin asignar' }}</td>
                            <td>
                                @foreach ($task->etiquetas as $etiqueta)
                                    <span class="badge bg-primary">{{ $etiqueta->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                <form action="{{ route('tasks.complete', $task->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-sm btn-primary">Completar</button>
                                </form>
                            </td>
                            <td>
                                <a class="btn btn-sm btn-secondary" href="{{ route('tasks.edit', $task->id) }}">Editar</a>
                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de querer eliminar esta tarea?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $tasks->links() }}
        </div>
    @endguest
</div>
@endsection