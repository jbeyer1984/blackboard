Loader.define(
    '/public/js/src/EntriesHidden.js',
    [],
    function (undefined) {
        var EntriesHidden = {
            create: function() {
                var entriesHidden = Object.create(this);
                entriesHidden.entriesToHide = [];

                return entriesHidden;
            },

            emptyEntriesToHide: function() {
                this.entriesToHide = [];
            },
            
            mergeEntriesToHide: function($entries) {
                this.entriesToHide = $.merge(this.entriesToHide, $entries);
            },

            addEntriesToHide: function($entry) {
                this.entriesToHide.push($entry);
            },

            areEntriesToHide: function () {
                return this.entriesToHide.length > 0;
            },

            getEntriesToHide: function() {
                return this.entriesToHide;
            }
        };

        console.log("loaded inner EntriesHidden.js");
        
        return EntriesHidden;
    }    
);