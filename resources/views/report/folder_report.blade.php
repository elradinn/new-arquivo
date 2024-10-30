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
                <th>Last Modified</th>
                @foreach($folder->metadata_columns as $metadataColumn)
                    <th>{{ $metadataColumn['name'] }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->updated_at }}</td>
                    @foreach($folder->metadata_columns as $metadataColumn)
                        @php
                            // Find the metadata value for the current metadata column
                            $meta = collect($item->metadata)->firstWhere('id', $metadataColumn['id']);
                        @endphp
                        <td>{{ $meta['value'] ?? 'N/A' }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>