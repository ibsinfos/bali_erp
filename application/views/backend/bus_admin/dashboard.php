<meta name="viewport" content="width=device-width, initial-scale=1">
<div class="android-header mdl-layout__header mdl-layout__header--waterfall">
    <div class="mdl-layout__header-row">
        <span class="android-title mdl-layout-title">
            <h3>Dashboard</h3>
        </span>

        <div class="android-header-spacer mdl-layout-spacer"></div>


        <div class="logout-btn"><a href="<?php echo base_url(); ?>index.php?login/logout">Logout</a></div>

    </div>
</div>
</div>
<div class="container_u display_site">
    <span class="menu-trigger">
        <i class="menu-trigger-bar top"></i>
        <i class="menu-trigger-bar middle"></i>
        <i class="menu-trigger-bar bottom"></i>
    </span>
    <span class="close-trigger">
        <i class="close-trigger-bar left"></i>
        <i class="close-trigger-bar right"></i>
    </span>

    <div class="inner-container">

        <!--<i class="menu-bg middle"></i>-->

        <div class="menu-container">
            <ul class="menu">
                <li class="<?php if ($page_name == 'dashboard') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?bus_admin/dashboard">
                        <i class="entypo-gauge"></i>
                        <span><?php echo get_phrase('dashboard'); ?></span>
                    </a>
                </li>
                
                <li class="<?php if ($page_name == 'bus_driver') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?bus_admin/bus_drivers">
                        <i class="entypo-gauge"></i>
                        <span><?php echo get_phrase('drivers'); ?></span>
                    </a>
                </li>
                
                <li class="<?php if ($page_name == 'driver_attendence') echo 'active'; ?> ">
                    <a href="<?php echo base_url(); ?>index.php?bus_admin/driver_attendence">
                        <i class="entypo-gauge"></i>
                        <span><?php echo get_phrase('driver attendence'); ?></span>
                    </a>
                </li>
                
                <li>
                    <a href="<?php echo base_url(); ?>index.php?login/logout">
                        <i class="entypo-gauge"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="dashboard display-animation container" style="margin: 0 auto;">
    <a class="tile tile-lg tile-pink ripple-effect tile-big" href="<?php echo base_url(); ?>index.php?bus_admin/bus_drivers">
        <span class="content-wrapper">
            <span class="tile-content">
                <span class="tile-img"><i class="fa fa-user"></i></span>
                <span class="tile-holder tile-holder-sm">
                    <span class="title"><?php echo get_phrase('drivers'); ?></span>
                </span>
            </span>      
        </span>
    </a>

    <a class="tile tile-lg tile-red ripple-effect tile-big" href="<?php echo base_url(); ?>index.php?bus_admin/driver_attendence">
        <span class="content-wrapper">
            <span class="tile-content">
                <span class="tile-img"><i class="fa fa-clock-o"></i></span>
                <span class="tile-holder tile-holder-sm">
                    <span class="title"><?php echo get_phrase('driver attendence'); ?></span>
                </span>
            </span>      
        </span>
    </a>

    <a class="tile tile-lg tile-amber ripple-effect tile-big" href="#">
        <span class="content-wrapper">
            <span class="tile-content">
                <span class="tile-img"><i class="fa fa-file-text-o"></i></span>
                <span class="tile-holder tile-holder-sm">
                    <span class="title"><?php echo get_phrase('uploads'); ?></span>
                </span>
            </span>      
        </span>
    </a>

    <a class="tile tile-lg tile-purple ripple-effect tile-big" href="#">
        <span class="content-wrapper">
            <span class="tile-content">
                <span class="tile-img"><i class="fa fa-key"></i></span>
                <span class="tile-holder tile-holder-sm">
                    <span class="title"><?php echo get_phrase('account'); ?></span>
                </span>
            </span>      
        </span>
    </a>

</div>

<script>
//OPEN TRIGGER
    var openTrigger = $('.menu-trigger');
    var openTriggerTop = openTrigger.find('.menu-trigger-bar.top');
    var openTriggerMiddle = openTrigger.find('.menu-trigger-bar.middle');
    var openTriggerBottom = openTrigger.find('.menu-trigger-bar.bottom');

//CLOSE TRIGGER
    var closeTrigger = $('.close-trigger');
    var closeTriggerLeft = closeTrigger.find('.close-trigger-bar.left');
    var closeTriggerRight = closeTrigger.find('.close-trigger-bar.right');

//LOGO
    var logo = $('.dashboard');

//MENU
    var menuContainer = $('.menu-container');
    var menu = $('.menu');
    var menuTop = $('.menu-bg.top');
    var menuMiddle = $('.menu-bg.middle');
    var menuBottom = $('.menu-bg.bottom');

