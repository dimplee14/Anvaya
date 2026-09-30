<?php
include 'db.php';?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>header</title>

    <!-- css -->
    <link rel="stylesheet" href="../css/header.css">

    <!-- media css -->

    <link rel="stylesheet" href="../css/media/header.css">
</head>

<body>
    <!-- header start -->
    <header class="header">



        <!-- nav start -->

        <div class="navbar">
            <div class="nav">
                <nav class="left-nav"></nav>
                <div class="logo-container">
                    <a href="home.php"><img class="logo" src="../assets/img/logo.png" alt="logo"></a>
                </div>
                <nav class="right-nav">
                    <div class="right-nav-item">

                        <ul>
                            <li><a class="right-nav-link" href="design.php">Design Studio</a></li>
                            <li><a class="right-nav-link" href="portfolio.php">Portfolio</a></li>
                            <li><a class="right-nav-link" href="process.php">Our Process</a></li>
                            <li><a class="right-nav-link" href="story.php">Our Story</a></li>
                        </ul>
                        <ul>
                            <li>
                                <div class="saperation"></div>
                            </li>
                            <li><a href="login.php"><svg class="right-nav-svg" xmlns="http://www.w3.org/2000/svg"
                                        width="30" height="30" viewBox="0 0 30 30" fill="none">
                                        <path
                                            d="M15 4C11.975 4 9.5 7.08 9.5 10.875C9.5 14.67 11.975 17.75 15 17.75C18.025 17.75 20.5 14.67 20.5 10.875C20.5 7.08 18.025 4 15 4ZM9.2525 17.75C6.3375 17.8875 4 20.28 4 23.25V26H26V23.25C26 20.28 23.69 17.8875 20.7475 17.75C19.2625 19.4275 17.2275 20.5 15 20.5C12.7725 20.5 10.7375 19.4275 9.2525 17.75Z"
                                            fill="#333333" />
                                    </svg></a></li>
                            <li>
                                <a href="basket.php">
                                    <svg class="right-nav-svg" xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                        viewBox="0 0 30 30" fill="none">
                                        <path
                                            d="M25.9941 24.4648L24.281 10.9651C24.1974 9.72882 23.2328 8.77127 22.0705 8.77127H20.1425V7.99788C20.1425 6.66906 19.6119 5.41812 18.649 4.47576C17.6764 3.52408 16.3807 3 14.9997 3C12.1645 3 9.85755 5.24229 9.85755 7.99788V8.77127H7.92896C6.7672 8.77127 5.80264 9.72882 5.71904 10.9651L4.00588 24.4648C3.91317 25.8343 4.92918 27 6.21579 27H23.7837C25.0708 27 26.0868 25.8343 25.9941 24.4648ZM10.9293 7.99788C10.9293 5.78204 12.755 3.97959 14.9997 3.97959C16.0806 3.97959 17.0982 4.39298 17.8656 5.14433C18.6426 5.90449 19.0707 6.91837 19.0707 7.99788V8.77127H10.9293V7.99788ZM10.3934 12.1523C9.82218 12.1523 9.35919 11.7291 9.35919 11.207C9.35919 10.6849 9.82218 10.2617 10.3934 10.2617C10.9647 10.2617 11.4276 10.6849 11.4276 11.207C11.4277 11.7291 10.9647 12.1523 10.3934 12.1523ZM19.6066 12.1528C19.0354 12.1528 18.5724 11.7291 18.5724 11.207C18.5724 10.6859 19.0337 10.2632 19.6039 10.2617H19.6093C20.1794 10.2632 20.6408 10.6859 20.6408 11.207C20.6408 11.7291 20.1779 12.1528 19.6066 12.1528Z"
                                            fill="#333333" />
                                    </svg>
                                </a>
                            </li>
                </nav>
            </div>


            <div class="ham">

                <li class="ham-btn">
                    <button class="hamburger">
                        <svg class="menu-icon" xmlns="http://www.w3.org/2000/svg" width="27" height="19"
                            viewBox="0 0 27 19" fill="none">
                            <path
                                d="M2.25 3.83333H24.75C25.0815 3.83333 25.3995 3.68408 25.6339 3.4184C25.8683 3.15272 26 2.79239 26 2.41667C26 2.04094 25.8683 1.68061 25.6339 1.41493C25.3995 1.14926 25.0815 1 24.75 1H2.25C1.91848 1 1.60054 1.14926 1.36612 1.41493C1.1317 1.68061 1 2.04094 1 2.41667C1 2.79239 1.1317 3.15272 1.36612 3.4184C1.60054 3.68408 1.91848 3.83333 2.25 3.83333ZM24.75 15.1667H2.25C1.91848 15.1667 1.60054 15.3159 1.36612 15.5816C1.1317 15.8473 1 16.2076 1 16.5833C1 16.9591 1.1317 17.3194 1.36612 17.5851C1.60054 17.8507 1.91848 18 2.25 18H24.75C25.0815 18 25.3995 17.8507 25.6339 17.5851C25.8683 17.3194 26 16.9591 26 16.5833C26 16.2076 25.8683 15.8473 25.6339 15.5816C25.3995 15.3159 25.0815 15.1667 24.75 15.1667ZM24.75 8.08333H2.25C1.91848 8.08333 1.60054 8.23259 1.36612 8.49827C1.1317 8.76394 1 9.12428 1 9.5C1 9.87572 1.1317 10.2361 1.36612 10.5017C1.60054 10.7674 1.91848 10.9167 2.25 10.9167H24.75C25.0815 10.9167 25.3995 10.7674 25.6339 10.5017C25.8683 10.2361 26 9.87572 26 9.5C26 9.12428 25.8683 8.76394 25.6339 8.49827C25.3995 8.23259 25.0815 8.08333 24.75 8.08333Z"
                                fill="black" stroke="white" stroke-width="1.5" />
                        </svg>
                        <svg class="close-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none">
                            <path
                                d="M13.225 12L18.7375 6.4875C19.0875 6.1375 19.0875 5.6125 18.7375 5.2625C18.3875 4.9125 17.8625 4.9125 17.5125 5.2625L12 10.775L6.4875 5.2625C6.1375 4.9125 5.6125 4.9125 5.2625 5.2625C4.9125 5.6125 4.9125 6.1375 5.2625 6.4875L10.775 12L5.2625 17.5125C5.0875 17.6875 5 17.8625 5 18.125C5 18.65 5.35 19 5.875 19C6.1375 19 6.3125 18.9125 6.4875 18.7375L12 13.225L17.5125 18.7375C17.6875 18.9125 17.8625 19 18.125 19C18.3875 19 18.5625 18.9125 18.7375 18.7375C19.0875 18.3875 19.0875 17.8625 18.7375 17.5125L13.225 12Z"
                                fill="black" />
                        </svg>
                    </button>
                </li>
            </div>


            </nav>

        </div>
        <!-- nav end -->
        <!-- bg img slider -->
        <div class="nav-bg-slider">
            <div class="nav-bg-list">
                <div class="nav-bg-item">
                    <img src="../assets/img/1.1.jpg" alt="1">
                </div>
                <div class="nav-bg-item">
                    <img src="../assets/img/1.2.jpg" alt="2">
                </div>
                <div class="nav-bg-item">
                    <img src="../assets/img/1.3.jpg" alt="3">
                </div>
            </div>
            <!-- <div class="nav-bg-dots">
                <ul>
                    <li></li>
                    <li></li>
                    <li></li>
                </ul>
            </div> -->
        </div>
        <!-- <div class="container">
            <div class="slider-wraper">
                <div class="slider">
                    <img src="../assets/img/1.1.png" alt="" id="slide-1">
                    <img src="../assets/img/1.2.jpg" alt="" id="slide-2">
                    <img src="../assets/img/1.png" alt="" id="slide-3">
                </div>
                <div class="slider-nav">
                    <a href="#slide-1"></a>
                    <a href="#slide-2"></a>
                    <a href="#slide-3"></a>
                </div>
            </div>
            
        </div> -->
        <!-- bg img slider end -->


        <div class="sidebar">
            <div class="sidebar-content">
                <div class="sidebar-header">
                    <div><img class="sidebar-logo" src="../assets/img/logo 2.png" alt=""></div>
                    <div class="sidebar-shop">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                            <path
                                d="M25.9941 24.4648L24.281 10.9651C24.1974 9.72882 23.2328 8.77127 22.0705 8.77127H20.1425V7.99788C20.1425 6.66906 19.6119 5.41812 18.649 4.47576C17.6764 3.52408 16.3807 3 14.9997 3C12.1645 3 9.85755 5.24229 9.85755 7.99788V8.77127H7.92896C6.7672 8.77127 5.80264 9.72882 5.71904 10.9651L4.00588 24.4648C3.91317 25.8343 4.92918 27 6.21579 27H23.7837C25.0708 27 26.0868 25.8343 25.9941 24.4648ZM10.9293 7.99788C10.9293 5.78204 12.755 3.97959 14.9997 3.97959C16.0806 3.97959 17.0982 4.39298 17.8656 5.14433C18.6426 5.90449 19.0707 6.91837 19.0707 7.99788V8.77127H10.9293V7.99788ZM10.3934 12.1523C9.82218 12.1523 9.35919 11.7291 9.35919 11.207C9.35919 10.6849 9.82218 10.2617 10.3934 10.2617C10.9647 10.2617 11.4276 10.6849 11.4276 11.207C11.4277 11.7291 10.9647 12.1523 10.3934 12.1523ZM19.6066 12.1528C19.0354 12.1528 18.5724 11.7291 18.5724 11.207C18.5724 10.6859 19.0337 10.2632 19.6039 10.2617H19.6093C20.1794 10.2632 20.6408 10.6859 20.6408 11.207C20.6408 11.7291 20.1779 12.1528 19.6066 12.1528Z"
                                fill="#333333"></path>
                            <circle cx="23" cy="24" r="5.75" fill="#D9D9D9" stroke="#FA0608" stroke-width="0.5">
                            </circle>
                            <path
                                d="M21.27 27V26.29H22.93V20.66H23.37L21.43 21.87V21.04L23.16 19.95H23.76V26.29H25.32V27H21.27Z"
                                fill="#FA0608"></path>
                        </svg>
                    </div>
                </div>
                <div class="sidebar-main">

                    <ul>
                        <li><a class="sidebar-nav-link" href="design.php">Design Studio</a></li>
                        <li><a class="sidebar-nav-link" href="portfolio.php">Portfolio</a></li>
                        <li><a class="sidebar-nav-link" href="process.php">Our Process</a></li>
                        <li><a class="sidebar-nav-link" href="story.php">Our Story</a></li>
                    </ul>
                </div>

                <div class="sidebar-login-btn">
                    <button class="login-btn">Log In</button>
                </div>

            </div>
        </div>

        <div class="hero-section">


            <div class="hero-text">
                Be Your <span>Own Designer</span>
            </div>
            <a href="design.php" class="start-btn">
                <button class="start">Start Now</button>
            </a>
        </div>
        <div class="dots">
            <div class="nav-bg-dots">
                <ul>
                    <li></li>
                    <li></li>
                    <li></li>
                </ul>
            </div>
        </div>
    </header>

    <!-- header end -->







    <script src="../js/header.js"></script>
</body>

</html>