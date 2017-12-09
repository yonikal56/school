<?php

class Galleriesparser extends CI_Parser {

    const GALLERY_REPLACE_REGEXP = '!\{gallery.\s*(?<key>[^\}]+)\}!';
    public $CI = null;

    public function parse($template, $data, $return = FALSE) {
        $this->CI = get_instance();
        $template = $this->CI->load->view($template, $data, TRUE);
        $template = $this->replace_gallery_keys($template);

        return $this->_parse($template, $data, $return);
    }

    protected function replace_gallery_keys($template) {
        return preg_replace_callback(self::GALLERY_REPLACE_REGEXP, array($this, 'replace_gallery_key'), $template);
    }

    protected function replace_gallery_key($key) {
        $args = explode(', ', $key[1]);
        $key[1] = array_shift($args);
        return $this->CI->parser->parse('templates/gallery', ['gallery' => $this->CI->galleries->get_gallery($key[1])], TRUE);
    }
}