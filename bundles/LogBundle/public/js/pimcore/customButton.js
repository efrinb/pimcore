pimcore.registerNS("pimcore.plugin.LogBundle");
pimcore.plugin.LogBundle = Class.create({

    initialize: function () {
        document.addEventListener(pimcore.events.pimcoreReady, this.pimcoreReady.bind(this));
    },

    pimcoreReady: function (e) {
        // Check if the user has specific permissions
        var user = pimcore.globalmanager.get("user");
        var permissions = user.permissions;

        if (permissions.indexOf("objects") !== -1) {
            var navigationUl = Ext.get(Ext.query("#pimcore_navigation UL"));
            var newMenuItem = Ext.DomHelper.createDom('<li id="pimcore_menu_new-item" data-menu-tooltip="Admin Log" class="pimcore_menu_item icon-book_open"></li>');
            navigationUl.appendChild(newMenuItem);
            pimcore.helpers.initMenuTooltips();
            var iconImage = document.createElement("img");
            iconImage.src = "/bundles/pimcoreadmin/img/flat-white-icons/text.svg";
            newMenuItem.appendChild(iconImage);
            newMenuItem.onclick = function () {
                this.getTabPanel();
            }.bind(this);
        }
    },

    getTabPanel: function () {
        var mainPanel = Ext.getCmp("pimcore_panel_tabs");
        var existingTab = mainPanel.getComponent("adminLogTab");
        if (!existingTab) {
            var store = Ext.create('Ext.data.Store', {
                fields: ['id', 'userid', 'action', 'timestamp'],
                autoLoad: true,
                pageSize: 50,
                proxy: {
                    type: 'ajax',
                    url: '/listinglog',
                    reader: {
                        type: 'json',
                        rootProperty: 'data',
                        totalProperty: 'total',
                    }
                }
            });

            var tabPanel = new Ext.Panel({
                id: "adminLogTab",
                title: "Admin Log",
                width: 900,
                height: 400,
                closable: true,
                layout: "fit",
                items: [
                    {
                        xtype: 'grid',
                        columns: [
                            { text: "ID", dataIndex: "id" },
                            { text: "Admin User ID", dataIndex: "userid" },
                            { text: "Timestamp", dataIndex: "timestamp" },
                            {
                                text: "Action",
                                dataIndex: "action",
                                flex: 1,
                                renderer: function (value, metaData) {
                                    metaData.tdAttr = 'data-qtip="' + value + '"';
                                    return value;
                                }
                            }
                        ],
                        store: store,
                        bbar: Ext.create('Ext.PagingToolbar', {
                            store: store,
                            displayInfo: true,
                            displayMsg: 'Displaying {0} - {1} of {2}',
                            emptyMsg: "No data to display",
                        }),
                    }
                ]
            });
            tabPanel.setIcon('/bundles/pimcoreadmin/img/flat-white-icons/text.svg');
            mainPanel.add(tabPanel);
        }
        mainPanel.setActiveTab(existingTab || tabPanel);
    },
});

var LogBundlePlugin = new pimcore.plugin.LogBundle();