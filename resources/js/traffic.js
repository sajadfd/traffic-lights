import $ from "jquery";

/**
 * Traffic light control function that updates the visual representation
 * of a traffic light sequence and sends log messages based on user actions.
 */
$(document).ready(function () {
    const RED_TIME = 5000;
    const YELLOW_TIME = 2000;
    const GREEN_TIME = 5000;
    var previousLight = null;

    /**
     * Updates the visual representation of traffic lights.
     */
    function updateTrafficLights() {
        const lights = ["#red", "#yellow", "#green"];

        // Deactivate all lights
        lights.forEach(function (light) {
            $(light).removeClass("active");
        });

        // Activate red light
        $("#red").addClass("active");

        setTimeout(function () {
            // Deactivate red, activate yellow
            $("#red").removeClass("active");
            $("#yellow").addClass("active");
            previousLight = "#red";

            setTimeout(function () {
                // Deactivate yellow, activate green
                $("#yellow").removeClass("active");
                $("#green").addClass("active");
                previousLight = "#yellow";

                setTimeout(function () {
                    // Deactivate green, activate yellow, and recursively call updateTrafficLights
                    $("#green").removeClass("active");
                    $("#yellow").addClass("active");
                    previousLight = "#green";
                    setTimeout(updateTrafficLights, YELLOW_TIME);
                }, GREEN_TIME);
            }, YELLOW_TIME);
        }, RED_TIME);
    }

    // Initial call to start the traffic lights sequence
    updateTrafficLights();

    /**
     * Event handler for the button click to simulate a vehicle passing through the intersection.
     */
    $("#btnForward").click(function () {
        var color = $(".light.active").attr("id");
        var message = "";

        // Determine appropriate message based on the current traffic light color
        if (color === "green") {
            message = "Проезд на зеленый!";
        } else if (color === "yellow") {
            if (previousLight === "#green") {
                message = "Успели на желтый!";
            } else if (previousLight === "#red") {
                message = "Слишком рано начали движение!";
            }
        } else if (color === "red") {
            message = "Проезд на красный. Штраф!";
        }

        // Retrieve CSRF token from meta tag
        var csrfToken = $('meta[name="csrf-token"]').attr("content");

        // Set up CSRF token in AJAX headers
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
        });

        // Send log message to the server
        $.ajax({
            type: "POST",
            url: "/log",
            data: {
                message: message,
            },
            success: function (data) {
                // Update logs on successful AJAX request
                updateLogs(data);
            },
            error: function (error) {
                console.log(error);
            },
        });
    });

    /**
     * Updates the log display based on the data received from the server.
     */
    function updateLogs(data) {
        console.log(data);
        var logs = data.logs;

        if (logs.length != 0) {
            $("#logsBody").empty();

            if (Array.isArray(logs)) {
                // Display each log entry in the logs table
                logs.forEach(function (log) {
                    var time = new Date(log.created_at).toLocaleTimeString();
                    $("#logsBody").append(
                        "<tr><td>" +
                            time +
                            "</td><td>" +
                            log.message +
                            "</td></tr>"
                    );
                });
            } else {
                console.error("Invalid logs format:", logs);
            }
        }
    }
});
