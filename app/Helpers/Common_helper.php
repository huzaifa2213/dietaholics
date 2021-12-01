<?php

if (!function_exists('getImagePath')) {
    function getImagePath($image, $folder)
    {

        if (!$image) {
            return base_url('public/uploads/' . $folder . '/dummy.png');
        } else {
            if (filter_var($image, FILTER_VALIDATE_URL)) {
                return $image;
            } else {
                if (file_exists(FCPATH . 'public/uploads/' . $folder . '/' . $image)) {

                    return base_url('public/uploads/' . $folder . '/' . $image);
                } else {

                    return base_url('public/uploads/' . $folder . '/dummy.png');
                }
            }
        }
    }
}
if (!function_exists('dateFormate')) {
    function dateFormate($date, $time = '')
    {

        if (isset($time) && $time != '') {
            $date_f = date('d-m-Y H:i:s', strtotime("$date $time"));
        } else {
            $date_f = date('d-m-Y H:i:s', strtotime($date));
        }
        return $date_f;
    }
}

if (!function_exists('timeFormat')) {
    function timeFormat($time)
    {

        if ($time) {
            return date("h:i a", strtotime($time));
        } else {
            return date("h:i a");
        }
    }
}
if (!function_exists('numbeFormat')) {
    function numbeFormat($number, $decimal_point = 2)
    {

        return  number_format($number, $decimal_point);
    }
}

if (!function_exists('discountType')) {
    function discountType($discount, $discount_type)
    {

        if ($discount_type == 0) {
            return CURRENCY . $discount;
        } else {
            return $discount . '%';
        }
    }
}

if (!function_exists('discountCalculation')) {
    function discountCalculation($price, $discount, $discount_type)
    {

        if ($discount_type == 0) {
            return $price - $discount;
        } else {
            return $price * (1 - $discount / 100);
        }
    }
}

if (!function_exists('getPaymentType')) {
    function getPaymentType($id)
    {
        if ($id == 1)
            return "COD";
        elseif ($id == 2)
            return "Stripe";
        elseif ($id == 3)
            return "Paypal";
        elseif ($id == 4)
            return "Razor Pay";
        elseif ($id == 5)
            return "Wallet";
         elseif ($id == 6)
        return "Cbk";
    }
}
if (!function_exists('getPaymentStatus')) {
    function getPaymentStatus($id)
    {
        if ($id == 0)
            return "<label class='label label-warning'>Pending</label>";
        elseif ($id == 1)
            return "<label class='label label-success'>Success</label>";
        elseif ($id == 0)
            return "<label class='label label-danger'>Failed</label>";
    }
}
if (!function_exists('getOrderStatus')) {
    function getOrderStatus($id)
    {
        if ($id == 1)
            return "<label class='label label-warning'>Received</label>";
        elseif ($id == 2)
            return "<label class='label label-success'>Accepted</label>";
        elseif ($id == 3)
            return "<label class='label label-danger'>Declined</label>";
        elseif ($id == 4)
            return "<label class='label label-warning'>Dispached</label>";
        elseif ($id == 5)
            return "<label class='label label-success'>Delivered</label>";
        elseif ($id == 6)
            return "<label class='label label-warning'>Picked Up</label>";
        elseif ($id == 9)
            return "<label class='label label-danger'>Cancelled</label>";
    }
}

if (!function_exists('getAddressType')) {
    function getAddressType($id)
    {
        if ($id == 0)
            return "Home";
        elseif ($id == 1)
            return "Office";
        elseif ($id == 2)
            return "Other";
    }
}
if (!function_exists('numberFormat')) {
    function numberFormat($price)
    {
        return number_format((float)$price, 2, '.', '');
    }
}

if (!function_exists('getDriverOrderStatus')) {
    function getDriverOrderStatus($id)
    {
        if ($id == 0)
            return "<label class='label label-warning'>Waiting for Approval</label>";
        elseif ($id == 1)
            return "<label class='label label-success'>Accepted</label>";
        elseif ($id == 2)
            return "<label class='label label-danger'>Declined</label>";
    }
}

