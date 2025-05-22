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

        .filter-container select,
        #eventTypeSelect {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }

        .calendar-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
            margin-top: 20px;
        }

        .add-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .add-btn:hover {
            background-color: #45a049;
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
                    let eventType = prompt("Enter the event type (Apskate, Serviss, Cits):");
                    let eventText = prompt("Enter the description:");

                    if (eventText && eventType) {
                        fetch('/api/events', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                date: selectedDate,
                                title: eventType,
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
                        alert("All fields are required.");
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
