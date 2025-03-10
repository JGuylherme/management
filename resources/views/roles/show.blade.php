<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Role Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-center mt-8">
                <div class="relative overflow-x-auto shadow-lg sm:rounded-lg w-1/2">
                    <table class="w-full text-sm text-left text-gray-500 shadow-md rounded-lg">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                            <tr>
                                <th scope="col" class="px-6 py-3 w-1/2">Attribute</th>
                                <th scope="col" class="px-6 py-3 w-1/2">Value</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-6 py-4">Id</td>
                                <td class="px-6 py-4">{{ $role->id }}</td>
                            </tr>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-6 py-4">Code</td>
                                <td class="px-6 py-4">{{ $role->code }}</td>
                            </tr>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-6 py-4">Name</td>
                                <td class="px-6 py-4">{{ $role->name }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="flex justify-start mt-8">
                <a href="{{ route('roles.index') }}" class="text-white font-bold py-2 px-4 rounded"
                    style="font: bold; background-color: cornflowerblue; transition: background-color 0.3s;"
                    onmouseover="this.style.backgroundColor='blue'" onmouseout="this.style.backgroundColor='steelblue'">
                    Back to Roles
                </a>
            </div>
        </div>
    </div>
</x-app-layout>