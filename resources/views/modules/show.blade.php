@extends('layouts.app')

@section('content')
    <x-page-title title="{{ $module->name }}" subtitle="Détails du module" />

    <x-section>
        <p><strong>Code :</strong> {{ $module->code }}</p>
        <p><strong>Nombre d’enseignants :</strong> {{ $module->teachers->count() }}</p>
        <p><strong>Nombre d’examens :</strong> {{ $module->exams->count() }}</p>
    </x-section>
@endsection
