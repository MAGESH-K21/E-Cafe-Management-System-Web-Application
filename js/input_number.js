function add_amt(id){
    var amt_bx = document.getElementById(id);
    var amt = amt_bx.value;
    if(amt<99){
        amt_bx.value++;
    }
}

function sub_amt(id){
    var amt_bx = document.getElementById(id);
    var amt = amt_bx.value;
    if(amt>1){
        amt_bx.value--;
    }
}