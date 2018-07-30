Loader.add(
    '/public/js/src/SearchConfig.js',
    ["jQuery"],
    function ($, undefined) {
        var SearchConfig = {
            create: function (searchTextArg, SearchCssObj) {
                var searchConfiguration = Object.create(this);

                searchConfiguration.searchText = searchTextArg;
                searchConfiguration.searchCssObj = SearchCssObj;

                return searchConfiguration;
            },

            getSearchText: function () {
                return this.searchText;
            },

            getSearchCss: function () {
                return this.searchCssObj;
            }

            // return {
            //     create: create,
            //     getSearchText: getSearchText,
            //     getSearchCss: getSearchCss
            // }
        };
        
        console.log("loaded inner SearchConfig.js");
        
        return SearchConfig;
    }
);