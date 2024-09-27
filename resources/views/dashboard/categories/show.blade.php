<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{config('app.name')}}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 2.5rem;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }

        table thead {
            background-color: #007bff;
            color: #fff;
        }

        table th, table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            font-weight: bold;
        }

        table tbody tr:hover {
            background-color: #f1f1f1;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            table, thead, tbody, th, td, tr {
                display: block;
                width: 100%;
            }
            table tr {
                margin-bottom: 10px;
            }
            table td {
                display: flex;
                justify-content: space-between;
                padding: 10px;
                border-bottom: 1px solid #ddd;
            }
        }
    </style>
</head>
<body>

<h1>Show Categories</h1>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Parent</th>
            <th>Image</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td> {{$category->id}}</td>
            <td><a href="/categories/{{$category->id}}">{{$category->name}}</a></td>
            <td>{{$category->parent_id}}</td>
            <td>
                <img src="{{ asset('storage/'.$category->image) }}" alt="" height="80">
            </td>
            <td>{{$category->created_at}}</td>
        </tr>
    </tbody>
</table>

</body>
</html>
