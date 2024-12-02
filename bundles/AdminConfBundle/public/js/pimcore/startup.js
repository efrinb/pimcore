pimcore.registerNS("pimcore.plugin.AdminConfBundle");

pimcore.plugin.AdminConfBundle = Class.create({

    initialize: function () {
        document.addEventListener(pimcore.events.pimcoreReady, this.pimcoreReady.bind(this));
    },

    pimcoreReady: function (e) {
        // alert("AdminConfBundle ready!");
    }
});

var AdminConfBundlePlugin = new pimcore.plugin.AdminConfBundle();
