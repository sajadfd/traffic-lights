<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Traffic Lights</title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>

<body class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <div id="trafficLights" class="d-flex flex-column align-items-center">
                <div id="red" class="light active"></div>
                <div id="yellow" class="light"></div>
                <div id="green" class="light"></div>
            </div>
            <button id="btnForward" class="btn btn-primary mt-3">Вперед</button>
        </div>
        <div class="col-md-6">
            <h3 class="mb-3">Logs</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Time</th>
                        <th scope="col">Message</th>
                    </tr>
                </thead>
                <tbody id="logsBody">
                    <!-- Logs will be displayed here -->
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>