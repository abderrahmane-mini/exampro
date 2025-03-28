<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Attestation de Réussite</title>
    <style>
        body { font-family: Georgia, serif; text-align: center; padding: 50px; }
        h1 { font-size: 28px; margin-bottom: 20px; }
        p { font-size: 16px; line-height: 1.6; }
        .signature { margin-top: 80px; text-align: right; padding-right: 60px; }
    </style>
</head>
<body>

    <h1>Attestation de Réussite</h1>

    <p>Nous attestons que :</p>

    <p><strong>{{ $student->name }}</strong></p>

    <p>a réussi les examens de l'année académique avec succès.</p>

    <p>Groupe : {{ $student->group->name }}</p>

    <p>Moyenne générale : {{ number_format($average, 2) }}/20</p>

    <div class="signature">
        <p>Fait à {{ $location ?? 'ESRMI' }}, le {{ now()->format('d/m/Y') }}</p>
        <p><strong>Le Directeur Pédagogique</strong></p>
    </div>

</body>
</html>
