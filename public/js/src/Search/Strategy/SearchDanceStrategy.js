Loader.define(
    "/public/js/src/Search/Strategy/SearchDanceStrategy.js",
    [
        "jQuery",
        "/public/js/src/SearchConfig.js"
    ],
    function ($, SearchConfig, undefined) {
        var DanceStrategy = {
            searchConfig: {},
            searchOptionBehaviour: {},
            create : function() {
                var strategy = Object.create(this);
                
                return strategy;
            },
            
            initSearchDanceStrategy : function(SearchConfig, SearchOptionBehaviour) {
                this.searchConfig = SearchConfig;
                this.searchOptionBehaviour = SearchOptionBehaviour;
            },
            
            find : function() {
                var self = this;
                
                // find dance entries
                var $entries = $('#entries .entry').filter(function() {
                    return 'none' !== $(this).css('display')
                });
                var $entriesMatch = $entries.filter(function() {
                    var $entry = $(this);
                    var $danceTypes = $entry.find(self.searchConfig.getCssClassToSearch());
                    var search = self.searchConfig.getTextToSearch();
                    var $danceTypesMatch = $danceTypes.filter(function () {
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
                    if (undefined === self.searchOptionBehaviour) {
                        // early return
                        return search.length !== $danceTypesMatch.length
                    }
                    
                    // behaviour
                    var proof = true;
                    if (self.searchOptionBehaviour.atLeast) {
                        proof = 0 < $danceTypesMatch.length;
                    } else if (self.searchOptionBehaviour.exact) {
                        proof = search.length === $danceTypesMatch.length;
                    }
                    if (self.searchOptionBehaviour.invert) {
                        proof = !proof;
                    }
                    
                    return proof;
                });
                
                return $entriesMatch;
            }
        };
        
        console.log("loaded inner SearchDanceStrategy");
        
        return DanceStrategy.create();
    }
);