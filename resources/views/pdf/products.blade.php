<!DOCTYPE html>
<html>
<head>
    <title>Sản Phẩm</title>
    <style>
        body {
            font-family: "Roboto";
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Sản phẩm</h1>
    <table >
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Link</th>
                <th>Giá sản phẩm</th>
                <th>Số lượng</th>
                <th>Hãng</th>
                <th>Loại</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->slug }}</td>
                <td>{{ $product->regular_price }}</td>
                <td>{{ $product->quantity }}</td>
                <td>{{ $product->brand->name }}</td>
                <td>{{ $product->category->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
