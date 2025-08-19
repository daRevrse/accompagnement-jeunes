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
            <td>{{ $a->chiffre_affaire }}</td>
            <td>{{ $a->perspectives }}</td>
        </tr>
        @endforeach
    </tbody>
</table>