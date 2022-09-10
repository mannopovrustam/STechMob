<x-app-layout>
    <x-slot name="header">Xodim</x-slot>
    <div class="container-fluid">
        @livewire('employee', ['data' => $data])
    </div>
</x-app-layout>