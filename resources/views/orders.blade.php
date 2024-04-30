<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container">
        <nav>
            <ul class="nav justify-content-center">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Active</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/orders') }}">Cart</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/chat') }}">Chat</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled">Disabled</a>
                </li>
            </ul>
        </nav>

        @if (empty($data))
        <h1>No data</h1>
        @else
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
        <div class="row">
            <div class="col">
                <h2 id="total_harga">JUMLAH HARGA: Rp. {{ $total }}</h1>
            </div>
            <div class="col">
                <a href="{{ url('/confirmOrder') }}"><button type="submit" class="btn btn-dark">PESAN</button></a>
            </div>
        </div>
        @endif
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $("button[id^='plus_']").click(function() { // Use attribute starts with selector
                var menuId = this.id.split('_')[1]; // Get menu ID from button ID
                tambahKuantitas(menuId);
            });
        });

        function tambahKuantitas(menuId) {
            var kuantitasAwal = parseInt($("#jumlah_" + menuId).text());

            $.ajax({
                type: "POST",
                url: "{{ route('order.tambah') }}",
                data: {
                    id: menuId,
                    kuantitas_awal: kuantitasAwal,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    var newQuantity = response.kuantitas_baru;
                    var newTotal = response.totalHarga;

                    $("#jumlah_" + menuId).text(newQuantity);
                    $("#total_harga").text("JUMLAH HARGA: Rp. " + newTotal);
                },
                error: function() {
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                }
            });
        }

        // minus

        $(document).ready(function() {
            $("button[id^='minus_']").click(function() { // Use attribute starts with selector
                var menuId = this.id.split('_')[1]; // Get menu ID from button ID
                kurangKuantitas(menuId);
            });
        });

        function kurangKuantitas(menuId) {
            var kuantitasAwal = parseInt($("#jumlah_" + menuId).text());

            $.ajax({
                type: "POST",
                url: "{{ route('order.kurang') }}",
                data: {
                    id: menuId,
                    kuantitas_awal: kuantitasAwal,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    var newQuantity = response.kuantitas_baru;
                    var newTotal = response.totalHarga;

                    $("#jumlah_" + menuId).text(newQuantity);
                    $("#total_harga").text("JUMLAH HARGA: Rp. " + newTotal);
                },
                error: function() {
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                }
            });
        }
    </script>
</body>

</html>