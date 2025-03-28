@extends('layouts.app')

@section('content')
<x-page-title title="Moyennes" subtitle="Moyennes par module ou par étudiant" />

<x-alert />

<x-section>
    @if(count($averages))
        <table class="w-full table-auto">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2">Étudiant</th>
                    <th class="p-2">Moyenne générale</th>
                </tr>
            </thead>
            <tbody>
                @foreach($averages as $student => $avg)
                <tr class="border-b">
                    <td class="p-2">{{ $student }}</td>
                    <td class="p-2 font-semibold">{{ number_format($avg, 2) }}/20</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <x-empty-state message="Aucune moyenne disponible." />
    @endif
</x-section>
@endsection
