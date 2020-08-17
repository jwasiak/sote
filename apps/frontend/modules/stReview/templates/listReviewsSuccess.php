<?php
st_theme_use_stylesheet('stReview.css');

$results=array();

if(isset($pin_reviews)){

foreach ($pin_reviews as $review)
{
    if ($review->getActive()==1 && $review->getAgreement()==1 || $review->getActive()==1 && $review->getUserIp()== $user_ip)
    {
        $row['show_review']=$review->getActive()==1 && $review->getAgreement()==1;

        if ($review->getSfGuardUserId()<>0)
        {
            $row['is_user']=$review->getSfGuardUserId()<>0;
            $row['author']=$review->getUsername();
        }
        else
        {
            if ($review->getAdminName())
            {
                $row['is_admin']=$review->getAdminName();
                $row['author']=$review->getAdminName();
            }
            else
            {
                $row['author']=$review->getUsername();
            }
        }
        $row['score']=$review->getScore();
        $row['created_at']=$review->getCreatedAt('d-m-Y');
        $row['description']=$review->getDescription();
        
        $row['user_picture']=$review->getUserPicture();
        $row['user_facebook']=$review->getUserFacebook();
        $row['user_instagram']=$review->getUserInstagram();
        $row['user_youtube']=$review->getUserYoutube();
        $row['user_twitter']=$review->getUserTwitter();
        $row['user_review_verified']=$review->getUserReviewVerified();

        $short = explode(" ", $row['author']);
        
        $first =  $short[0];
        $secund = $short[1];
        
        $name = $first[0].$secund[0]; 
        
        $row['user_shortname']=$name;
        
        if($review->getUserIp()== $user_ip)
        {
           $row['user_ip']=true;
        }
        else
        {
           $row['user_ip']=false;
        }

        $row['language']=$review->getLanguage();
        $row['agreement']=$review->getAgreement();


        $results[]=$row;
        
    }
}

}

if(isset($reviews)){

foreach ($reviews as $review)
{
    if ($review->getActive()==1 && $review->getAgreement()==1 || $review->getActive()==1 && $review->getUserIp()== $user_ip)
    {
        $row['show_review']=$review->getActive()==1 && $review->getAgreement()==1;

        if ($review->getSfGuardUserId()<>0)
        {
            $row['is_user']=$review->getSfGuardUserId()<>0;
            $row['author']=$review->getUsername();
        }
        else
        {
            if ($review->getAdminName())
            {
                $row['is_admin']=$review->getAdminName();
                $row['author']=$review->getAdminName();
            }
            else
            {
                $row['author']=$review->getUsername();
            }
        }
        $row['score']=$review->getScore();
        $row['created_at']=$review->getCreatedAt('d-m-Y');
        $row['description']=$review->getDescription();
        
        $row['user_picture']=$review->getUserPicture();
        $row['user_facebook']=$review->getUserFacebook();
        $row['user_instagram']=$review->getUserInstagram();
        $row['user_youtube']=$review->getUserYoutube();
        $row['user_twitter']=$review->getUserTwitter();
        $row['user_review_verified']=$review->getUserReviewVerified();

        $short = explode(" ", $row['author']);
        
        $first =  $short[0];
        $secund = $short[1];
        
        $name = $first[0].$secund[0]; 
        
        $row['user_shortname']=$name;
        
        if($review->getUserIp()== $user_ip)
        {
           $row['user_ip']=true;
        }
        else
        {
           $row['user_ip']=false;
        }

        $row['language']=$review->getLanguage();
        $row['agreement']=$review->getAgreement();


        $results[]=$row;
        
    }
}

}

if(isset($pin_reviews) || isset($reviews)){

$smarty->assign('results',$results);
    
}


$smarty->assign('culture',$culture);

$smarty->display('review_list_reviews.html');
?>