<?php
include_once TEMPLATE_H_F_PATH . 'header.php';
?>

<!--PAGE CONTENT GO HERE-->
<div class="container rock-main-container">
    <?php
    foreach ($pagecontent as $content) {

        
        
        for ($i = 0; $i < count($content['categories']); $i++) {
            /*
             * Category name
             */
            $category_name =  $content['categories'][$i]['category'];
        }
        for ($i = 0; $i < count($content['brand_ids']); $i++) {

            $brand_id = $content['brand_ids'][$i]['brand_id'];
        }

        foreach ($content['brands'] as $brands) {
            //var_dump($brands);
            for ($j = 0; $j < count($brands); $j++) {
                /*
                 * Brand name
                 */
                $barnd_name =  $brands[$j]['brand'];
            }

 
        }
    }
    ?>
</div>





<?php
include_once TEMPLATE_H_F_PATH . 'footer.php';
?>