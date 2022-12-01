<?php
use Carbon\Carbon;
use Illuminate\Support\Arr;
if(!function_exists('settings')){
    function settings($key)
    {
        static $settings;

        if(is_null($settings))
        {
            $settings = Cache::remember('settings', 30*24*60, function() {
                return Arr::pluck(App\Models\Settings::all()->toArray(), 'value', 'setting_key');
            });
        }

        return (is_array($key)) ? array_only($settings, $key) : $settings[$key];
    }
}
if(!function_exists('cities')){
    function cities()
    {
        static $cities;

        if(is_null($cities))
        {
            $cities = Cache::remember('cities', 30*24*60, function() {
                $categories = new App\Models\Categories();
                $categories::setCategoryType($categories::IS_ZONE);
                return $categories::lists(config('env.LANGUAGE_DEFAULT'),0,['parent_id' => 0])->toArray();
            });
        }

        return $cities;
    }
}
if(!function_exists('districts')){
    function districts($city)
    {
        static $districts;

        if(is_null($districts))
        {
            $districts = Cache::remember('districts_'.$city, 30*24*60, function() use($city) {
                $categories = new App\Models\Categories();
                $categories::setCategoryType($categories::IS_ZONE);
                return $categories::lists(config('env.LANGUAGE_DEFAULT'),0,['parent_id' => $city])->toArray();
            });
        }

        return $districts;
    }
}
if(!function_exists('wards')){
    function wards($district)
    {
        static $wards;

        if(is_null($wards))
        {
            $wards = Cache::remember('wards_'.$district, 30*24*60, function() use($district) {
                $categories = new App\Models\Categories();
                $categories::setCategoryType($categories::IS_ZONE);
                return $categories::lists(config('env.LANGUAGE_DEFAULT'),0,['parent_id' => $district])->toArray();
            });
        }

        return $wards;
    }
}
if(!function_exists('listStaticHtml')){
    function listStaticHtml()
    {
        static $list_static_html;

        if(is_null($list_static_html))
        {
            $list_static_html = Cache::remember('static_html', 30*24*60, function() {
                return App\Models\StaticHtml::lists(config('env.LANGUAGE_DEFAULT'))->toArray();
            });
        }

        return $list_static_html;
    }
}
if (!function_exists('parseDateFormat')) {
    function parseDateFormat($date, $full = false) {
        Carbon::setLocale('vi');
        $date_format_text = "";
        if(!empty($date)){
            $date_format = Carbon::parse($date);
            if($date_format != null){
                if($full === true){
                    $date_format_text = $date_format->format(config('env.DATE_FULL_FORMAT_DISPLAY'));
                }
                else if ($date_format->diffInDays() <= 7) {
                    $date_format_text = $date_format->diffForHumans();
                } else {
                    $date_format_text = $date_format->format(config('env.DATE_FORMAT_DISPLAY'));
                }
            }
        }
        return $date_format_text;
    }
}
if(!function_exists('convertToMysqlDate')){
    function convertToMysqlDate($date){
        return preg_replace("/(\d{2})\/(\d{2})\/(\d{4})/", "$3-$2-$1", $date); 
    }
}
if(!function_exists('convertMysqlDate')){
    function convertMysqlDate($date){
        return preg_replace("/(\d{4})-(\d{2})-(\d{2})/", "$3/$2/$1", $date); 
    }
}
if(!function_exists('parseStar')){
    function parseStar($rate){
        $star = [];
        $rate = floatval($rate);
        $rate_int = intval($rate);
        $is_float = false;
        if($rate_int != $rate){
            $rate_int = intval($rate - 0.5);
            $is_float = true;
        }
        $rate_end = 0;
        for($i = 1; $i <= $rate_int; $i++){
            $star[] = '<li><i class="fas fa-star text-warning"></i></li>';
            $rate_end = $i;
        }
        if($is_float === true){
            $star[] = '<li><i class="fas fa-star-half-alt text-warning"></i></li>';
            $rate_end++;
        } 
        if($rate_end < 5){
            for($i = $rate_end; $i < 5; $i++){
                $star[] = '<li><i class="far fa-star text-warning"></i></li>';
            }
        }
        //die();
        return implode("",$star);
    }
}
if(!function_exists('frontEndPaginator')){
    function frontEndPaginator($paginator){
    
    }
}
if(!function_exists('bindHeaderInfo')){
    function bindHeaderInfo($info)
    {
        return [
            "meta_title" => $info['meta_title'],
            "canonical_url" => (isset($info['canonical_url']) && !empty($info['canonical_url']))?$info['canonical_url']:url()->current(),
            "page_title" => $info['page_title'],
            "meta_description" => $info['meta_description'],
            "meta_keyword" => $info['meta_keyword'],
            "meta_image" => !empty($info['meta_image'])?config('app.url').$info['meta_image']:'',
        ];
    }
}
if(!function_exists('parseKeyword')){
    function parseKeyword($text, $remove_keyword = [])
    {
        if(!is_array($remove_keyword)){
            $remove_keyword = [];
        }
        static $keyword_search;

        if(is_null($keyword_search))
        {
            $keyword_search = Cache::remember('keyword_search', 30*24*60, function() {
                $result = App\Models\KeywordSearch::whereRaw("type = 2 AND LENGTH(keyword) > 3 AND keyword<>'' AND direct_link<>'' AND active=1 AND deleted=0")->orderByRaw('LENGTH(keyword)', 'DESC')->get()->toArray();
                $return = [];
                foreach($result as $item){
                    $return[$item['keyword']] = [
                        "direct_link" => $item['direct_link'],
                        "keyword_id" => $item['keyword_id'],
                    ];
                }
                return $return;
            });
        }
        if (!(is_array($keyword_search) && count($keyword_search))){
            return [
                "content" => trim($text)
            ];
        }
        $text_array = array();
        $links_array = array();
        $keyword_id_array = array();
        foreach ($keyword_search as $keyword => $keyword_info)
        {
            if (empty($keyword)){
                continue;
            }
            $text_array[] = $keyword;
            $links_array[] = $keyword_info['direct_link'];
            $keyword_id_array[] = $keyword_info['keyword_id'];
        }
        $search = array();
        $replace = array();
        $keyword_assigned = array();
        if (strlen($text)>300)
        {
            $list_anchor = array();
            $text = stripslashes($text);
            $text = str_replace(" />",">",$text);
            $text = str_replace("/>",">",$text);
            $dom = new \IvoPetkov\HTML5DOMDocument();
            $dom->loadHTML($text);

            $i = $j = 1;
            foreach($dom->getElementsByTagName('a') as $tag_key => $tag_a) {
                $tag_a_temp = $tag_a->outerHTML;
                $tag_a_temp = str_replace(" />",">",$tag_a_temp);
                $tag_a_temp = str_replace("/>",">",$tag_a_temp);
                $list_anchor[$i] = $str_replace_html = $tag_a_temp;
                $text = str_replace($str_replace_html,"[TAG-A-".$i."]",$text);
                $i++;
            }
            $list_image = array();
            foreach($dom->getElementsByTagName('img') as $tag_key => $tag_img) {
                $tag_img_temp = $tag_img->outerHTML;
                $tag_img_temp = str_replace(" />",">",$tag_img_temp);
                $tag_img_temp = str_replace("/>",">",$tag_img_temp);
                $list_image[$j] = $str_replace_html = $tag_img_temp;
                $text = str_replace($str_replace_html,"[TAG-IMG-".$j."]",$text);

                $j++;
            }
            $text = html_entity_decode($text, ENT_COMPAT, 'UTF-8');
            foreach($text_array as $k => $v) {
                if(count($keyword_assigned) >= 10) break;
                if (preg_match("/\s" . $v . "\s/i", $text) && in_array($v, $remove_keyword) === false) {
                    $text = preg_replace("/(\s" . $v . "\s)/i", "<a href=\"" . $links_array[$k] . "\" class=\"link-black\">$0</a>", $text, 1);
                    $remove_keyword[] = $v;
                    $keyword_assigned[] = $keyword_id_array[$k];
                }
                if(in_array($v, $remove_keyword) === false){ // check text đầu dòng
                    if (preg_match("/[^a-zA-Z]" . $v . "/i", $text)) {
                        $text = preg_replace("/(" . $v . ")/i", "<a href=\"" . $links_array[$k] . "\" class=\"link-black\">$0</a>", $text, 1);
                        $remove_keyword[] = $v;
                        $keyword_assigned[] = $keyword_id_array[$k];
                    }
                }

                $dom_2 = new \IvoPetkov\HTML5DOMDocument();
                $dom_2->loadHTML($text);

                foreach($dom_2->getElementsByTagName('a') as $tag_key => $tag_a) {
                    $list_anchor[$i] = $str_replace_html = $tag_a->outerHTML;
                    $text = str_replace($str_replace_html,"[TAG-A-".$i."]",$text);
                    $i++;
                }
            }
            if (is_array($list_anchor)){
                foreach($list_anchor as $key => $anchor_item){
                    $text = str_replace("[TAG-A-".$key."]",$anchor_item,$text);
                }
            }
            if (is_array($list_image)){
                foreach($list_image as $key => $img_item){
                    $text = str_replace("[TAG-IMG-".$key."]",$img_item,$text);
                }
            }
        }
        if (function_exists("str_get_html"))
        {
            $dom_3 = new \IvoPetkov\HTML5DOMDocument();
            $dom_3->loadHTML($text);

            foreach($dom_3->getElementsByTagName('a') as $tag_key => $tag_a) {
                $text = str_replace($tag_a->innerHTML,strip_tags($tag_a->innerHTML,'<img><br><br/><p>'),$text);
            }
        }
        return [
            "content" => trim($text),
            "keyword_id" => $keyword_assigned
        ];
    }
}

