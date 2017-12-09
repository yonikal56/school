$(function(){ 
	//jQuery code here 
    if(is_connected == 1) {
        setTimeout(function() {
            alert ("נותנת מהמערכת לאחר " + connecting_minutes + " דקות של חוסר פעילות.");
            document.location.href = base + "admin/logout";
        },1000*60*connecting_minutes);
    }
    
    $(".carousel-inner").on("click", function() {
        document.location.href = base + "gallery/" + $(this).parent().attr('data-machine');
    });
    
    $('.carousel').carousel({
        interval: 5000
    });
    
    $(".choose-table-form select").on("change", function() {
        document.location.href = base + "admin/archive/1/"+$(this).val();
    });
    
    $(".open_from_to, .from_to_desc").on("click", function() {
        $(".from_to_desc[data-id='" + $(this).attr('data-id') + "']").fadeToggle("fast");
    });
    
    $(document).on("click", ".remove_gallery_image", function(e) {
        e.preventDefault();
        $(this).parentsUntil('.gallery_image_div').parent().remove();
    });
    
    $(document).on("click", ".add_gallery_image", function(e) {
        e.preventDefault();
        $(this).parentsUntil('.gallery_image_div').parent().after('<div class="gallery_image_div">\
            <input type="text" name="images[]" id="images" class="images_input form-control">\
            <span>\
                <button class="btn btn-danger remove_gallery_image">x</button>\
                <button class="btn btn-success add_gallery_image">+</button>\
            </span>\
            <div class="clearfix"></div>\
        </div>');
    });
    
    $(document).on('change', ':file', function() {
        var input = $(this),
            numFiles = input.get(0).files ? input.get(0).files.length : 1,
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
    });
    
    $('.files_input').on('fileselect', function(event, numFiles, label) {
          var input = $(this).parents('.input-group').find(':text'),
              log = numFiles > 1 ? numFiles + ' קבצים נבחרו' : label;

          if( input.length ) {
              input.val(log);
          } else {
              if( log ) alert(log);
          }
    });
    
    /*$(".dropdown-menu").hover(function() {
        $(this).parent('li').css('border-color', "#eee #eee #ddd");
    });*/
    
    $('.dropdown, .dropdown-menu').hover(function(){
		$(this).find('.dropdown-menu:first').show();
		$(this).css({
			'background' : '#eee #eee #ddd'
		});
	}, function(){
		$(this).find('.dropdown-menu:first').hide();
		$(this).css({
			'background' : ''
		});
	});
});