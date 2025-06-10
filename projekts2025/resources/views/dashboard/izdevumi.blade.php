<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8" />
    <title>Izdevumu pārvaldība</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
</head>
<body>
    <div class="container">
        <h2>Izdevumu pārvaldība</h2>

        @if(session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        <form id="carForm" method="POST" action="{{ route('izdevumi.store') }}">
            @csrf
            <input type="text" name="brand" placeholder="Zīmols" required />
            <input type="text" name="model" placeholder="Modelis" required />
            <input type="number" name="year" placeholder="Gads" required min="1900" max="2099" />
            <input type="number" name="mileage" placeholder="Nobraukums (km)" required min="0" />
            <button type="submit">Pievienot auto</button>
        </form>

        <h3>Mani auto:</h3>
        <ul id="carList" aria-label="Mani auto saraksts">
            @forelse($cars as $car)
                <li>{{ $car->brand }} {{ $car->model }} ({{ $car->year }}) - {{ $car->mileage }} km</li>
            @empty
                <li>Nav pievienotu auto</li>
            @endforelse
        </ul>

        <h3>Koplietot auto ar citu lietotāju</h3>
        <form id="shareForm">
            @csrf
            <select name="car_id" required aria-label="Izvēlies auto">
                @foreach($cars as $car)
                    <option value="{{ $car->id }}">{{ $car->brand }} {{ $car->model }} ({{ $car->year }})</option>
                @endforeach
            </select>
            <input type="email" name="user_email" placeholder="Lietotāja e-pasts" required />
            <button type="submit">Koplietot</button>
        </form>
    </div>

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
