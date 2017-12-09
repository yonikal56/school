<aside class="rsidebar col-md-2 pull-right">
    <div class="panel panel-default">
        <div class="panel-heading">
          עוד באתר
        </div>
        <div class="panel-body">
            <?= $this->parser->parse('templates/menu', ['type' => 'side'], true); ?>
        </div>
    </div>
    <?= $this->parser->parse('templates/page', ['full_page' => false, 'page' => $this->pages->get_page_by_machine_name('right_side')], true); ?>
</aside>
<?php if($this->uri->segment(1) == "home" || strlen($this->uri->segment(1)) == 0): ?>
<aside class="lsidebar col-md-3 pull-left">
    <?= $this->parser->parse('templates/notices', ['notices' => $notices], true); ?>
    <?= $this->parser->parse('templates/links', ['links' => $links], true); ?>
</aside>
<section class="page-content col-md-7 center-block">
    <?php if($sub_title != ""): ?>
    <fieldset>
        <legend>{sub_title}</legend>
    </fieldset>
    <?php endif; ?>
<?php else: ?>
<section class="page-content col-md-10 center-block pull-right">
    <?php if($sub_title != ""): ?>
    <fieldset>
        <legend>{sub_title}</legend>
    </fieldset>
    <?php endif; ?>
<?php endif; ?>