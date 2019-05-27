Loader.define(
    '/public/js/src/Search/Configuration/SearchItemsExistingConfiguration.js',
    [
    ],
    function (undefined) {
        var SearchItemsExistingConfiguration = {
            items: '',
            nestedSearchPerItem: [], 
            checkOn: {
                atLeast: false,
                exact: true,
                inverse: false
            },
            create: function () {
                return Object.create(this);
            },
            initSearchItemsExistingConfiguration : function(items, nestedSearchPerItem, checkOn) {
                this.items = items;
                this.nestedSearchPerItem = nestedSearchPerItem;
                this.checkOn = checkOn;
            },
            getItems : function() {
                return this.items;
            },
            getNestedSearchPerItem : function() {
                return this.nestedSearchPerItem;
            },
            getCheckOn : function() {
                return this.checkOn;
            }
        };

        console.log("loaded inner SearchConfig.js");

        return SearchItemsExistingConfiguration.create();
    }
);
