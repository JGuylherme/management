<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Roles List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-center mt-8">
                <div class="relative overflow-x-auto shadow-lg sm:rounded-lg w-1/2">
                    <table class="w-full text-sm text-left text-gray-500 shadow-md rounded-lg">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                            <tr>
                                <th scope="col" class="px-6 py-3 w-1/2">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3 w-1/2 text-center">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach ($roles as $role)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        {{ $role->name }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('roles.show', $role->id) }}"
                                            class="text-white rounded-full px-2 py-1 mx-2"
                                            style="background-color: steelblue;">View</a>
                                        <a href="{{ route('roles.edit', $role->id) }}"
                                            class="text-white rounded-full px-2 py-1 mx-2"
                                            style="background-color: goldenrod;">Edit</a>
                                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-white rounded-full px-2 py-1"
                                                style="background-color: crimson;">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="flex justify-end mt-8">
                <a href="{{ route('roles.create') }}" class="text-white font-bold py-2 px-4 rounded"
                    style="font: bold; background-color: palegreen; transition: background-color 0.3s;"
                    onmouseover="this.style.backgroundColor='forestgreen'" 
                    onmouseout="this.style.backgroundColor='palegreen'">
                    Add Role
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
