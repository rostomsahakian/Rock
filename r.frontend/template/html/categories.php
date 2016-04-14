<?php
include_once TEMPLATE_H_F_PATH . 'header.php';
?>

<!--PAGE CONTENT GO HERE-->
<div class="container rock-main-container">
    <?php
    foreach ($pagecontent as $content) {

        
        ?>
    
    <?php
        for ($i = 0; $i < count($content['categories']); $i++) {
            /*
             * Category name
             */
            $category_name =  $content['categories'][$i]['category'];
             echo $category_name."<br/>";
        }
        
        
        
        
        /*
         * Brand ID
         */
        for ($i = 0; $i < count($content['brand_ids']); $i++) {

            $brand_id = $content['brand_ids'][$i]['brand_id'];
        }
        
        
        
        /*
         * Brand name
         */
        foreach ($content['brands'] as $brands) {
            
            for ($j = 0; $j < count($brands); $j++) {
                /*
                 * Brand name
                 */
                $barnd_name =  $brands[$j]['brand']."<br/>";
                echo $barnd_name;
            }

 
        }
       
    }
    ?>
</div>





<?php
include_once TEMPLATE_H_F_PATH . 'footer.php';
?>