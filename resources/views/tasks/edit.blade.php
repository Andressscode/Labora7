@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Editar Tarea</h4>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>¡Atención!</strong> Por favor, corrige los siguientes errores:
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $task->name) }}" class="form-control @error('name') is-invalid @enderror" placeholder="Nombre de la tarea" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="priority" class="form-label">Prioridad</label>
                            <select name="priority" id="priority" class="form-select @error('priority') is-invalid @enderror" required>
                                <option value="baja" {{ old('priority', $task->priority) == 'baja' ? 'selected' : '' }}>Baja</option>
                                <option value="media" {{ old('priority', $task->priority) == 'media' ? 'selected' : '' }}>Media</option>
                                <option value="alta" {{ old('priority', $task->priority) == 'alta' ? 'selected' : '' }}>Alta</option>
                            </select>
                            @error('priority')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Descripción</label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="3" placeholder="Describe la tarea">{{ old('description', $task->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="user_id" class="form-label">Usuario</label>
                            <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                                <option value="">Selecciona un usuario</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id', $task->user_id) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="completed" class="form-label">Completada</label>
                            <div class="form-check">
                                <input type="hidden" name="completed" value="0">
                                <input type="checkbox" name="completed" id="completed" value="1" class="form-check-input @error('completed') is-invalid @enderror" {{ old('completed', $task->completed) ? 'checked' : '' }}>
                                <label class="form-check-label" for="completed">Marcar como completada</label>
                            </div>
                            @error('completed')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="etiquetas" class="form-label">Etiquetas</label>
                            <select name="etiquetas[]" id="etiquetas" class="form-select @error('etiquetas') is-invalid @enderror" multiple>
                                @foreach($etiquetas as $etiqueta)
                                    <option value="{{ $etiqueta->id }}" {{ in_array($etiqueta->id, old('etiquetas', $task->etiquetas->pluck('id')->toArray())) ? 'selected' : '' }}>
                                        {{ $etiqueta->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('etiquetas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                Actualizar Tarea
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection