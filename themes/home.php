<?php //$this->parser->parse('templates/gallery', ['gallery' => $this->galleries->get_gallery("index")]); ?>
<?php //$this->parser->parse('templates/categories', ['categories' => $this->categories->get_categories()]); ?>
<?= $this->parser->parse('templates/page', ['full_page' => false, 'page' => $this->pages->get_page_by_machine_name('index')], true); ?>