<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div class="rock-top-footer">
    <div class="container ">
        <div class="row">
            <div class="col-md-4">

                <div class="rock-social-media-footer">
                    <?php
                    $social_media = $PAGEDATA->SetSocialMedia();
                    $social_media = $PAGEDATA->getSocialMedia();
                    if ($social_media != NULL) {
                        foreach ($social_media as $sm) {
                            ?> 
                            <a href="<?= $sm['url'] ?>" alt="Social Media Icons" title="<?= $sm['image_name'] ?>" target="_blank"><img src="<?= $sm['image_url'] . "/" . $sm['image_name'] ?>" alt="" height="30" width="30"/></a>

                            <?php
                        }
                    }
                    ?>

                </div>
            </div>

            <div class="col-md-4 rock-top-footer-newsletter">

                <h4><i class="fa fa-envelope-o" aria-hidden="true"></i>&nbsp;&nbsp;Sign Up For Our NewsLetter</h4>
            </div>

            <div class="col-md-4 rock-top-footer-newsletter-form">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Your email address">
                    <span class="input-group-btn">
                        <button class="btn btn-default rock-input-button" type="button">SIGN UP</button>
                    </span>
                </div><!-- /input-group -->
            </div>
        </div> 
    </div>

</div>
<div class="footer-main-wrapper">


    <div class="container">
        <div class="row rock-footer-div">
            <!-- Mens-->
            <div class="col-md-3">
                <h4>Top Mens Designers</h4>

                <?php
                foreach ($footer_data as $footer_designers) {
                    ?>
                    <ul>
                        <?php
                        foreach ($footer_designers['m'] as $mens_t_d) {
                            foreach ($mens_t_d as $mens_links) {

                                for ($i = 0; $i < count($mens_links); $i++) {

                                    $mens_with_no_space = str_replace(" ", "-", strtolower($mens_links[$i]['brand']));
                                    $mens_with_no_ands = str_replace("&", "and", $mens_with_no_space);
                                    $clean_mens_link = preg_replace('/[^a-zA-Z0-9,-]/', "-", $mens_with_no_ands);
                                    $mens = $mens_links[$i]['brand'];
                                    ?>
                                    <li><a href="/<?= $clean_mens_link ?>"><?= $mens ?></a></li>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </ul>

                </div>
                <!-- womens-->
                <div class="col-md-3">
                    <h4>Top Womens Designers</h4>
                    <ul>
                        <?php
                        foreach ($footer_designers['w'] as $womens_t_d) {
                            foreach ($womens_t_d as $womens_links) {

                                for ($i = 0; $i < count($womens_links); $i++) {
                                    $womens_with_no_space = str_replace(" ", "-", strtolower($womens_links[$i]['brand']));
                                    $womens_with_no_ands = str_replace("&", "and", $womens_with_no_space);
                                    $clean_womens_link = preg_replace('/[^a-zA-Z0-9,-]/', "-", $womens_with_no_ands);
                                    $womens = $womens_links[$i]['brand'];
                                    ?>
                                    <li><a href="/<?= $clean_womens_link ?>"><?= $womens ?></a></li>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </ul>

                </div>
                <!--Boys-->
                <div class="col-md-3">
                    <h4>Top Boys Designers</h4>
                    <ul>
                        <?php
                        foreach ($footer_designers['b'] as $boys_t_d) {
                            foreach ($boys_t_d as $boys_links) {

                                for ($i = 0; $i < count($boys_links); $i++) {
                                    $boys_with_no_space = str_replace(" ", "-", strtolower($boys_links[$i]['brand']));
                                    $boys_with_no_ands = str_replace("&", "and", $boys_with_no_space);
                                    $clean_boys_link = preg_replace('/[^a-zA-Z0-9,-]/', "-", $boys_with_no_ands);
                                    $boys = $boys_links[$i]['brand'];
                                    ?>
                                    <li><a href="/<?= $clean_boys_link ?>"><?= $boys ?></a></li>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </ul>

                </div>
                <!--Boys-->
                <div class="col-md-3">
                    <h4>Top Girls Designers</h4>
                    <ul>
                        <?php
                        foreach ($footer_designers['g'] as $girls_t_d) {
                            foreach ($girls_t_d as $girls_links) {

                                for ($i = 0; $i < count($girls_links); $i++) {
                                    $girls_with_no_space = str_replace(" ", "-", strtolower($girls_links[$i]['brand']));
                                    $girls_with_no_ands = str_replace("&", "and", $girls_with_no_space);
                                    $clean_girls_link = preg_replace('/[^a-zA-Z0-9,-]/', "-", $girls_with_no_ands);
                                    $girls = $girls_links[$i]['brand'];
                                    ?>
                                    <li><a href="/<?= $clean_girls_link ?>"><?= $girls ?></a></li>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </ul>

                </div>
                <?php
            }
            ?>
        </div>

    </div>
</div>
<div class="rock-bottom-footer-div">
    <div class="container">
        <div class="row rock-bottom-row">

            <div class="col-md-3">
                <h4>GrowaRock</h4>
                <ul>

                    <li><a href="">Home</a></li>
                    <li><a href="">About us</a></li>
                    <li><a href="">Our History</a></li>
                    <li><a href="">Our Staff</a></li>
                    <li><a href="">Our Company</a></li>
                    <li><a href="">Contact Us</a></li>


                </ul>
            </div>
            <div class="col-md-3">
                <h4>Policies</h4>
                <ul>
                    <li><a href="">Shipping Policies</a></li>
                    <li><a href="">Privacy Policies</a></li>
                    <li><a href="">Return Policies</a></li>
                    <li><a href="">Terms of Use</a></li>
                    <li><a href="">FAQ'S</a></li>
                </ul>
            </div>
            <div class="col-md-3 rock-contact-us-footer">
                <h4>Contact Us</h4>
                <ul>
                    <li><i class="fa fa-home" aria-hidden="true"></i>&nbsp;17941 Ventura Blvd #208,Encino CA 91316 US </li>
                    <li><i class="fa fa-mobile" aria-hidden="true"></i>&nbsp;Telephone:(818) 538-4494 </li>
                    <li><i class="fa fa-envelope" aria-hidden="true"></i>&nbsp; E-mail: support@growarock.com</li>
                </ul>
            </div>
            <div class="col-md-3">
                <h4>Payment options</h4>
                <ul class="rock-payment-options">
                    <li><a href="#"><img src="/r.frontend/images/payment-visa.png"/></a></li>
                    <li><a href="#"><img src="/r.frontend/images/payment-paypal.png"/></a></li>
                    <li><a href="#"><img src="/r.frontend/images/payment-mastercard.png"/></a></li>
                    <li><a href="#"><img src="/r.frontend/images/payment-ae.png"/></a></li>
                    <li><a href="#"><img src="/r.frontend/images/payment-discover.png"/></a></li>
                </ul>
            </div>

        </div>
    </div>
    <div class="rock-footer-all-rights"
         <center>Your Website Name All Rights Reserved &reg; Powered By <a href="/rock.admin">GrowaRock</a></center>
    </div>

</div>
<script>


    $(document).ready(function () {

        var time = 7; // time in seconds

        var $progressBar,
                $bar,
                $elem,
                isPause,
                tick,
                percentTime;

//Init the carousel
        $("#owl-demo").owlCarousel({
            slideSpeed: 500,
            paginationSpeed: 500,
            singleItem: true,
            afterInit: progressBar,
            afterMove: moved,
            startDragging: pauseOnDragging
        });

//Init progressBar where elem is $("#owl-demo")
        function progressBar(elem) {
            $elem = elem;
//build progress bar elements
            buildProgressBar();
//start counting
            start();
        }

//create div#progressBar and div#bar then prepend to $("#owl-demo")
        function buildProgressBar() {
            $progressBar = $("<div>", {
                id: "progressBar"
            });
            $bar = $("<div>", {
                id: "bar"
            });
            $progressBar.append($bar).prependTo($elem);
        }

        function start() {
//reset timer
            percentTime = 0;
            isPause = false;
//run interval every 0.01 second
            tick = setInterval(interval, 10);
        }
        ;

        function interval() {
            if (isPause === false) {
                percentTime += 1 / time;
                $bar.css({
                    width: percentTime + "%"
                });
//if percentTime is equal or greater than 100
                if (percentTime >= 100) {
                    //slide to next item 
                    $elem.trigger('owl.next')
                }
            }
        }

//pause while dragging 
        function pauseOnDragging() {
            isPause = true;
        }

//moved callback
        function moved() {
//clear interval
            clearTimeout(tick);
//start again
            start();
        }

//uncomment this to make pause on mouseover 
// $elem.on('mouseover',function(){
//   isPause = true;
// })
// $elem.on('mouseout',function(){
//   isPause = false;
// })

    });


</script>

<script src="/rock.assets/js/bootstrap.min.js"></script>

<!-- Bootstrap Dropdown Hover JS -->
<script src="/r.frontend/js/bootstrap-dropdownhover.min.js"></script>
</body>
</html>