Loader.define(
    '/public/js/src/Search.js',
    [
        "jQuery",
        "/public/js/src/SearchConfig.js",
        "/public/js/src/Search/Strategy/SearchDispatcher.js",
        "/public/js/src/EntriesHidden.js"
    ],
    function ($, SearchConfig, SearchDispatcher, EntriesHidden, undefined) {
        console.log("Search loaded");
        var Search = {
            create : function() {
                var search = Object.create(this);
                search.searchConfig = SearchConfig.create();
                search.entriesHidden = EntriesHidden.create();
                search.searchDispatcher = SearchDispatcher.create();

                search.init();

                return search;
            },

            init: function() {
                var self = this;
                $('#search > .search_type > .search_button').bind('click', function () {
                    // var $entries = $('#entries .entry');
                    var $clickedButton = $(this);
                    
                    var $hiddenInput = $clickedButton.prev();
                    var searchType = $hiddenInput.val();

                    var searchConfig = {};
                    
                    // var multiSearch = false;
                    
                    switch (searchType) {
                        case 'search_dance':
                            // multiSearch = true;
                            searchConfig = self.createDanceSearchConfiguration(
                                $clickedButton
                            );
                            break;
                        case 'search_number':
                            searchConfig = self.createNumberSearchConfiguration(
                                $clickedButton
                            );
                            break;
                        default:
                            console.error("search '"+searchType+"'strategy is not implemented");
                    }

                    var searchStrategy = self.searchDispatcher.dispatch(searchType, searchConfig);
                    var $entriesToHide = searchStrategy.find();
                    self.entriesHidden.mergeEntriesToHide($entriesToHide);
                    // self.addEntriesToHide($entries, self.entriesHidden, searchConfiguration);
                    self.hideEntries();
                });
                $('#search > .reset_button').bind('click', function () {
                    self.showEntries();
                    self.entriesHidden.emptyEntriesToHide();
                });
            },

            createDanceSearchConfiguration: function ($clickedButton) {
                var textToSearch = $clickedButton.parents('.search_type').find('input:checkbox').filter(function (key, el) {
                    var $el = $(el);
                    return $el.prop('checked');
                }).map(function (key, el) {
                    var $el = $(el);
                    return $el.val();
                }).toArray();
                var cssClassToSearch = '.dance_type';
                this.searchConfig.initSearchConfig(textToSearch, cssClassToSearch);
                return this.searchConfig;
            },

            createNumberSearchConfiguration: function ($clickedButton, searchConfiguration) {
                var $searchField = $clickedButton.parents('.search_type').find('.search_text');
                var textToSearch = $searchField.val();
                var cssClassToSearch = '#person .number_type';
                this.searchConfig.initSearchConfig(textToSearch, cssClassToSearch);
                return this.searchConfig;
            },

            // addEntriesToHide: function($entries, entriesObj, searchConfigurationObj) {
            //     var hideEntries;
            //     $entries.each(function () {
            //         var $entriesMatch = entriesObj.entriesToHide;
            //        
            //         entriesObj.addEntriesToHide($(this));
            //     });
            // },

            showEntries: function () {
                if (this.entriesHidden.areEntriesToHide()) {
                    var entriesToHide = this.entriesHidden.getEntriesToHide();
                    for (var i in entriesToHide) {
                        var $div = $(entriesToHide[i]);
                        $div.show();
                    }
                }
            },

            shouldHideEntries: function($entries, entriesHidden) {
                return $entries.length !== entriesHidden.getEntriesToHide().length;
            },

            hideEntries: function () {
                if (this.entriesHidden.areEntriesToHide()) {
                    var entriesToHide = this.entriesHidden.getEntriesToHide();
                    for (var i in entriesToHide) {
                        var $div = $(entriesToHide[i]);
                        $div.hide();
                    }
                }
            }
        };

        window.Search = Search;// .create();
        
        console.log("loaded inner Search.j");
        return window.Search;
    }
);
