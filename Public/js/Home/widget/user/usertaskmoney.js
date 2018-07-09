/**
 * Created by Red on 2017/7/11.
 */

/**
 * 删除单价列表
 * @param dom
 */
function delMoney(dom) {
    $(dom).parent('td').parent('tr').remove()
}
/**
 * 增加单价列表
 */
function addMoney() {
    var html = $('#taskMoneyTemp table tbody').html()
    html = html.replace(/AAA/g, "priceA");
    html = html.replace(/BBB/g, "countA");
    $('#price-list tr:last').after(html)
}
/**
 * 计算每个单价小计
 * @param dom
 * @param target
 */
function calculatePrice(dom,target) {
    var val = $(dom).val()
    var next =''
    var val_1 =''
    if(target=='price'){
        val_1 = parseFloat(val).toFixed(1)
    }else {
        var floatValue = parseFloat(val).toFixed(1)
        var intBefore = parseInt(val) ;
        var intAfter  = parseInt(val)+1

        var cal = parseFloat(floatValue)+0.5
        if(cal==intAfter){
            val_1 = floatValue
        }else if(cal>intAfter){
            val_1 = intAfter
        }else {
            val_1 = intBefore
        }
    }
    if (isNaN(val_1)){
        $(dom).val('')
    }else {
        $(dom).val(val_1)
    }

    if(target=='price'){
        next = $(dom).parent('td').next().children(":first").val()
        if (next){
            var total = parseFloat(val_1*next).toFixed(2)
            $(dom).parent('td').next().next().children(":first").val(isNaN(total)?'':total)
            calculatePriceTotal()
        }
    }else if (target=='count'){
        next = $(dom).parent('td').prev().children(":first").val()
        if (next){
            var total = parseFloat(val_1*next).toFixed(2)
            $(dom).parent('td').next().children(":first").val(isNaN(total)?'':total)
            calculatePriceTotal()
        }
    }else {
        return
    }

}
/**
 * 工作合计
 */

function calculatePriceTotal(dom) {
    if(dom){
        var val = $(dom).val()
        var val_1 =parseFloat(val).toFixed(1)
        if (isNaN(val_1)){
            $(dom).val('0.00')
        }else {
            $(dom).val(val_1)
        }
    }
    var priceTotal =0
    $('.perPriceTotal').each(function(){
        if($(this).val()){
            priceTotal += parseFloat($(this).val())
        }
    });
    var reward = $('#reward').val()==''?'0.00':$('#reward').val()
    var debit = $('#debit').val()==''?'0.00':$('#debit').val()
    var commission = $('#commission').val()==''?'0.00':$('#commission').val()
    priceTotal = parseFloat(priceTotal)+(parseFloat(reward)+parseFloat(commission)-parseFloat(debit))
    $('#totalMoney').val(priceTotal.toFixed(2))
    $('#totalMoneyLabel').html(priceTotal.toFixed(2))
}
/**
 * 保存提交
 * @param formId
 */
function checkSubmit(formId){
    var price =true

    $('.priceA').each(function(k,e){
        if($(this).val()==''){
            layer.msg('请填写第'+(k+1)+'个单价',{time:1000})
            price=false
            return
        }
    });
    if(price===false){
        return
    }
    var count = true
    $('.countA').each(function(k1,e1){
        if($(this).val()==''){
            layer.msg('请填写第'+(k1+1)+'个工作量',{time:1000})
            count=false
            return
        }
    });
    if(count===false){
        return
    }
    var url=document.getElementById(formId).action
    $.ajax({
        type: "post",
        url:url,
        cache:false,
        async:false,
        data:$('#'+formId).serialize(),
        success: function(data){
            try{
                var res=eval('('+data+')') ;
                if(res.status==1) {
                    parent.window.location.reload();
                    var index = parent.layer.getFrameIndex(window.name);
                    layer.close(index);
                }else {
                    layer.msg(res.msg,{time:1000});
                }
            }catch (e){
                layer.msg(data,{time:1000});
            }
        }
    });
}
