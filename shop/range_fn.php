<?php
    // Date range related function
    // Thank you StackOverflow
    function rangeWeek ($datestr) {
        date_default_timezone_set(date_default_timezone_get());
        $dt = strtotime ($datestr);
        return array (
            "start" => date ('N', $dt) == 1 ? date ('Y-m-d', $dt) : date ('Y-m-d', strtotime ('last monday', $dt)),
            "end" => date('N', $dt) == 7 ? date ('Y-m-d', $dt) : date ('Y-m-d', strtotime ('next sunday', $dt))
        );
    }
    function rangeMonth ($datestr) {
        date_default_timezone_set (date_default_timezone_get());
        $dt = strtotime ($datestr);
        return array (
            "start" => date ('Y-m-d', strtotime ('first day of this month', $dt)),
            "end" => date ('Y-m-d', strtotime ('last day of this month', $dt))
        );
    }
?>