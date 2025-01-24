@can('admin-access')
    @extends('layouts.Admin.app')

    @section('content')
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">

                        <h5>Equipment Schedule</h5>

                        <div id="scheduler_here" class="dhx_cal_container" style='width:100%; height:100%;'>
                            <div class="dhx_cal_navline">
                                <div class="dhx_cal_prev_button">&nbsp;</div>
                                <div class="dhx_cal_next_button">&nbsp;</div>
                                <div class="dhx_cal_today_button"></div>
                                <div class="dhx_cal_date"></div>
                                <div class="dhx_cal_tab" name="day_tab"></div>
                                <div class="dhx_cal_tab" name="week_tab"></div>
                                <div class="dhx_cal_tab" name="month_tab"></div>
                            </div>
                            <div class="dhx_cal_header"></div>
                            <div class="dhx_cal_data"></div>
                        </div>

                        <script type="text/javascript">
                            scheduler.serverList("equipments", []);
                            scheduler.serverList("farmers", []);

                            fetch('/api/equipments')
                                .then(response => response.json())
                                .then(data => {
                                    scheduler.updateCollection("equipments", data);
                                });

                            fetch('/admin/farmers')
                                .then(response => response.json())
                                .then(data => {
                                    // Ensure data is in the correct format for serverList
                                    const farmerOptions = data.map(item => ({
                                        key: item.id, // Use the id as the key
                                        label: item.name // Use the name as the label
                                    }));
                                    scheduler.updateCollection("farmers", farmerOptions);
                                });

                            scheduler.config.lightbox.sections = [{
                                    name: "Select Farmers",
                                    height: 30,
                                    map_to: "farmer_id", // Make sure this matches the property in your event data
                                    type: "select",
                                    options: scheduler.serverList("farmers")
                                },
                                {
                                    name: "Select Equipment",
                                    height: 30,
                                    map_to: "equipment_id",
                                    type: "select",
                                    options: scheduler.serverList("equipments")
                                },
                                {
                                    name: "time",
                                    height: 72,
                                    type: "time",
                                    map_to: "auto"
                                }
                            ];

                            // display

                            scheduler.templates.event_text = function(start, end, event) {
                                return "Farmer: " + event.farmer_name + "<br>Equipment: " + event.equipment_name;
                            };
                            scheduler.config.drag_resize = false;
                            scheduler.config.server_utc = true; // This makes sure the server time zone is used
                            scheduler.config.time_zone = "Asia/Manila";
                            scheduler.config.date_format = "%Y-%m-%d %H:%i:%s";
                            scheduler.config.drag_move = false;
                            scheduler.init("scheduler_here", new Date(), "week");


                            scheduler.load("/api/events", "json");


                            // saving the events
                            // Save the event after editing (this is where we send the updated event data to the backend)
                            scheduler.attachEvent("onEventSave", function(id, event_object) {
                                let eventData = {
                                    id: id,
                                    start_date: formatDate(event_object.start_date),
                                    end_date: formatDate(event_object.end_date),
                                    equipment_id: event_object.equipment_id,
                                    farmer_id: event_object.farmer_id,
                                };

                                // Date format conversion function
                                function formatDate(date) {
                                    let d = new Date(date);
                                    return d.toISOString().slice(0, 19).replace('T', ' '); // Converts to YYYY-MM-DD HH:MM:SS
                                }

                                // Send the event data to the backend to save it in the database
                                fetch('/admin/save-event', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                                'content')
                                        },
                                        body: JSON.stringify(eventData)
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.status === 'success') {
                                            // Show success notification using Toastr
                                            toastr.success('Event saved successfully!');

                                            // Reload the page
                                            setTimeout(() => {
                                                window.location.reload(); // Reload the page after a short delay
                                            }, 700); // Adjust the delay if necessary (2 seconds here)
                                        } else {
                                            toastr.error('Failed to save event');
                                        }
                                    })
                                    .catch(error => console.log('Error:', error));

                            });

                            // delete events

                            scheduler.attachEvent("onBeforeEventDelete", function(id) {
                                // Send a DELETE request to your backend
                                fetch('/admin/delete-event/' + id, {
                                        method: 'DELETE',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                                'content')
                                        }
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        if (data.status === 'success') {
                                            toastr.success('Event Deleted Successfully!');
                                            setTimeout(() => {
                                                window.location.reload(); // Reload the page after a short delay
                                            }, 700); // Adjust the delay if necessary (2 seconds here)
                                        } else {
                                            toastr.error('Failed to delete the event!');
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                        toastr.error('Failed to delete the event');
                                    });

                                // Return false to prevent the default action until the request is complete
                                return false;
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>
    @endsection
@endcan


</body>

</html>
