Loader.add(
    '/public/js/src/SearchCss.js',
    ["jQuery"],
    function ($, undefined) {
        var SearchCss = {
            // var cssClass = cssClassArg;
            create: function (cssClass) {
                var searchCss = Object.create(this);
                searchCss.cssClass = cssClass;

                return searchCss;
            },

            getCssClass: function () {
                return this.cssClass;
            }
        };

        console.log("loaded inner SearchCss.js");
        
        return SearchCss;
    }
);