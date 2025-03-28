<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Attestation de Réussite</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            text-align: center;
            padding: 60px;
        }
        h1 {
            font-size: 28px;
            margin-bottom: 30px;
        }
        p {
            font-size: 16px;
            line-height: 1.8;
            margin: 10px 0;
        }
        .signature {
            margin-top: 80px;
            text-align: right;
            padding-right: 60px;
        }
        .bordered-box {
            border: 1px solid #000;
            padding: 15px;
            margin: 30px auto;
            display: inline-block;
            width: 60%;
        }
    </style>
</head>
<body>

    <h1>Attestation de Réussite</h1>

    <div class="bordered-box">
        <p>Nous attestons que :</p>
        <p><strong>{{ $student->name ?? 'Nom Étudiant Inconnu' }}</strong></p>
        <p>a réussi les examens de l'année académique avec succès.</p>
        <p><strong>Groupe :</strong> {{ $student->group->name ?? 'Non Assigné' }}</p>
        <p><strong>Moyenne générale :</strong> {{ isset($average) ? number_format($average, 2) . '/20' : 'N/A' }}</p>
    </div>

    <div class="signature">
        <p>Fait à {{ $location ?? 'ESRMI' }}, le {{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
        <p><strong>Le Directeur Pédagogique</strong></p>
    </div>

</body>
</html>
