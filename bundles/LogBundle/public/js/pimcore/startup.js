pimcore.registerNS("pimcore.plugin.LogBundle");

pimcore.plugin.LogBundle = Class.create({

    initialize: function () {
        document.addEventListener(pimcore.events.pimcoreReady, this.pimcoreReady.bind(this));
    },

    pimcoreReady: function (e) {
        // alert("LogBundle ready!");
    }
});

var LogBundlePlugin = new pimcore.plugin.LogBundle();
