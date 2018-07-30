Loader.add(
    '/public/js/main.js',
    [
        "jQuery",
        "/public/js/src/Search.js"
    ],
    function ($, Search, undefined) {
        var search = Search.create();
        
        console.log("loaded inner main.js");
        return search;

    }
    , jQuery, window.Search
);