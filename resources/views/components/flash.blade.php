@if(session('success'))
    <x-alert type="success">{{ session('success') }}</x-alert>
@endif
@if(session('error'))
    <x-alert type="danger">{{ session('error') }}</x-alert>
@endif
