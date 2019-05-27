Loader.define(
    '/public/js/src/CheckboxSearch.js',
    '/public/js/src/Search/Strategy/SearchCheckboxStrategy.js',
    ["jQuery"],
    function ($, SearchCheckBoxStrategy, undefined) {
        var CheckboxSearch = {
            searchCheckBoxStrategy: {},
            searchCheckBoxConfiguration: {},
            searchItemsExistingConfiguration: {},
            create: function () {
                var checkboxSearch = Object.create(this);
                checkboxSearch.searchCheckBoxStrategy = SearchCheckBoxStrategy;
                
                return checkboxSearch;
            },
            initCheckboxSearch : function(searchCheckBoxConfiguration, searchItemsExistingConfiguration) {
                this.searchCheckBoxConfiguration = searchCheckBoxConfiguration;
                this.searchItemsExistingConfiguration = searchItemsExistingConfiguration;
            },
            // getSearchCheckBoxConfiguration : function() {
            //     return this.searchCheckBoxConfiguration;
            // },
            // getSearchItemsExistingConfiguration : function() {
            //     return this.searchItemsExistingConfiguration;
            // }
            searchItems: function() {
                return this.searchCheckBoxStrategy.find();
            }
        };
        
        console.log("loaded inner CheckboxSearch.js");
        
        return CheckboxSearch.create();
    }
);