(function ($, Project, undefined) {
    $(document).ready( function () {
        // var project = window.Project;
        Project.run("global run");
        var hideEntries = false;
        $('#search > .search_button').bind('click', function () {
            $entries = $('#entries .entry');
            entriesToHide = [];
            var search = $('#search').find('.search_text').val();

            $entries.each(function () {
                var $danceType = $(this).find('.dance_type');
                var danceFound = false;
                $danceType.each(function () {
                    var text = $(this).text();
                    // console.log('text', text);
                    if (search === text) {
                        // console.log("found");
                        danceFound = true;
                        hideEntries = true;
                    }
                });
                if (!danceFound) {
                    // console.log('danceFound', danceFound);
                    entriesToHide.push($(this));
                }
                if (danceFound) {
                    console.log(entriesToHide);
                }
            });
            if (hideEntries) {
                for (var i in entriesToHide) {
                    $div = entriesToHide[i];
                    $div.toggle();
                }   
            }
        });
    });
}(jQuery, window.Project));