Loader.define(
    '/public/js/src/Search/Configuration/SearchValueExistingConfiguration.js',
    [
    ],
    function (undefined) {
        var SearchValueExistingConfiguration = {
            wrapperPath: '',
            itemsPath: '',
            checkOn: {
                like: false,
                exact: true,
                inverse: false
            },
            create: function () {
                return Object.create(this);
            },
            initSearchValueExistingConfiguration : function(wrapperPath, itemsPath, checkOn) {
                this.wrapperPath = wrapperPath;
                this.itemsPath = itemsPath;
                this.checkOn = checkOn;
            },
            getWrapperPath : function() {
                return this.wrapperPath;
            },
            getItemsPath : function() {
                return this.itemsPath;
            },
            getCheckOn : function() {
                return this.checkOn;
            }
        };

        console.log("loaded inner SearchConfig.js");

        return SearchValueExistingConfiguration.create();
    }
);
