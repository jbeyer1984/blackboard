Loader.define(
    '/public/js/src/Search/Strategy/SearchDispatcher.js',
    [
        "jQuery",
        '/public/js/src/Search/Configuration/SearchCheckBoxConfiguration.js',
        '/public/js/src/Search/Configuration/SearchItemsExistingConfiguration.js',
        '/public/js/src/Search/Strategy/SearchCheckboxStrategy.js',
        '/public/js/src/Search/Strategy/SearchDanceStrategy.js',
        '/public/js/src/Search/Strategy/SearchNumberStrategy.js'
    ],
    function ($, SearchCheckBoxConfiguration, SearchItemsExistingConfiguration, SearchCheckboxStrategy, SearchDanceStrategy,
              SearchNumberStrategy, undefined)
    {
        var SearchDispatcher = {
            searchCheckBoxConfiguration: {},
            searchItemsExistingConfiguration: {},
            strategy: {},
            create: function () {
                 var searchDispatcher = Object.create(this);
                searchDispatcher.searchCheckBoxConfiguration = SearchCheckBoxConfiguration;
                searchDispatcher.searchItemsExistingConfiguration = SearchItemsExistingConfiguration;
                searchDispatcher.searchDanceStrategy = SearchDanceStrategy;
                searchDispatcher.searchNumberStrategy = SearchNumberStrategy;
                
                return searchDispatcher;
            },
            dispatch: function(searchIdentifier, searchConfig) {
            // dispatch: function(searchIdentifier, $wrapper) {
                var strategy = {};
                switch (searchIdentifier) {
                    case 'search_dance':
                        var searchOptionBehaviour = {
                            atLeast: false,
                            exact: true,
                            invert: true
                        };
                        this.searchDanceStrategy.initSearchDanceStrategy(searchConfig, searchOptionBehaviour);
                        strategy = this.searchDanceStrategy;
                        break;
                    case 'search_number':
                        // strategy = SearchNumberStrategy.create(searchConfig);
                        var searchOptionBehaviour = {
                            invert: true
                        };
                        this.searchNumberStrategy.initSearchNumberStrategy(searchConfig, searchOptionBehaviour);
                        strategy = this.searchNumberStrategy;
                        break;
                    default:
                        console.error("no strategy exists");
                }
                // this.strategy = strategy;

                // return this.strategy;
                return strategy;
            }
        };

        console.log("loaded inner SearchConfig.js");

        return SearchDispatcher.create();
    }
);
