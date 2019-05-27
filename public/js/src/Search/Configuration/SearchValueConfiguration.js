Loader.define(
    '/public/js/src/Search/Configuration/SearchValueConfiguration.js',
    [
    ],
    function (undefined) {
        var SearchValueConfiguration = {
            wrapperPath: '',
            itemsPath: '',
            value: '',
            create: function () {
                return Object.create(this);
            },
            initSearchValueConfiguration : function(wrapperPath, itemsPath, value) {
                this.wrapperPath = wrapperPath;
                this.itemsPath = itemsPath;
                this.value = value;
            },
            getWrapperPath : function() {
                return this.wrapperPath;
            },
            getItemsPath : function() {
                return this.itemsPath;
            },
            getValuesArray : function() {
                return this.value;
            }
        };

        console.log("loaded inner SearchConfig.js");

        return SearchValueConfiguration.create();
    }
);
