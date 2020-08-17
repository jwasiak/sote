<?php echo input_file_tag("review[user_picture]", ""); ?><br/>
<?php if ($review->getUserPicture()!=""): ?>
<img src="/uploads<?php echo $review->getUserPicture(); ?>" alt="" style="width: 60px; height: 60px; margin-top: 10px; margin-bottom: 10px; border-radius: 50%;" ><br/>
<?php echo link_to(__('Usuń zdjęcie'),'stReview/deleteImage?id='.$review->getId())?>                   
<br class="st_clear_all">
<?php endif; ?> 