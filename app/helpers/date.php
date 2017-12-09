<?php
function get_jewish_date_section() {
    return get_week_day() . ", " . get_jewish_date();
}

function get_jewish_date($timestamp = null) {
    $timestamp = ($timestamp == null) ? time() : $timestamp;
    return iconv ('WINDOWS-1255', 'UTF-8', jdtojewish(unixtojd($timestamp), true, CAL_JEWISH_ADD_GERESHAYIM));;
}

function get_week_day($timestamp = null) {
    $timestamp = ($timestamp == null) ? time() : $timestamp;
    switch(date('w', $timestamp))
    {
        case 0:
            return 'יום ראשון';
        case 1:
            return 'יום שני';
        case 2:
            return 'יום שלישי';
        case 3:
            return 'יום רביעי';
        case 4:
            return 'יום חמישי';
        case 5:
            return 'יום שישי';
        case 6:
            return 'יום שבת';
    }
}