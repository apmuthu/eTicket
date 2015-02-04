function resizer(inc,eid) {
  var txtarea = document.getElementById(eid);
  if (inc==1) {
    txtarea.rows = txtarea.rows + 5;
  } else {
    txtarea.rows = txtarea.rows - 5;
  }
  document.getElementById("textarea_next_time").value=txtarea.rows;
}

function checkAll(field)
{
for (i = 0; i < field.length; i++)
	field[i].checked = true ;
}

function uncheckAll(field)
{
for (i = 0; i < field.length; i++)
	field[i].checked = false ;
}

//add/remove upload files
var upload_number = 1;
function addFileInput(i) {
	if(upload_number > 10) { return; } //no more than 10
	var d = document.createElement("div");
	var l = document.createElement("a");
	var file = document.createElement("input");
	file.setAttribute("type", "file");
	file.setAttribute("name", "attachment"+upload_number);
	l.setAttribute("href", "javascript:removeFileInput('f"+upload_number+"');");
	l.appendChild(document.createTextNode("Remove"));
	d.setAttribute("id", "f"+upload_number);
	d.appendChild(file); d.appendChild(l);
	document.getElementById(i).appendChild(d); upload_number++;
}

function removeFileInput(i) {
	var elm = document.getElementById(i);
	document.getElementById("moreUploads").removeChild(elm);
	upload_number = upload_number - 1; // decrement the max file upload counter if the file is removed
}