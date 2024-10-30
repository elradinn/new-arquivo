<!DOCTYPE html>
<html>
<head>
    <title>Folder Report - {{ $folder->name }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px;}
        th, td { border: 1px solid #000; padding: 8px; text-align: left;}
        th { background-color: #f2f2f2;}
    </style>
</head>
<body>
    <h1>Report for Folder: {{ $folder->name }}</h1>

    <h2>Documents</h2>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Owner</th>
                <th>Last Modified</th>
                <th>Size</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->owned_by }}</td>
                    <td>{{ $item->updated_at }}</td>
                    <td>{{ $item->size }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>