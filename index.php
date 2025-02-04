<?php
session_start();
?>


<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Flight Booking System</title>
        <?php require 'utils/styles.php'; ?><!--css links. file found in utils folder-->
        <?php require 'utils/scripts.php'; ?><!--js links. file found in utils folder-->
    </head>
    <body>
        <?php include 'includes/header.php'; ?><!--header content. file found in utils folder-->

        <section class="banner">
            <div class="banner-content">
                <div class="section-title">
                    <h5>Seamless travel made easy</h5>
                    <p class="content">
                    Experience hassle-free flight booking with us. Discover the best deals, choose your preferred airlines, and embark on your next adventure with confidence. Whether it's a business trip or a dream vacation, your journey begins here.                    </p>
                    <a href="/pages/flights.php" class="primary-button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                fill="none" class="me-2">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M0 4.36364C0 4.26233 0.0207127 4.16585 0.0581382 4.07823L1.14083 1.37151C1.47217 0.543164 2.27444 0 3.1666 0H12.8334C13.7255 0 14.5279 0.543164 14.8592 1.37151L15.9419 4.07821C15.9793 4.16585 16 4.26232 16 4.36364V13.8182C16 15.0232 15.0232 16 13.8182 16H2.18182C0.976836 16 0 15.0232 0 13.8182V4.36364ZM14.1985 3.63636H1.80148L2.49134 1.91172C2.60178 1.6356 2.86921 1.45455 3.1666 1.45455H12.8334C13.1308 1.45455 13.3982 1.6356 13.5087 1.91172L14.1985 3.63636ZM1.45455 5.09091V13.8182C1.45455 14.2199 1.78016 14.5455 2.18182 14.5455H13.8182C14.2199 14.5455 14.5455 14.2199 14.5455 13.8182V5.09091H1.45455ZM8 6.54545C8.40167 6.54545 8.72727 6.87105 8.72727 7.27273V10.6079L9.66756 9.66756C9.95156 9.38356 10.4121 9.38356 10.6961 9.66756C10.9801 9.95156 10.9801 10.4121 10.6961 10.6961L8.51425 12.8779C8.23026 13.1619 7.76975 13.1619 7.48575 12.8779L5.30392 10.6961C5.01991 10.4121 5.01991 9.95156 5.30392 9.66756C5.58794 9.38356 6.04842 9.38356 6.33244 9.66756L7.27273 10.6079V7.27273C7.27273 6.87105 7.59833 6.54545 8 6.54545Z"
                                    fill="white" />
                        </svg>
                        Book Now
                    </a>
                </div>
                <div class="banner-image">
                    <figure>
                        <img src="/assets/flight_banner.png" alt="banner">
                    </figure>
                </div>
            </div>
        </section>

        <h1>Find the best flight rates</h1>

            <?php include 'includes/cards.php'; ?><!--flights cards content. file found in utils folder-->

        <?php include 'includes/footer.php'; ?><!--footer content. file found in utils folder-->
    </body>
</html>
