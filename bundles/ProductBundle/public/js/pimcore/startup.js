
pimcore.registerNS("pimcore.plugin.ProductBundle");

pimcore.plugin.ProductBundle = Class.create({

    initialize: function () {
        document.addEventListener(pimcore.events.pimcoreReady, this.pimcoreReady.bind(this));
    },

    pimcoreReady: function (e) {
        //alert("EmployeeBundle ready!");
    }
});

var ProductBundlePlugin = new pimcore.plugin.ProductBundle();