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

                    foreach ($content['random_data'] as $brands) {

                        for ($j = 0; $j < count($brands); $j++) {
                            /*
                             * Brand name for caprtion
                             */

                            $item_name = trim($brands[$j]['item_name']);
                            $item_image = $brands[$j]['item_image_url'];
                            $item_price = $brands[$j]['price'];
                            /*
                             * Gender (if applicable)
                             */
                            if ($brands[$j]['gender'] != "") {
                                $clean_gender = str_replace(" ", "-", $brands[$j]['gender']);
                                $remove_ands_from_gender = str_replace("&", "and", $clean_gender);
                                $gender = '/' . preg_replace('/[^a-zA-Z0-9,-]/', '-', strtolower($remove_ands_from_gender));
                            } else {
                                continue;
                            }
                            /*
                             * Category
                             */
                            $clean_category = str_replace(" ", "-", $brands[$j]['category']);
                            $remove_ands_from_category = str_replace("&", "and", $clean_category);
                            $category = '/' . preg_replace('/[^a-zA-Z0-9,-]/', '-', strtolower($remove_ands_from_category));

                            /*
                             * Brand Name
                             */
                            $clean_brand_name = str_replace(" ", "-", $brands[$j]['brand']);
                            $remove_ands_from_brand = str_replace("&", "and", $clean_brand_name);
                            $brand_name = '/' . preg_replace('/[^a-zA-Z0-9,-]/', '-', strtolower($remove_ands_from_brand));
                            /*
                             * Model Number
                             */
                            $model_number = $brands[$j]['model_number'];
                            /*
                             * Item_name
                             */
                            $clear_url_spaces = str_replace(" ", "-", $brands[$j]['item_name']);
                            $remove_ands = str_replace("&", "and", $clear_url_spaces);
                            $clean_p_name =  preg_replace('/[^a-zA-Z0-9,-]/', '-', strtolower($remove_ands));

                            // var_dump(count($j));
                            ?>

                            <div class="col-md-4 rock-item-image-holder"> 
                                <div class="row">

                                    <a href="<?= $gender.$category.$brand_name."/".$model_number ?>#<?= $clean_p_name ?>" class="">
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