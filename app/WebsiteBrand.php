<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WebsiteBrand extends Model
{
	protected $table = 'website_brand';
    static public function CheckDataAndReturn()
    {
    	$webbrand = WebsiteBrand::find(1);
    	if (!isset($webbrand)) {
    		$webrand_new = new 	WebsiteBrand();
    		$webrand_new->title = "My Brand";
    		$webrand_new->brand_img_src = "brand_placeholder.jpg";
    		$webrand_new->save();
            $webbrand = WebsiteBrand::find(1);
    	}
        return $webbrand;
    }
}
