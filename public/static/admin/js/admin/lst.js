var lst_ops = {
    init: function(){
        this.eventBind();
    },
    eventBind: function(){
        $("select[name=status]").change(function(){
            //console.log($(this).val());
            //console.log('works');

            $('.wrap-filter').submit();

        });
    }
};

$(document).ready(function(){
    lst_ops.init();
});