<?php
include_once TEMPLATE_H_F_PATH . 'header.php';
?>

<!--PAGE CONTENT GO HERE-->
<div class="container rock-main-container" >

    <div class="col-md-12">
        <div class="col-md-3">
            <div class="list-group">
                <a href="#" class="list-group-item rock-home-side-list">
                    Categories
                </a>
                <?php
                foreach ($page_extra_data as $content) {



                    for ($i = 0; $i < count($content['categories']); $i++) {
                        /*
                         * Category name
                         */
                        $category_name = $content['categories'][$i]['category'];
                        ?>
                        <a href="#" class="list-group-item"><?= $category_name ?></a>
                        <?php
                    }
                }
                ?>
            </div> 
        </div>
        <!--Right side-->
        <div class="col-md-9">
            <?= $pagecontent ?>
            <div class="row">

                <hr/>
                <h1>Top New Arrivals</h1>
                <?php
                foreach ($page_extra_data as $content) {


//                            var_dump(count($content['random_data']));
                    foreach ($content['random_data'] as $brands) {
                        //var_dump($brands);
                        for ($j = 0; $j < count($brands); $j++) {
                            /*
                             * Brand name
                             */

                            $item_name = $brands[$j]['item_name'];
                            $item_image = $brands[$j]['item_image_url'];
                            $item_price = $brands[$j]['price'];
                            // var_dump(count($j));
                            ?>

                            <div class="col-md-4 rock-item-image-holder"> 
                                <div class="row">
                                   
                                        <a href="#" class="">
                                            <span class="rollover" ></span>
                                            <img src="<?= $item_image ?>">
                                        </a>
                                  
                                    
                                </div>
                               
                                <div class="row rock-item-captions">

                                    <p> <?= $item_name ?><p> 
                                    <p>  REG. PRCIE: $<?= $item_price ?></p>  

                                </div>
                            </div>


        


                            <?php
                        }
                    }
                }
                ?>

            </div>
        </div>




    </div>





    <?php
    include_once TEMPLATE_H_F_PATH . 'footer.php';
    ?>