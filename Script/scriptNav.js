function myFunction () {
	var myDropdown = document.getElementById("filtr_menu_form");
	if (myDropdown.style.display == "none") {
		document.getElementById("filtr_menu_form").style.display = "flex";
	} else {
		document.getElementById("filtr_menu_form").style.display = "none";
	}
}

//window.onclick = function (e) {
//	if (!e.target.matches('#form_filtr_button')) {
//		var myDropdown = document.getElementById("filtr_menu_form");
//		var myBtn = document.getElementById("filtr_menu_button");
//		if (myDropdown.style.display="block") {
//			myDropdown.style.display="none";
//			myBtn.style.display="block";
///		}
//	}
//}