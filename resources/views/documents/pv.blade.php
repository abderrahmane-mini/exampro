<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>PV de Notes</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        h1, h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 30px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: center; }
        .meta { margin-top: 20px; }
    </style>
</head>
<body>

    <h1>Procès-Verbal de Notes</h1>

    <div class="meta">
        <p><strong>Module :</strong> {{ $module->name }}</p>
        <p><strong>Groupe :</strong> {{ $group->name }}</p>
        <p><strong>Date de l'examen :</strong> {{ $exam->date }} à {{ $exam->time }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Étudiant</th>
                <th>Note</th>
            </tr>
        </thead>
        <tbody>
            @foreach($grades as $grade)
            <tr>
                <td>{{ $grade->student->name }}</td>
                <td>{{ $grade->grade }}/20</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
