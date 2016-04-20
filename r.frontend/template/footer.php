<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
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
        <div class="rock-footer-all-rights"
             <center>Your Website Name All Rights Reserved &reg; Powered By <a href="/rock.admin">GrowaRock</a></center>
        </div>
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

</body>
</html>