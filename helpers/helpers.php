<?php
/**
 * Created by PhpStorm.
 * User: felipeneuhauss
 * Date: 29/10/15
 * Time: 09:57
 */

if (! function_exists('num_random')) {
    /**
     * Generate a more truly "random" numeric string.
     *
     * @param  int $length
     * @return string
     *
     * @throws \RuntimeException
     */
    function num_random($length = 16)
    {
        $result = '';

        for ($i = 0; $i < $length; $i++) {
            $result .= mt_rand(0, 9);
        }

        return $result;
    }
}

if ( !function_exists( 'dateHourMinuteBR' ) ) {
    function dateHourMinuteBR( $date )
    {
        return \Carbon\Carbon::parse( $date )->format( 'Y-m-d H:m:s' );
    }

}
if ( !function_exists( 'dateBR' ) ) {
    function dateBR( $date )
    {
        return \Carbon\Carbon::parse( $date )->format( 'd/m/Y H:m:s' );
    }

}

function generate_rating_stars($field_name, $quantity = 5, $required = false, $value = 0) {
    $value = round($value);
    $html = "";
    $html .= "<fieldset class='rating'>";
        for ($i = $quantity; $i >= 1; $i--) {
            $html .= "<input type='radio' id='star".$i.$field_name."' name='".$field_name."' value='".$i."' ".($value == $i ? 'checked' : '' )." /><label class='full' for='star".$i.$field_name."' title='".$i." estrelas'></label>";
            $html .= "<input type='radio' id='star".$i.$field_name."half' name='".$field_name."' value='".($i-1).".5' ".($value == (($i-1).".5") ? 'checked' : '' )." /><label class='half' for='star".$i.$field_name."half' title='".($i-1).".5 estrelas'></label>";
        }
    $html .= "</fieldset>";

    return $html;
}

function generate_stars($quantity = 5, $value = 0, $rating_quantity = '0', $showEvaluates = true, $divClass = 'stars-color') {
    $value = round((float) $value, 0);
    $html = "<div class='$divClass'>";

    for ($i = (int)$value; $i > 0; $i--) {
        $html .="<i class='icon-star3'> </i>";
    }
    for ($i = ($quantity-$value) ; $i >= 1; $i--) {
        $html .="<i class='icon-star-empty'></i>";
    }
    if ($showEvaluates) {
        if ($rating_quantity == 0) {
            $html .= "";
        }
        if ($rating_quantity == 1) {
            $html .= " 1 Avaliação" ;
        }
        if ($rating_quantity > 1) {
            $html .= " " . $rating_quantity . " Avaliações";
        }
    }
    return $html .= "</div>";
}

/**
 * Return the numbers from string
 * @param $str
 * @return mixed
 */
function get_numerics ($str) {
    preg_match_all('/\d+/', $str, $matches);
    return $matches[0][0];
}

/**
 * @param $date
 * @return string
 */
function convert_date_to_db($date = "") {
    $newDate = array();
    if ($date != "" && strpos($date, '-') === false) {
        $newDate = explode('/', $date);
        $date = $newDate[2].'-'.$newDate[1].'-'.$newDate[0];
    }
    return $date;
}

/**
 * @param $date
 * @return string
 */
function humanize_date($date = "", $withTime = false) {
    if (strpos($date,'/') === false) {
        $newDate = array();
        if ($date != "") {
            $newDate = explode(' ', $date);
            $time = (isset($newDate[1])) ? : '';
            $newDate = explode('-', $newDate[0]);
            $date = $newDate[2].'/'.$newDate[1].'/'.$newDate[0];
            if ($withTime) {
                $date .= ' '.$time;
            }
        }
    }
    return $date;
}

/**
 * @param $date
 * @return string
 */
function day_of_date($date = "") {
    $newDate = array();
    if ($date != "") {
        $newDate = explode(' ', $date);
        $newDate = explode('-', $newDate[0]);
        return $newDate[2];
    }
    return $date;
}

/**
 * @param $date
 * @return string
 */
function month_of_date($date = "", $desc = false) {
    $newDate = array();
    $months = [1 => 'Jan', 2 => 'Fev', 3 => 'Mar', 4 => 'Abr', 5 => 'Mai',
        6 => 'Jun', 7 => 'Jul', 8 => 'Ago', 9 => 'Set', 10 => 'Out', 11 => 'Nov', 12 => 'Dez'];
    if ($date != "") {
        $newDate = explode(' ', $date);
        $newDate = explode('-', $newDate[0]);
        return !$desc ? $newDate[1] : $months[(int)$newDate[1]];
    }
    return $date;
}

function diff_dates($dateInit, $dateEnd) {
    $date1 = date_create($dateInit);
    $date2 = date_create($dateEnd);
    $diff = date_diff($date1, $date2);

    return $diff;
}

function humanize_payment_status($transaction_status_code) {
    return \App\Repositories\Eloquent\PaymentRepository::$status[$transaction_status_code];
}

function currency($value, $symbol = 'R$') {
    return $symbol .' '. number_format($value, 2, ',', '.');
}

function percent($value, $symbol = '%') {
    return $symbol .' '. number_format($value, 2, ',', '.');
}


function implode_collection_by_field($collection, $field) {
    return implode(',', $collection->get()->pluck($field)->all());
}