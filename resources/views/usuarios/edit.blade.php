<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Usuario</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow sm:rounded-lg border-t-4 border-indigo-500">
                <form action="{{ route('usuarios.update', $usuario) }}" method="POST">
                    @csrf @method('PUT')
                    <div class="space-y-4">
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Nombre</label>
                            <input type="text" name="name" value="{{ $usuario->name }}" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Email</label>
                            <input type="email" name="email" value="{{ $usuario->email }}" class="w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Rol</label>
                            <select name="role" class="w-full border-gray-300 rounded-md shadow-sm">
                                <option value="admin" {{ $usuario->role == 'admin' ? 'selected' : '' }}>Administrador</option>
                                <option value="empleado" {{ $usuario->role == 'empleado' ? 'selected' : '' }}>Empleado</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Nueva Contraseña (dejar en blanco para no cambiar)</label>
                            <input type="password" name="password" class="w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end">
                        <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>