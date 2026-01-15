<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Menu Items Export</title>
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
    <h1>Menu Items Export</h1>
    <div class="header-info">
        <p>Generated on: {{ date('Y-m-d H:i:s') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Dish Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @forelse($menu as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->dish }}</td>
                    <td>{{ $item->category ? $item->category->name : 'N/A' }}</td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td>{{ $item->description ?? 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">No menu items found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
