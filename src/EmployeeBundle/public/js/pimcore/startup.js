pimcore.registerNS("pimcore.plugin.EmployeeBundle");

pimcore.plugin.EmployeeBundle = Class.create({

    initialize: function () {
        document.addEventListener(pimcore.events.pimcoreReady, this.pimcoreReady.bind(this));
    },

    pimcoreReady: function (e) {
        // alert("EmployeeBundle ready!");
    }
});

var EmployeeBundlePlugin = new pimcore.plugin.EmployeeBundle();