//TL
    var tlOpen = new TimelineMax({paused: true});
    var tlClose = new TimelineMax({paused: true});

//OPEN TIMELINE
    tlOpen.add("preOpen")
            .to(logo, 0.4, {
                scale: 0.8,
                display: 'none',
                ease: Power2.easeOut
            }, "preOpen")
            .to(openTriggerTop, 0.4, {
                x: "+80px", y: "-80px", delay: 0.1, ease: Power4.easeIn, onComplete: function () {
                    closeTrigger.css('z-index', '60');
                }
            }, "preOpen")
            .to(openTriggerMiddle, 0.4, {
                x: "+=80px", y: "-=80px", ease: Power4.easeIn,
                onComplete: function () {
                    openTrigger.css('visibility', 'hidden');
                }
            }, "preOpen")
            .to(openTriggerBottom, 0.4, {
                x: "+=80px", y: "-=80px", delay: 0.2, ease: Power4.easeIn
            }, "preOpen")
            .add("open", "-=0.4")
            .to(menuTop, 0.8, {
                y: "13%",
                ease: Power4.easeInOut
            }, "open")
            .to(menuMiddle, 0.8, {
                scaleY: 1,
                ease: Power4.easeInOut
            }, "open")
            .to(menuBottom, 0.8, {
                y: "-114%",
                ease: Power4.easeInOut
            }, "open")
            .fromTo(menu, 0.6, {
                y: 30, opacity: 0, visibility: 'hidden'
            }, {
                y: 0, opacity: 1, visibility: 'visible', ease: Power4.easeOut
            }, "-=0.2")
            .add("preClose", "-=0.8")
            .to(closeTriggerLeft, 0.8, {
                x: "-=100px", y: "+=100px", ease: Power4.easeOut
            }, "preClose")
            .to(closeTriggerRight, 0.8, {
                x: "+=100px", y: "+=100px", delay: 0.2, ease: Power4.easeOut
            }, "preClose");

//CLOSE TIMELINE
    tlClose.add("close")
            .to(menuTop, 0.2, {
                backgroundColor: "#fff", ease: Power4.easeInOut, onComplete: function () {
                    logo.css('z-index', '26');
                    closeTrigger.css('z-index', '5');
                    openTrigger.css('visibility', 'visible');
                }
            }, "close")
            .to(menuMiddle, 0.2, {
                backgroundColor: "#fff", ease: Power4.easeInOut
            }, "close")
            .to(menuBottom, 0.2, {
                backgroundColor: "#fff", ease: Power4.easeInOut
            }, "close")
            .to(menu, 0.6, {
                y: 20, opacity: 0, ease: Power4.easeOut, onComplete: function () {
                    menu.css('visibility', 'hidden');
                }
            }, "close")
            .to(logo, 0.8, {
                scale: 1, display: 'block', ease: Power4.easeInOut
            }, "close", "+=0.2")
            .to(menuTop, 0.8, {
                y: "-113%",
                ease: Power4.easeInOut
            }, "close", "+=0.2")
            .to(menuMiddle, 0.8, {
                scaleY: 0,
                ease: Power4.easeInOut
            }, "close", "+=0.2")
            .to(menuBottom, 0.8, {
                y: "23%",
                ease: Power4.easeInOut,
                onComplete: function () {
                    menuTop.css('background-color', '#ffffff');
                    menuMiddle.css('background-color', '#ffffff');
                    menuBottom.css('background-color', '#ffffff');
                }
            }, "close", "+=0.2")
            .to(closeTriggerLeft, 0.2, {
                x: "+=100px", y: "-=100px", ease: Power4.easeIn
            }, "close")
            .to(closeTriggerRight, 0.2, {
                x: "-=100px", y: "-=100px", delay: 0.1, ease: Power4.easeIn
            }, "close")
            .to(openTriggerTop, 1, {
                x: "-=80px", y: "+=80px", delay: 0.2, ease: Power4.easeOut
            }, "close")
            .to(openTriggerMiddle, 1, {
                x: "-=80px", y: "+=80px", ease: Power4.easeOut
            }, "close")
            .to(openTriggerBottom, 1, {
                x: "-=80px", y: "+=80px", delay: 0.1, ease: Power4.easeOut
            }, "close");

//EVENTS
    openTrigger.on('click', function () {
        if (tlOpen.progress() < 1) {
            tlOpen.play();
        } else {
            tlOpen.restart();
        }
    });

    closeTrigger.on('click', function () {
        if (tlClose.progress() < 1) {
            tlClose.play();
        } else {
            tlClose.restart();
        }
    });
</script>