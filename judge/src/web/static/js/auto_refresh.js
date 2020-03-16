var judge_result=['Pending..','Wait for Judge','Compiling..','Running & Judging','Accepted','Presentation Error','Wrong Answer','Time Limit Exceeded','Memory Limit Exceeded','Output Limit Exceeded','Runtime Error','Compilation Error','Compilation Ok','Test Run',''];
var judge_color=["default","info","warning","warning","success","danger","danger","warning","warning","warning","warning","warning","warning","info"];
interval=400;
function auto_refresh(){
    var tb=window.document.getElementById('tableID');
    var rows=tb.rows;
    for(var i=rows.length-1;i>0;i--){
        result = $(rows[i].cells[3].children[0]).attr("result");
        if(result<4){
            var sid = rows[i].cells[0].innerHTML;
            window.setTimeout("fresh_result("+sid+")",interval);
        }
    }
}

function findRow(solution_id){
    var tb=window.document.getElementById('tableID');
    var rows=tb.rows;
    for(var i=1;i<rows.length;i++){
        var cell=rows[i].cells[0];
        if(cell.innerHTML==solution_id) return rows[i];
    }
}

function fresh_result(solution_id){
    var tb=window.document.getElementById('tableID');
    var row=findRow(solution_id);
    $.post("/api/ajax_status.php", { sid: solution_id },
        function(data){
            stat = data.result.result;
            mem  = data.result.memory;
            time = data.result.time;
            res = "<span class='hidden' style='display:none' result=“+ stat +”></span>";
            row.cells[3].innerHTML=res+"<span class='label label-"+judge_color[stat]+"'>"+judge_result[stat] +"</span>";
            row.className = judge_color[stat];
            row.cells[4].innerHTML=mem;
            row.cells[5].innerHTML=time;
            if(stat<4){
                window.setTimeout("fresh_result("+solution_id+")",interval);
                interval*=2;
            }
            else{
                auto_refresh();
            }
        },"json");
}
auto_refresh();