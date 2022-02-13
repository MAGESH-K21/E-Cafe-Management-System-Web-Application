// Adjust the min ending date range of
// specific date selection in revenue selection page
function update_minrange() {
    var start_input = document.getElementById("start_date");
    try {
        var start_date = start_input.value;
    } catch (TypeError) {
        const today = new Date();
        var start_date = today.toISOString().split('T')[0];
    }
    var end_input = document.getElementById("end_date");
    end_input.min = start_date;
}

function switch_disable(status){
    var start_input = document.getElementById("start_date");
    var end_input = document.getElementById("end_date");
    var rev_mode5 = document.getElementById("rev_mode5");
    if(rev_mode5.checked){
        console.log("enable");
        start_input.disabled=false;
        end_input.disabled=false;
    }else{
        console.log("disable");
        start_input.disabled=true;
        end_input.disabled=true;
    }
}

window.onload(
    update_minrange()
);