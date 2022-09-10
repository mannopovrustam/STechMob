<x-app-layout>
<x-slot name="header">
    {{ \App\Models\User::getWarehouse()->name }}
</x-slot>
</x-app-layout>
