<?php
    $title = "My Calender";
    require APPROOT . '/views/customer/header.php'; //path changed
?>
    <?php
        require APPROOT . '/views/customer/sidebar.php'; //path changed
    ?>
    <div class="container">
        <div class="my-calender">
            <div class="calender-container">
                <div class="cal-left">
                    <div class="calender-div">
                        <div class="cal-months">
                            <i class="fa fa-angle-left prev"></i>
                            <div class="cal-date">February 2024</div>
                            <i class="fa fa-angle-right next"></i>
                        </div>
                        <div class="cal-weekdays">
                            <div>sun</div>
                            <div>mon</div>
                            <div>tue</div>
                            <div>wed</div>
                            <div>thu</div>
                            <div>fri</div>
                            <div>sat</div>
                        </div>
                        <div class="cal-days">
                            <!-- <div class="cal-day prev-date">30</div>
                            <div class="cal-day prev-date">31</div>
                            <div class="cal-day">1</div>
                            <div class="cal-day">2</div>
                            <div class="cal-day">3</div>
                            <div class="cal-day">4</div>
                            <div class="cal-day">5</div>
                            <div class="cal-day">6</div>
                            <div class="cal-day">7</div>
                            <div class="cal-day">8</div>
                            <div class="cal-day">9</div>
                            <div class="cal-day active-date">10</div>
                            <div class="cal-day">11</div>
                            <div class="cal-day event">12</div>
                            <div class="cal-day">13</div>
                            <div class="cal-day">14</div>
                            <div class="cal-day today active-date event">15</div>
                            <div class="cal-day">16</div>
                            <div class="cal-day">17</div>
                            <div class="cal-day">18</div>
                            <div class="cal-day">19</div>
                            <div class="cal-day">20</div>
                            <div class="cal-day">21</div>
                            <div class="cal-day">22</div>
                            <div class="cal-day">23</div>
                            <div class="cal-day">24</div>
                            <div class="cal-day">25</div>
                            <div class="cal-day">26</div>
                            <div class="cal-day">27</div>
                            <div class="cal-day">28</div>
                            <div class="cal-day">29</div>
                            <div class="cal-day">30</div>
                            <div class="cal-day next-date">1</div>
                            <div class="cal-day next-date">2</div>
                            <div class="cal-day next-date">3</div> -->
                        </div>
                        <div class="goto-today">
                            <div class="goto">
                                <input type="text" placeholder="mm/yyyy" class="date-input">
                                <button class="goto-btn">go</button> 
                            </div>
                            <button class="today-btn">today</button>
                        </div>
                    </div>
                </div>
                <div class="cal-right">
                    <div class="today-date">
                        <div class="event-day">Wed</div>
                        <div class="event-date">16 November 2022</div>
                    </div>
                    <div class="events">
                        <!-- <div class="event">
                            <div class="title">
                                <i class="fas fa-circle"></i>
                                <h3 class="event-title">Event 1</h3>
                            </div>
                            <div class="event-time">10.00AM - 12:00PM</div>
                        </div>
                        <div class="event">
                            <div class="title">
                                <i class="fas fa-circle"></i>
                                <h3 class="event-title">Event 1</h3>
                            </div>
                            <div class="event-time">10.00AM - 12:00PM</div>
                        </div>
                        <div class="event">
                            <div class="title">
                                <i class="fas fa-circle"></i>
                                <h3 class="event-title">Event 1</h3>
                            </div>
                            <div class="event-time">10.00AM - 12:00PM</div>
                        </div>
                        <div class="event">
                            <div class="title">
                                <i class="fas fa-circle"></i>
                                <h3 class="event-title">Event 1</h3>
                            </div>
                            <div class="event-time">10.00AM - 12:00PM</div>
                        </div>
                        <div class="event">
                            <div class="title">
                                <i class="fas fa-circle"></i>
                                <h3 class="event-title">Event 1</h3>
                            </div>
                            <div class="event-time">10.00AM - 12:00PM</div>
                        </div>
                        <div class="event">
                            <div class="title">
                                <i class="fas fa-circle"></i>
                                <h3 class="event-title">Event 1</h3>
                            </div>
                            <div class="event-time">10.00AM - 12:00PM</div>
                        </div>
                        <div class="event">
                            <div class="title">
                                <i class="fas fa-circle"></i>
                                <h3 class="event-title">Event 1</h3>
                            </div>
                            <div class="event-time">10.00AM - 12:00PM</div>
                        </div>
                        <div class="event">
                            <div class="title">
                                <i class="fas fa-circle"></i>
                                <h3 class="event-title">Event 1Event 1Event 1Event 1</h3>
                            </div>
                            <div class="event-time">10.00AM - 12:00PM</div>
                        </div>
                        <div class="event">
                            <div class="title">
                                <i class="fas fa-circle"></i>
                                <h3 class="event-title">Event 1</h3>
                            </div>
                            <div class="event-time">10.00AM - 12:00PM</div>
                        </div>
                        <div class="event">
                            <div class="title">
                                <i class="fas fa-circle"></i>
                                <h3 class="event-title">Event 1</h3>
                            </div>
                            <div class="event-time">10.00AM - 12:00PM</div>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>

        <?php
            // Your PHP backend code to fetch data from the database or any other source
            // For demonstration purposes, let's assume you have fetched event data from the database
            $eventsFromBackend = [
                [
                    'day' => 13,
                    'month' => 2,
                    'year' => 2024,
                    'title' => 'Event 1',
                    'from' => '10:00 AM',
                    'to' => '10:00 PM'
                ],
                [
                    'day' => 15,
                    'month' => 2,
                    'year' => 2024,
                    'title' => 'Event 2',
                    'from' => '11:00 AM',
                    'to' => '12:00 PM'
                ],
                // Add more event data as needed
            ];
        ?>

        <?php
            require APPROOT . '/views/customer/footer.php'; //path changed
        ?>
    </div>

    <script>
        // Assign the PHP array to a JavaScript variable
        const eventsArr = <?php echo json_encode($eventsFromBackend); ?>;
        console.log(eventsArr); // Verify the data in the browser console
    </script>
    