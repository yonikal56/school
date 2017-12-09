            </section>
        <!-- End Of Main Content -->
        </main>
        <!-- Main Menu Bar -->
        <footer class="navbar navbar-fixed-bottom footerMenu">
			בית ספר ש.י עגנון , רח' שפינוזה , רמת הרצל , נתניה. טלפון: 09-8844999, פקס: 09-8847733, דוא"ל: <a href="mailto:agnon_school@walla.com">agnon_school@walla.com</a>
        </footer>
    </body>
    <!-- Javascript Files -->
    <script type="text/javascript">
        var base = "{base}";
    </script>
    <script type="text/javascript" src="{base}themes/js/jquery-2.2.2.min.js"></script>
    <script src='{base}themes/js/fullcalendar/lib/moment.min.js'></script>
    <script src='{base}themes/js/fullcalendar/fullcalendar.js'></script>
    <script src='{base}themes/js/fullcalendar/locale/he.js'></script>
    <script>
    $(document).ready(function() {
        if($( "#calendar" ).length ) {
            $('#calendar').fullCalendar({
                events: [
                    {events}
                ]
            });
        }   
    });
    </script>
    <script type="text/javascript" src="{base}themes/js/bootstrap.min.js"></script>
    <script src="{base}themes/js/tinymce/js/tinymce/tinymce.min.js"></script>
    <script>
    tinymce.init({
        selector: 'textarea[name="content"]',
        menubar: false,
        plugins: [
        'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        'searchreplace wordcount visualblocks visualchars code fullscreen',
        'insertdatetime media nonbreaking table contextmenu directionality',
        'paste textcolor colorpicker textpattern imagetools codesample toc'
      ],
      bbcode_dialect: "punbb",
      toolbar: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image \
      print preview media | forecolor backcolor emoticons | codesample | fullscreen code addpassage addgallery',
        setup: function (editor) {
          editor.addButton('addpassage', {
            text: 'הוסף קטע',
            icon: false,
            onclick: function () {
              editor.insertContent('<div class="panel panel-default"><div class="panel-heading">כותרת</div><div class="panel-body">תוכן</div></div>&nbsp;');
            }
          });
          editor.addButton('addgallery', {
            text: 'הוסף גלריה',
            icon: false,
            onclick: function () {
                editor.windowManager.open({
                title: 'הוספת גלריה',
                body: [
                  {type: 'textbox', name: 'machine_name', label: 'כתובת URL של גלריה'}
                ],
                onsubmit: function(e) {
                  var name = e.data.machine_name;
                  editor.insertContent('[gallery.' + name + ']');
                }
              });
            }
          });
        },
        content_css: [
          '//www.tinymce.com/css/codepen.min.css',
          '{base}themes/css/main.css'
        ],
        language: 'he_IL',
        directionality : 'rtl',
        height: 250
    });
    </script>
    <script type="text/javascript" src="{base}themes/js/script.js"></script>
</html>