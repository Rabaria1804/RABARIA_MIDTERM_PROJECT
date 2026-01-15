<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Categories Export</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        h1 {
            color: #333;
            text-align: center;
        }
        .header-info {
            margin-bottom: 20px;
            text-align: right;
        }
    </style>
</head>
<body>
    <h1>Categories Export</h1>
    <div class="header-info">
        <p>Generated on: {{ date('Y-m-d H:i:s') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Category Name</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @forelse($category as $cat)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $cat->name }}</td>
                    <td>{{ $cat->description ?? 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align: center;">No categories found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
