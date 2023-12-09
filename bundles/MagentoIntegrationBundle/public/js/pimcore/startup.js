pimcore.registerNS("pimcore.plugin.MagentoIntegrationBundle");

pimcore.plugin.MagentoIntegrationBundle = Class.create({

    initialize: function () {
        document.addEventListener(pimcore.events.pimcoreReady, this.pimcoreReady.bind(this));
    },

    pimcoreReady: function (e) {
        // alert("MagentoIntegrationBundle ready!");
    }
});

var MagentoIntegrationBundlePlugin = new pimcore.plugin.MagentoIntegrationBundle();