if(!function_exists('parseFormatNumber')){
    function parseFormatNumber($number)
    {
        if ($number)
            return number_format($number, 0,'.',',');
        else return '0';
    }
}

if(!function_exists('detectMobilePhoneNumber')){
    function detectMobilePhoneNumber($phone){
        preg_match_all('!\d+!', $phone, $matches);
        $phone = implode("",$matches[0]);
        if(strlen($phone) == 10 || strlen($phone) == 11)
            return $phone;
        else return '';
    }
}

if(!function_exists('convertDateTimeToMysql')){
    function convertDateTimeToMysql($date)
    {
        if ($date != '')
        {
            $date = preg_replace('/(\d{2})\/(\d{2})\/(\d{4})\s(.*)/i', "$3-$2-$1 $4", $date);
            return $date;
        } else return '';
    }
}

if(!function_exists('getCoordinates')){
    function getCoordinates($city, $street, $province)
    {
        $address = urlencode($city.','.$street.','.$province);
        $url = "https://maps.google.com/maps/api/geocode/json?key=".config('env.GOOGLE_MAP_API_KEY')."&address=$address&sensor=false&region=Vietnam";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response);
        $status = $response_a->status;

        if ( $status == 'ZERO_RESULTS' )
        {
            return FALSE;
        }
        else
        {
            $return = array('lat' => $response_a->results[0]->geometry->location->lat, 'long' => $long = $response_a->results[0]->geometry->location->lng);
            return $return;
        }
    }
    function getDrivingDistance($lat1, $lat2, $long1, $long2)
    {
        $url = "https://maps.googleapis.com/maps/api/distancematrix/json?key=".config('env.GOOGLE_MAP_API_KEY')."&origins=".$lat1.",".$long1."&destinations=".$lat2.",".$long2."&mode=driving&language=vi-VN";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
        $response_a = json_decode($response, true);
        $dist = $response_a['rows'][0]['elements'][0]['distance']['text'];
        $time = $response_a['rows'][0]['elements'][0]['duration']['text'];

        return array('distance' => $dist, 'time' => $time);
    }
}