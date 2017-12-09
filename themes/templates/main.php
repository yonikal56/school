<?php
$this->load->helper('date');
$is_connected = $this->users->if_connected();	

$defaults = [
    'title' => 'בית ספר עירוני מקיף ע"ש ש.י. עגנון',
    'description' => '',
    'keywords' => ''
];

$header_data = [
    'title' => isset($title) ? $title : $defaults['title'],
    'description' => isset($description) ? $description : $defaults['description'],
    'keywords' => isset($keywords) ? $keywords : $defaults['keywords'],
    'base' => base_url(),
    'heb-date' => get_jewish_date_section(),
    'time-date' => date('G:i')."&nbsp;&nbsp;&nbsp;&nbsp;".date('d.m.y'),
    'is_connected' => $is_connected,
    'connecting_minutes' => $this->settings->get_setting('user_connection_time')
];

$sidebar_data = [
    'sub_title' => isset($sub_title) ? $sub_title : '',
    'base' => base_url(),
    'notices' => $this->notices->get_notices(),
    'links' => $this->links->get_links(0)
];

$footer_data = [
    'base' => base_url(),
    'events' => $this->calender->get_calander_events()
];

$view = isset($view) ? $view : 'home';
$data = isset($data) ? $data : [];
$data['base'] = base_url();

$this->galleriesparser->parse('templates/header', $header_data);
$this->galleriesparser->parse('templates/sidebar', $sidebar_data);
$this->galleriesparser->parse($view, $data);
$this->galleriesparser->parse('templates/footer', $footer_data);