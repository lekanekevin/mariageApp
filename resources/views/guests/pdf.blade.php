<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Liste des Invités</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Liste des Invités</h1>
        <h2>{{ $wedding->title }}</h2>
        <p>Lieu : {{ $wedding->location ?? 'Non défini' }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nom de l'invité</th>
                <th>Statut</th>
                <th>Table n°</th>
            </tr>
        </thead>
        <tbody>
            @foreach($guests as $guest)
            <tr>
                <td>{{ $guest->name }}</td>
                <td>{{ ucfirst($guest->status) }}</td>
                <td>{{ $guest->table_number ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>