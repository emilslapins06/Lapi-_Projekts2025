<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <title>Izdevumu pārvaldība</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="container">
        <h2>Izdevumu pārvaldība</h2>

        <form id="carForm">
            @csrf
            <input type="text" name="brand" placeholder="Zīmols" required>
            <input type="text" name="model" placeholder="Modelis" required>
            <input type="number" name="year" placeholder="Gads" required>
            <input type="number" name="mileage" placeholder="Nobraukums (km)" required>
            <button type="submit">Pievienot auto</button>
        </form>

        <h3>Mani auto:</h3>
        <ul id="carList">
            @foreach($cars as $car)
                <li>{{ $car->brand }} {{ $car->model }} ({{ $car->year }}) - {{ $car->mileage }} km</li>
            @endforeach
        </ul>
    </div>
    <h3>Koplietot auto ar citu lietotāju</h3>
    <form id="shareForm">
        <select name="car_id" required>
            @foreach($cars as $car)
                <option value="{{ $car->id }}">{{ $car->brand }} {{ $car->model }} ({{ $car->year }})</option>
            @endforeach
        </select>
        <input type="email" name="user_email" placeholder="Lietotāja e-pasts" required>
        <button type="submit">Koplietot</button>
    </form>

    <script>
         document.getElementById('shareForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const carId = formData.get('car_id');
        const userEmail = formData.get('user_email');

        fetch(`/cars/${carId}/share`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ user_email: userEmail })
        })
        .then(res => res.json())
        .then(data => {
            alert(data.message);
        })
        .catch(err => console.error('Error:', err));
    });
    </script>
</body>
</html>