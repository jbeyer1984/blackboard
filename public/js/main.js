Loader.define(
    '/public/js/main.js',
    [
        "jQuery",
        "/public/js/src/Search.js"
    ],
    function ($, Search, undefined) {
        var $topDiv = $('.form_wrapper');
        $topDiv.hide();
        var $checkboxes = $('#search').find('input:checkbox');
        $checkboxes.each(function(key, value) {
            if (1 === key) {
                var $checkbox = $(this);
                $checkbox.prop('checked', 'true');
            }
        });
        var search = Search.create();
        
        var $searchButton = $('#search').find('input:button.search_button:first');
        $searchButton.trigger('click');
        console.log("loaded inner main.js");
        
        console.log('counter', Loader.tryCounter);
        console.log('Loader.classStack', Loader.classStack);
        return search;
    }
);