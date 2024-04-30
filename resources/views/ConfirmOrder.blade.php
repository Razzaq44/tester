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
        <h1>Confirm</h1>
        <div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Menu</th>
                        <th scope="col">Harga</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $index = 1;
                    @endphp
                    @foreach ($data as $order => $item)
                    <tr>
                        <td>
                            <p>{{ $index }}</p> <!-- Unique ID -->
                        </td>
                        <td>
                            {{ $item['nama'] }}
                        </td>
                        <td>
                            {{ $item['harga'] }}
                        </td>
                        <td>
                            <button type="submit" id="minus_{{ $item['id'] }}" class="btn">-</button> <!-- Unique ID -->
                            <span id="jumlah_{{ $item['id'] }}">{{ $item['jumlah'] }}</span> <!-- Unique ID -->
                            <button id="plus_{{ $item['id'] }}" class="btn">+</button> <!-- Unique ID -->
                        </td>
                        <td>
                            <form action="{{ url('/hapus/'.$item['id']) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @php
                    $index++;
                    @endphp
                    @endforeach
                </tbody>
            </table>
        </div>
        <h2 id="total_harga">JUMLAH HARGA: Rp. {{ $total }}</h1>
            <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="formFile" class="form-label">Default file input example</label>
                    <input class="form-control" type="file" name="fileToUpload" id="formFile" accept=".jpg,.jpeg" required>
                    <small id="fileHelp" class="form-text text-danger d-none">Please select a valid JPG or JPEG file.</small>
                </div>
                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
            </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>