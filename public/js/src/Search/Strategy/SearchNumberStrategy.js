Loader.define(
    "/public/js/src/Search/Strategy/SearchNumberStrategy.js",
    [
        "jQuery",
        "/public/js/src/SearchConfig.js"
    ],
    function ($, SearchConfig, undefined) {
        var Strategy = {
            create: function () {
                 var searchNumberStrategy = Object.create(this);
                 
                 return searchNumberStrategy;
            },
            initSearchNumberStrategy : function(SearchConfig, SearchOptionBehaviour) {
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
                    var $number = $entry.find(self.searchConfig.getCssClassToSearch());
                    var search = self.searchConfig.getTextToSearch();
                    var $danceTypesMatch = $number.filter(function () {
                        var $numberEntry = $(this);
                        if (undefined === self.searchOptionBehaviour) {
                            // early return
                            return search !== $numberEntry.text();
                        }
                        
                        // with behaviour
                        var proof = search === $numberEntry.text();
                        if (self.searchOptionBehaviour.invert) {
                            proof = !proof;
                        }
                        
                        return proof;
                    });
                    return 0 < $danceTypesMatch.length;
                });
                
                return $entriesMatch;
            }
        };
        
        console.log("loaded inner SearchDanceStrategy");
        
        return Strategy.create();
    }
);