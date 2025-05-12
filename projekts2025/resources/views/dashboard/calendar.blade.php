<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apkopes Kalendārs</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css">
    <style>
        .filter-container {
            margin-bottom: 20px;
        }

        .filter-container select {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="calendar-container">
        <div class="filter-container">
            <select id="eventFilter">
                <option value="">Filter by Event Type</option>
                <option value="Apskate">Apskate</option>
                <option value="Serviss">Serviss</option>
                <option value="Cits">Cits</option>
            </select>
        </div>

        <button class="add-btn" id="addEventBtn">Add Event</button>

        <div id="calendar">
            <div class="calendar-header">
                <span id="monthYear"></span>
            </div>
            <div id="calendarWrapper"></div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'lv',
                events: '/api/events',
                eventClick: function(info) {
                    alert(`Event: ${info.event.title}\n\nDescription: ${info.event.extendedProps.description}`);
                }
            });

            calendar.render();

            document.getElementById('addEventBtn').addEventListener('click', function() {
                let selectedDate = prompt("Enter the date (YYYY-MM-DD):");

                if (selectedDate) {
                    let eventText = prompt("Enter the description:");
                    let eventTitle = prompt("Select event type: Apskate, Serviss, or Cits");

                    if (eventText && eventTitle) {
                        fetch('/api/events', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                date: selectedDate,
                                title: eventTitle,
                                description: eventText
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            alert("Event added successfully!");
                            calendar.refetchEvents();
                        })
                        .catch(error => console.error('Error:', error));
                    } else {
                        alert("Both description and event type are required.");
                    }
                } else {
                    alert("No date entered.");
                }
            });

            document.getElementById('eventFilter').addEventListener('change', function() {
                var selectedFilter = this.value;

                fetch('/api/events?title=' + selectedFilter)
                    .then(response => response.json())
                    .then(data => {
                        calendar.removeAllEvents();
                        calendar.addEventSource(data);
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    </script>
</body>
</html>