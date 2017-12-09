<?php if(count($gallery) >= 1): ?>
<div class="carousel slide" id="carousel-example-generic" data-machine="<?= $gallery['machine_name'] ?>" data-ride="carousel">
    <ol class="carousel-indicators">
        <?php
        $i = 0;
        foreach(explode(';', $gallery['images']) as $image) {
            echo "<li data-target='#carousel-example-generic' data-slide-to='".$i."' class='".($i++ == 0 ? 'active' : '')."'></li>";
        }
        ?>
    </ol>
    <!-- Wrapper for slides -->
    <div class="carousel-inner" style="cursor: pointer;" title="<?= str_replace('"', "&quot;", $gallery['title']) ?>" role="listbox">
        <?php
        $i = 0;
        foreach(explode(';', $gallery['images']) as $image) {
            echo '<div class="item '.($i++ == 0 ? 'active' : '').'">
                <img src="'.$image.'" alt="">
            </div>';
        }
        ?>
    </div>
    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
        <span class="icon-prev" aria-hidden="true"></span>
        <span class="sr-only">הקודם</span>
    </a>
    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
        <span class="icon-next" aria-hidden="true"></span>
        <span class="sr-only">הבא</span>
    </a>
    <div class="clearfix"></div>
</div>
<?php endif; ?>