Loader.add(
    '/public/js/src/Search.js',
    [
        "jQuery",
        "/public/js/src/SearchConfig.js",
        "/public/js/src/SearchCss.js",
        "/public/js/src/EntriesHidden.js"
    ],
    function ($, SearchConfig, SearchCss, EntriesHidden, undefined) {
        console.log("Search loaded");
        var Search = {
            create : function() {
                var search = Object.create(this);
                search.searchConfig = SearchConfig.create();
                search.searchCss = SearchCss.create();
                search.entriesHidden = EntriesHidden.create();

                search.init();

                return search;
            },

            init: function() {
                var self = this;
                $('#search > .search_type > .search_button').bind('click', function () {
                    var $entries = $('#entries .entry');
                    var $clickedButton = $(this);

                    // var $searchField = $clickedButton.prev('.search_text');
                    var $searchField = $clickedButton.prev().prev();
                    var search = $searchField.val();
                    var $label = $searchField.prev('label');
                    var type = $label.text().replace(':', '');
                    var cssClass = '.' + type + '_type';
                    var searchCss = self.searchCss.create(cssClass);
                    var searchConfiguration = self.searchConfig.create(search, searchCss);

                    // add entries to keep
                    self.addEntriesToHide($entries, self.entriesHidden, searchConfiguration);
                    self.hideEntries();
                });
                $('#search > .reset_button').bind('click', function () {
                    self.showEntries();
                    self.entriesHidden.emptyEntriesToHide();
                });
            },

            addEntriesToKeep: function($entries, entriesObj, searchConfigurationObj) {
                var hideEntries;
                $entries.each(function () {
                    var $danceType = $(this).find(searchConfigurationObj.getSearchCss().getCssClass());
                    var danceFound = false;
                    $danceType.each(function () {
                        var text = $(this).text();
                        if (searchConfigurationObj.getSearchText() === text) {
                            danceFound = true;
                            hideEntries = true;
                        }
                    });
                    if (danceFound) {
                        entriesObj.addEntriesToKeep($(this));
                    }
                });
            },

            addEntriesToHide: function($entries, entriesObj, searchConfigurationObj) {
                var hideEntries;
                $entries.each(function () {
                    var $danceType = $(this).find(searchConfigurationObj.getSearchCss().getCssClass());
                    var danceFound = false;
                    $danceType.each(function () {
                        var text = $(this).text();
                        if (searchConfigurationObj.getSearchText() === text) {
                            danceFound = true;
                            hideEntries = true;
                        }
                    });
                    if (!danceFound) {
                        entriesObj.addEntriesToHide($(this));
                    }
                });
            },

            showEntries: function () {
                if (this.entriesHidden.areEntriesToHide()) {
                    var entriesToHide = this.entriesHidden.getEntriesToHide();
                    for (var i in entriesToHide) {
                        var $div = entriesToHide[i];
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
                        var $div = entriesToHide[i];
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
