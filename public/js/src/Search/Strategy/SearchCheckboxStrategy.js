Loader.define(
    "/public/js/src/Search/Strategy/SearchCheckboxStrategy.js",
    [
        "jQuery"
    ],
    function ($, undefined) {
        var SearchCheckboxStrategy = {
            searchConfig: {},
            create : function() {
                return Object.create(this);
            },
            initSearchCheckboxStrategy : function(searchCheckBoxConfiguration, searchItemsExistingConfiguration) {
                this.searchCheckBoxConfiguration = searchCheckBoxConfiguration;
                this.searchItemsExistingConfiguration = searchItemsExistingConfiguration;
            },
            find : function() {
                var self = this;
                
                // find dance entries
                // var $entries = $('#entries .entry').filter(function() {
                //     return 'none' !== $(this).css('display')
                // });
                var $entries = this.searchItemsExistingConfiguration.getItems();
                var $entriesMatch = $entries.filter(function() {
                    var $entry = $(this);
                    // var $danceTypes = $entry.find(self.searchConfig.getSearchCssObj().getCssClass());
                    // var search = self.searchConfig.searchText;
                    var search = this.searchCheckBoxConfiguration.getItems();
                    var nestedSearchPerItem = self.searchItemsExistingConfiguration.getNestedSearchPerItem();
                    firstNestedSearch = Array.shift(nestedSearchPerItem);
                    var $nestedSearch = $entry.find(firstNestedSearch);
                    for (var i in nestedSearchPerItem) {
                        $nestedSearch = $.find(nestedSearchPerItem[i])
                    }
                    // var $danceTypesMatch = $danceTypes.filter(function () {
                    var $danceTypesMatch = $nestedSearch.filter(function () {
                        var danceFound = false;
                        var $danceEntry = $(this);

                        if (Array.isArray(search)) {
                            var matchedSearches = search.filter(function(el) {
                                return el === $danceEntry.text();  
                            });
                            danceFound = 0 < matchedSearches.length;
                        } 
                        // else {
                        //     var str = search + ': : ' + $danceEntry.text();
                        //     console.log('str', str);
                        //     if (search === $danceEntry.text()) {
                        //         console.log("her is ein found");
                        //         danceFound = true;
                        //     }
                        // }
                        console.log('danceFound', danceFound);

                        return danceFound;
                    });
                    console.log('$danceTypes.length', $danceTypesMatch.length);
                    return search.length !== $danceTypesMatch.length;
                });
                
                return $entriesMatch;
            }
        };
        
        console.log("loaded inner SearchDanceStrategy");
        
        return SearchCheckboxStrategy.create();
    }
);