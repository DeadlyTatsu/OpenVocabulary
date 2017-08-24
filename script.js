$(window).on("scroll", function () {
//    if ($(this).scrollTop() > 100) {
//        $("#header").addClass("altHeader");
//		document.getElementById("header").addClass();
//		//style.display = "none";
//		document.getElementById("mHeader").style.display = "block";
//    }
//    else {
//        $("#header").removeClass("altHeader");
//		document.getElementById("bHeader").style.display = "block";
//		document.getElementById("mHeader").style.display = "none";
//    }
});

//function newBook() 
//{
//	"use strict";
//
//	var name = document.createTextNode(prompt("What is your book called?"));
//	var div = document.createElement("div");
//	var h1 =  document.createElement("h1");
//
//	h1.appendChild(name);
//	div.appendChild(h1);
//	
//	for	(var i = 0; i < 5; i++) 
//	{
//		var textBox = document.createElement("input");
//		textBox.className = "textbox";
//		textBox.id = "left-" + i;
//		var textBox2 = document.createElement("input");
//		textBox2.className = "textbox";
//		textBox2.id = "right-" + i;
//
//		var btn = document.createElement("input");
//		btn.className = "button";
//		btn.type = "button";
//
//		div.appendChild(textBox);
//		div.appendChild(textBox2);
//		div.appendChild(btn);
//	}
//	
//	div.className = "book";
//
//	document.getElementById("books").appendChild(div);
//}
//
//function saveWords() 
//{
//	"use strict";
//
//	var div = document.createElement("div");
//
//	var questions = [];
//	var answers = [];
//	
//	for (var i = 0; i < 5; i++) 
//	{
//		questions[i] = document.getElementById("left-" + i).value;
//		answers[i] = document.getElementById("right-" + i).value;
//	}
//	
//	var textBox = document.createElement("input");
//	textBox.className = "textbox";
//	textBox.id = "question";
//	var textBox2 = document.createElement("input");
//	textBox2.className = "textbox";
//	textBox2.id = "answer";
//	
//	div.appendChild(textBox);
//	div.appendChild(textBox2);
//	//div.appendChild(btn);
//
//	document.getElementById("books").appendChild(div);
//	
//	document.addEventListener('keydown', function(event) {
//		if (event.keyCode === 13) {
//			if (document.getElementById("answer").value === document.getElementById("question").value) {
//				alert("hi");
//
//			}
//
//		}
//	}, true);
//
//}
