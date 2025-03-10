<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add Role') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <form method="post" action="{{ route('roles.store') }}">
                    @csrf
                    <div class="px-4 py-5 bg-white sm:p-6">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-4">
                                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" name="name" id="name" autocomplete="name"
                                    class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                            <div class="col-span-6 sm:col-span-4">
                                <label for="code" class="block text-sm font-medium text-gray-700">Code</label>
                                <input type="text" name="code" id="code" autocomplete="code"
                                    data-tippy-content="Format: 3 letters followed by 4 numbers (e.g., ADM0001)"
                                    class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <button type="submit"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Save
                        </button>
                    </div>
                </form>
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

<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>
<link rel="stylesheet" href="https://unpkg.com/tippy.js@6/dist/tippy.css" />
<link rel="stylesheet" href="{{ asset('css/tippy.css') }}">
<script src="{{ asset('js/tippy.js') }}"></script>
