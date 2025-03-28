<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Relevé de notes</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        h1, h2 { text-align: center; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: center; }
        .info { margin-top: 20px; }
    </style>
</head>
<body>

    <h1>Relevé de notes</h1>

    <div class="info">
        <p><strong>Nom :</strong> {{ $student->name }}</p>
        <p><strong>Groupe :</strong> {{ $student->group->name }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Module</th>
                <th>Note</th>
            </tr>
        </thead>
        <tbody>
            @foreach($grades as $grade)
                <tr>
                    <td>{{ $grade->exam->module->name }}</td>
                    <td>{{ $grade->grade }}/20</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p style="margin-top: 30px;"><strong>Moyenne générale :</strong> {{ number_format($average, 2) }}/20</p>

</body>
</html>
