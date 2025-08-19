<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Liste des promoteurs</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px;
        }

        th {
            background-color: #eee;
        }
    </style>
</head>

<body>
    <h2>Liste des promoteurs</h2>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Email</th>
                <th>Projet</th>
                <th>Date d'entrée</th>
            </tr>
        </thead>
        <tbody>
            @foreach($promoteurs as $promoteur)
            <tr>
                <td>{{ $promoteur->nom }}</td>
                <td>{{ $promoteur->email }}</td>
                <td>{{ $promoteur->projet }}</td>
                <td>{{ $promoteur->date_entree_accompagnement }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>