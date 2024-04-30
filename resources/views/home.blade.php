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
  <div>
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
  </div>
  <div>
    <table class="table">
      <thead>
        <tr>
          <th>id</th>
          <th>Menu</th>
          <th>Harga</th>
          <th class="mx-auto">Jumlah</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($menu as $menu)
        <tr>
          <td id="barang">
            {{ $menu->id }}
          </td>
          <td>
            {{ $menu->nama }}
          </td>
          <td>
            {{ $menu->harga }}
          </td>
          <td>
            <button type="button" class="decreaseQuantity">-</button>
            <span class="quantity">1</span>
            <button type="button" class="increaseQuantity">+</button>
          </td>
          <td>
            <form action="{{ url('/menus/'.$menu->id) }}" method="POST">
              @csrf
              <input type="hidden" name="quantity_hidden" class="quantity_hidden" value="1">
              <button type="submit" class="btn btn-primary">Add To Cart</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

  <script>
    var increaseButtons = document.querySelectorAll('.increaseQuantity');

    increaseButtons.forEach(function(button) {
      button.addEventListener('click', function() {
        var row = button.closest('tr');
        var displayQuantity = row.querySelector('.quantity');
        var hiddenQuantity = row.querySelector('.quantity_hidden');
        var currentValue = parseInt(displayQuantity.innerText);
        var newValue = currentValue + 1;
        displayQuantity.innerText = newValue; // Update displayed quantity
        hiddenQuantity.value = newValue; // Update hidden quantity
      });
    });

    var decreaseButtons = document.querySelectorAll('.decreaseQuantity');

    decreaseButtons.forEach(function(button) {
      button.addEventListener('click', function() {
        var row = button.closest('tr');
        var displayQuantity = row.querySelector('.quantity');
        var hiddenQuantity = row.querySelector('.quantity_hidden');
        var currentValue = parseInt(displayQuantity.innerText);
        if (currentValue > 1) {
          var newValue = currentValue - 1;
          displayQuantity.innerText = newValue; // Update displayed quantity
          hiddenQuantity.value = newValue; // Update hidden quantity
        } // Update hidden quantity
      });
    });
  </script>



</body>

</html>