<!--
function showTAB(id) {
	obj_tabs = document.getElementById(id);
	obj_tabs.style.display = "block"
}
function hideTAB() {
	obj_tabs.style.display = "none";
}
function change(obj)
{
//alert(obj.parentNode.id)
for(i=0;i<document.getElementsByTagName("li").length;i++)
{
document.getElementsByTagName("li")[i].className=""
}
obj.parentNode.className="active"
//alert(obj.parentNode.id)
}
//-->