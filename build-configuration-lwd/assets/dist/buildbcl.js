"use strict";
class BuildSatary {
    constructor(build_id) {
        //props
        this.select_config = (Cookies.get('bcl_build_selected_' + build_id) && Cookies.get('bcl_build_selected_' + build_id) !== '') ? JSON.parse(Cookies.get('bcl_build_selected_' + build_id)).select_config : {};
        this.build_id = build_id;

    }
    //add an item/product to list
    selectItem(category_info, item_info, product_id, display_fn) {

        //in case, select_config = [], then make it an object
        if (Array.isArray(this.select_config))
            this.select_config = {};
        //add category if not exist
        this.addCategory(category_info);
        //add if not exist
        if (this.select_config[category_info.id].items[product_id]) {
            this.select_config[category_info.id].items[product_id].quantity +=  item_info.quantity;
        } else {
            this.select_config[category_info.id].items[product_id] = item_info;
        }
        //show visually
        if (typeof display_fn === 'function')
            display_fn();
    }
    //update item: like quantity, note
    updateItem(category_id, item_id, update_key, new_value) {
        const item_index = this.getItemIndexInCategory(category_id, item_id);
        if (item_index > -1) {
            this.select_config[category_id].items[item_index][update_key] = new_value;
        }
    }
    //remove an item/product from list
    removeItem(category_id, item_id, display_fn) {
        let item_index = this.getItemIndexInCategory(category_id, item_id);
        if (item_index > -1) {
            //delete item from array
            delete this.select_config[category_id].items[item_index];
            //if category empty, delete the whole category
            if (Object.keys(this.select_config[category_id].items).length == 0) {
                this.emptyCategory(category_id);
            }
            //show visually
            if (typeof display_fn === 'function')
                display_fn(category_id, item_id);
        }
    }
    getConfig() {
        return this.select_config;
    }
    getBuildId() {
        return this.build_id;
    }
    //set config, ie. user's previously saved config
    setConfig(config) {
        this.select_config = Object.assign({}, config);
    }
    emptyConfig() {
        this.select_config = {};
    }
    //check item in category
    isItemInCategory(category_id, item_id) {
        return (this.getItemIndexInCategory(category_id, item_id) > -1);
    }
    getItemIndexInCategory(category_id, item_id) {
        let item_index = -1; //non-exist
        if (this.select_config.hasOwnProperty(category_id) && this.select_config[category_id].items[item_id]) {
            item_index = item_id;
        }
        return item_index;
    }
    //helpers
    emptyCategory(category_id) {
        delete this.select_config[category_id];
    }
    addCategory(category_info) {
        if (!this.select_config.hasOwnProperty(category_info.id)) {
            this.select_config[category_info.id] = {
                info: category_info,
                items: {

                }
            };
        }
    }
}