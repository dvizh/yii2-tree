if (typeof dvizh == "undefined" || !dvizh) {
    var dvizh = {};
}

dvizh.tree = {
    init: function() {
        $('.dvizh-tree-toggle').on('click', this.toggle)
        return true;
    },
    
    toggle: function() {
        $(this).parent("div").parent("div").parent("li").find("ul").toggle("slow");
        return false;
    }
};

dvizh.tree.init();