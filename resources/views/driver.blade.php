<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Orders</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $id => $item)
                <tr>
                    <td>{{ $id }}</td>
                    <td>
                        <ul class="list-group list-group-numbered">
                            @foreach ($item['orders'] as $order => $pesanan)
                            <li class="list-group-item">{{ $pesanan['nama'] }} x {{ $pesanan['jumlah'] }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>{{ $item['total'] }}</td>
                    <td>
                        <form action="{{ url('/takeOrder/' .  $id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-dark btn-sm">Take Orders</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>