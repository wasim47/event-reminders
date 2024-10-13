<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Reminder</title>
</head>
<body>
    <h1>Reminder for Your Event: {{ $event->name }}</h1>
    <p>Hello,</p>
    <p>This is a friendly reminder for the upcoming event:</p>
    <p><strong>Event Title:</strong> {{ $event->name }}</p>
    <p><strong>Date and Time:</strong> {{ $event->event_time }}</p>
    <p><strong>Location:</strong> {{ $event->location }}</p>
    <p>We hope to see you there!</p>
</body>
</html>