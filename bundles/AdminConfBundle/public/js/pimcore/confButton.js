
pimcore.registerNS("pimcore.plugin.AdminConfBundle");
pimcore.plugin.AdminConfBundle = Class.create({
    initialize: function () {
        document.addEventListener(pimcore.events.pimcoreReady, this.pimcoreReady.bind(this));
    },

    pimcoreReady: function (e) {
        var user = pimcore.globalmanager.get("user");
        // console.log(user)
        var permissions = user.permissions;
        // console.log(permissions)

        if (permissions.indexOf("users") !== -1) {
            var navigationUl = Ext.get(Ext.query("#pimcore_navigation UL"));
            var newMenuItem = Ext.DomHelper.createDom('<li id="pimcore_menu_conf" class="pimcore_menu_item pimcore_menu_needs_children true-initialized" data-menu-tooltip="Admin Config"></li>');
            navigationUl.appendChild(newMenuItem);
            pimcore.helpers.initMenuTooltips();
            var iconImage = document.createElement("img");
            iconImage.src = "/bundles/pimcoreadmin/img/flat-color-icons/settings.svg";
            newMenuItem.appendChild(iconImage)
            newMenuItem.onclick = function (event) {
                this.openSubmenu(event);
            }.bind(this);
        }
    },

    openSubmenu: function (event){
        var newMenuItem = event.currentTarget;
        var newMenuItemPosition = Ext.get(newMenuItem).getXY();
        const submenu = new Ext.menu.Menu({
            items: [
                {
                    text: "Admin Configuration",
                    iconCls: "pimcore_icon_settings",
                    handler: this.openConfigurationTab.bind(this)
                }
            ]
        });
        submenu.showAt([
            newMenuItemPosition[0] + newMenuItem.offsetWidth,
            newMenuItemPosition[1]
        ]);
    },

    openConfigurationTab: function () {
        if (this.configpanel) {
            var configPanel = Ext.getCmp("pimcore_panel_tabs");
            configPanel.setActiveTab(this.configpanel);
        }else {
            this.configpanel = new Ext.Panel({
                title: t('Admin Configuration'),
                id: "configTab",
                iconCls: "pimcore_icon_support",
                closable: true,
                layout: "anchor",
                bodyStyle: 'padding:20px 5px 20px 5px;',
                border: false,
                autoScroll: true,
                forceLayout: true,
                defaults: {
                    forceLayout: true
                },
                fieldDefaults: {
                    labelWidth: 250
                },
                items: [
                    {
                        xtype: 'fieldset',
                        title: t('Config Data'),
                        collapsible: true,
                        collapsed: true,
                        autoHeight: true,
                        labelWidth: 200,
                        defaults: {width: 500},
                        items: [
                            {
                                xtype: 'checkbox',
                                boxLabel: 'Checkbox for display data in front-end',
                                id: 'config_checked'
                            },
                            {
                                xtype: 'textfield',
                                name: 'emp_name',
                                id: 'emp_name_id',
                                fieldLabel: 'Employee Name',
                            },
                            {
                                xtype: 'combo',
                                name: 'emp_pos',
                                id: 'emp_pos_id',
                                store: ['Backend Developer', 'Frontend Developer', 'DevOps', 'Senior Backend Developer'],
                                fieldLabel: 'Position',
                                multiSelect: true,
                                editable: false
                            },
                            {
                                xtype: 'textareafield',
                                name: 'emp_details',
                                id: 'emp_details_id',
                                fieldLabel: 'Description'
                            }
                        ]
                    }
                ],
                buttons: [
                    {
                        text: t('Save'),
                        iconCls: 'pimcore_icon_save',
                        handler: this.save.bind(this),
                    }
                ]
            });

            Ext.Ajax.request({
                url: '/admin_get_config',
                method: 'GET',
                success: function (response) {
                    try {
                        var data = Ext.decode(response.responseText);
                        if (data) {
                            Ext.getCmp('emp_name_id').setValue(data.emp_name);
                            Ext.getCmp('emp_pos_id').setValue(data.emp_position);
                            Ext.getCmp('emp_details_id').setValue(data.emp_details);
                            Ext.getCmp('config_checked').setValue(data.config_checked);
                        }
                    } catch (e) {
                        console.error('Error loading configuration data: ' + e);
                    }
                }.bind(this)
            });

            var configPanel = Ext.getCmp("pimcore_panel_tabs");
            configPanel.add(this.configpanel);
            configPanel.setActiveItem(this.configpanel);
        }
        if (this.configpanel){
            this.configpanel.on('beforeclose', function (tab){
                this.configpanel = null;
            }.bind(this));
        }
    },

    save: function () {
        const fieldsToValidate = [
            { field: Ext.getCmp('emp_name_id'), name: 'Employee Name' },
            { field: Ext.getCmp('emp_pos_id'), name: 'Position' },
            { field: Ext.getCmp('emp_details_id'), name: 'Description' },
        ];

        const validationErrors = [];

        fieldsToValidate.forEach((fieldInfo) => {
            const { field, name } = fieldInfo;
            const value = field.getValue();

            if (!value) {
                validationErrors.push(name);
                field.markInvalid('This field is required.');
            } else {
                field.clearInvalid();
            }
        });

        if (validationErrors.length > 0) {
            const errorMessage = `Please fill in the following field(s): ${validationErrors.join(', ')}.`;
            pimcore.helpers.showNotification(t("error"), errorMessage, "error");
            return;
        }

        const emp_name = Ext.getCmp('emp_name_id').getValue();
        const emp_position = Ext.getCmp('emp_pos_id').getValue();
        const emp_details = Ext.getCmp('emp_details_id').getValue();
        const config_checked = Ext.getCmp('config_checked').getValue();

        const data = {
            emp_name: emp_name,
            emp_position: emp_position,
            emp_details: emp_details,
            config_checked: config_checked
        };

            Ext.Ajax.request({
                url: '/admin_config',
                method: 'POST',
                params: {
                    data: Ext.encode(data)
                },
                success: function (response) {
                    try {
                        var res = Ext.decode(response.responseText);
                        if (res.success) {
                            pimcore.helpers.showNotification(t("success"), t("saved_successfully"), "success");

                            Ext.MessageBox.confirm(t("info"), t("reload_pimcore_changes"), function (buttonValue) {
                                if (buttonValue == "yes") {
                                    window.location.reload();
                                }
                            }.bind(this));
                        } else {
                            pimcore.helpers.showNotification(t("error"), t("saving_failed"),
                                "error", t(res.message));
                        }
                    } catch (e) {
                        pimcore.helpers.showNotification(t("error"), t("saving_failed"), "error");
                    }
                }.bind(this)
            });
        }
});

var AdminConfBundlePlugin = new pimcore.plugin.AdminConfBundle();
