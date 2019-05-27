Loader.define(
    '/public/js/src/Search/Configuration/SearchCheckBoxConfiguration.js',
    [
    ],
    function (undefined) {
        var SearchCheckBoxConfiguration = {
            items: '',
            create: function () {
                return Object.create(this);
            },
            initSearchCheckBoxConfiguration : function(items) {
                this.items = items;
            },
            getItems : function() {
                return this.items;
            }
        };

        console.log("loaded inner SearchConfig.js");

        return SearchCheckBoxConfiguration.create();
    }
);
