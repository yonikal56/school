<?php
function get_page_galleries($template) {
    return preg_replace_callback('/\[gallery.\s*(?<key>[^\]]+)\]/', function ($matches) {
        $args = explode(', ', $matches[1]);
        $matches[1] = array_shift($args);
        return '{gallery.'.$matches[1].'}';
    }, $template);
}