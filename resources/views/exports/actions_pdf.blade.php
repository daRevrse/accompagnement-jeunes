<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Liste des actions</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #aaa;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #eee;
        }
    </style>
</head>

<body>
    <h2>📊 Liste des actions</h2>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Promoteur</th>
                <th>Entreprise active</th>
                <th>Chiffre d'affaires</th>
                <th>Perspectives</th>
            </tr>
        </thead>
        <tbody>
            @foreach($actions as $a)
            <tr>
                <td>{{ $a->date_action }}</td>
                <td>{{ $a->promoteur->nom }}</td>
                <td>{{ $a->entreprise_active ? 'Oui' : 'Non' }}</td>
                <td>{{ $a->chiffre_affaires ?? '-' }}</td>
                <td>{{ $a->perspectives ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>