<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<div class="row rock-footer-div">
    <!-- Mens-->
    <div class="col-md-3">
        <h3>Top Designers</h3>
        <ul>
             <?php
        
        foreach ($footer_data as $footer_designers){
            $top_ten_designers = $footer_designers['name'];
        
            
            ?>
            <li><a href=""><?= $top_ten_designers ?></a></li>
            <?php
            
        }
        
        
        ?>
            
        </ul>

    </div>
    <!-- womens-->
    <div class="col-md-3">

    </div>
    <!--Boys-->
    <div class="col-md-3">

    </div>
    <!--Boys-->
    <div class="col-md-3">

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
<center>Your Website Name All Rights Reserved &reg; Powered By <a href="/rock.admin">GrowaRock</a></center>
</body>
</html>