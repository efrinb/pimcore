

document.addEventListener(pimcore.events.postOpenObject, (e) => {
    if (e.detail.object.data.general.className === 'Product') {
        e.detail.object.toolbar.add({
            text: t('Preview'),
            iconCls: 'pimcore_icon_preview',
            scale: 'small',
            handler: function (obj) {
                const productId = obj.data.general.id;
                const xhr = new XMLHttpRequest();
                xhr.open('GET', `/product/${productId}`, true)
                xhr.onload = function (){
                    if (xhr.status === 200){
                        const tab = window.open('','_blank');
                        tab.document.open();
                        tab.document.write(xhr.responseText);
                        tab.document.close();
                        tab.location.href = '/product/' + productId;
                    }
                }
                xhr.send();
            }.bind(this, e.detail.object)
        });
        pimcore.layout.refresh();
    }
});
