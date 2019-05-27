Loader.define(
    '/public/js/src/SearchConfig.js',
    ["jQuery"],
    function ($, undefined) {
        var SearchConfig = {
            textToSearch: '',
            cssClassToSearch: '',
            create: function () {
                 var searchConfig = Object.create(this);
                 
                 return searchConfig;
            },
            initSearchConfig : function(textToSearch, cssClassToSearch) {
                this.textToSearch = textToSearch;
                this.cssClassToSearch = cssClassToSearch;
            },
            
            getTextToSearch : function() {
                return this.textToSearch;
            },
            getCssClassToSearch : function() {
                return this.cssClassToSearch;
            }

            // return {
            //     create: create,
            //     getSearchText: getSearchText,
            //     getSearchCssObj: getSearchCssObj
            // }
        };
        
        console.log("loaded inner SearchConfig.js");
        
        return SearchConfig.create();
    }
);