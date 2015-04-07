function capcha(v,val)
{
document.getElementById("code_comm").value = "";
    for(var i=1;i<=4;i++)document.getElementById("cp"+i+"OK").style.display = "none";
    
    document.getElementById("cp"+v+"OK").style.display = "block";
    document.getElementById("code_comm").value = val;	
}


