var obCalculator = {

        width: 0,
        height: 0,
        length: 0,
        items: [], //полки
        products: [], //товары,
        currentItemKey: 0, //текущая выбранная полка

        /**
         *
         * @param param
         * @param self
         */
        setWidth: function(self)
        {
            this.width = self.value;
            this.items = [];
        },

        /**
         *
         * @param self
         */
        setHeight: function(self)
        {
            this.height = self.value;
            this.items = [];
        },

        /**
         *
         * @param self
         */
        setLength: function(self)
        {
            this.length = self.value;
            this.items = [];
        },

        /**
         *
         * @param itemKey
         * @returns {*}
         */
        getItemHeight: function(itemKey)
        {
            return this.items[itemKey].height;
        },

        /**
         *
         * @param itemKey
         */
        setCurrentItem: function(itemKey)
        {
            this.currentItemKey = itemKey;
        },

        /**
         *
         * @param self
         */
        addItem: function(targetSelector)
        {
            var $target = $(targetSelector);

            if ($target.length > 0) {
                var itemHeight = parseFloat($target.val());
                if (!isNaN(itemHeight) && itemHeight > 0) {
                    this.items.push({
                        height: itemHeight,
                        products: []
                    });
                }
            }
        },

        /**
         *
         * @param itemKey
         */
        deleteItem: function(itemKey)
        {
            this.items.splice(itemKey, 1);
        },

        /**
         *
         * @param _length
         * @param _width
         * @param _height
         * @param productId
         */
        addProduct: function(_width, _height, _length, productId)
        {
            this.items[this.currentItemKey].products.push({
                length: _length,
                width: _width,
                height: _height,
                id: productId
            });
        },

        /**
         *
         * @param key
         */
        deleteProduct: function(key)
        {
            if (!!this.items[this.currentItemKey].products[key]) {
                this.items[this.currentItemKey].products.slice(key, 1);
            }
        },

        /**
         *
         * @param width
         * @param height
         * @param length
         * @param productId
         */
        addCollection: function(width, height, length, productId)
        {
            var error = "";

            if (this.width < width) {
                error = "Большая ширина";
            } else if (this.items[this.currentItemKey].height < height) {
                error = "Большая высота";
            } else if (this.length < length) {
                error = "Большая глубина";
            }
            if (error.length > 0) {
                this.showMessage(error);
                return;
            }
            for (var counter = 0; counter < parseInt(this.width/width); counter++) {
                this.addProduct(width, height, length, productId)
            }
        }

    },
    obCalculatorRender = {

        blockId: "rack-content",

        traiInputBlockId: "calculator_render-items",

        traiIdPrefix: "trai-",

        traiItemHeight: 18,

        rackItemHeight: 10,

        /**
         *
         * @param id
         */
        setBlockId: function(id)
        {
            this.blockId = id;
        },

        /**
         *
         * @param id
         */
        setTraiInputBlockId: function(id)
        {
            this.traiInputBlockId = id;
        },

        /**
         *
         */
        renderMain: function()
        {
            var wrapperNode = document.getElementById(this.blockId),
                rackNode = null,
                wrapperHeight = this.height,
                ctx = this,
                newItemHeight = 0;
            if (!!wrapperNode) {
                wrapperNode.innerHTML = "";
                console.log(obCalculator.items);
                obCalculator.items.forEach(function(item, index) {
                    newItemHeight += ctx.rackItemHeight*index;
                    newItemHeight += item.height;
                    rackNode = ctx.string2Node(ctx.getRackItem(newItemHeight));
                    item.products.forEach(function(product) {
                        rackNode.appendChild(ctx.string2Node(ctx.getTraiItem(product.width, product.height)))
                    })
                    wrapperNode.appendChild(rackNode);
                    wrapperNode.appendChild(ctx.string2Node(ctx.getRackDelete(newItemHeight, index)));
                    if (newItemHeight > wrapperHeight) {
                        wrapperHeight = newItemHeight;
                    }
                });
                wrapperHeight += 50;
                wrapperNode.style.height = wrapperHeight + "px";
            }
        },

        /**
         *
         * @param width
         * @param height
         * @returns {string}
         */
        getTraiItem: function(width, height)
        {
            return '<div class="tray_item" style="width: ' + width + 'px;height: ' + height + 'px;top: -' + height + 'px">' +
                '<a href="#" class="tray_item-close" title="удалить"><i class="icon close"></i></a>' +
                '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 27.002 17.997"><defs><style>.a_{fill:#ff2429;}</style></defs><path class="a_" d="M-21980.4,206.55l-3.6-3.6v-14.4h2v13.6l2.4,2.4h18.2l2.4-2.4v-11.6h-2v9h-19v-9h-2v-2h25v14.4l-3.6,3.6Zm2.4-9h15v-7h-15Z" transform="translate(21984 -188.552)"/></svg>' +
                '</div>'
            ;
        },

        /**
         *
         * @param height
         * @returns {string}
         */
        getRackItem: function(height)
        {
            return '<div class="rack_item" style="top: ' + height + 'px"></div>';
        },

        /**
         *
         * @param top
         * @param id
         * @returns {string}
         */
        getRackDelete: function(top, id)
        {
            return '<a href="#" class="rack-delete" style="top:' + top + 'px" title="удалить" onclick="obCalculator.deleteItem(' + id + ')">' +
                    '<i class="icon close"></i>' +
                '</a>';
        },

        /**
         *
         * @param string
         * @returns {ChildNode}
         */
        string2Node: function(string)
        {
            var parser = new DOMParser(),
                dom = parser.parseFromString(string, "text/html");

            return dom.body.childNodes[0];
        },

        /**
         *
         * @param string
         */
        showMessage: function(string)
        {
            console.log(string);
        }

    };