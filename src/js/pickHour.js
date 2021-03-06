/**
 * @author Administrateur
 */

var pickHour = (function() { 
  
  var getElementsByReg = function(reg,attr){
			var tabReg=new Array();
			var tabElts=document.body.getElementsByTagName('*');
			var TEL=tabElts.length;
			if(! (reg instanceof RegExp)){return tabReg;}
			i=0;
			while(tabElts[i]){
				if(tabElts[i][attr]){
					if(reg.test(tabElts[i][attr])){tabReg.push(tabElts[i]);}
				}
				i++;         
			}
			return tabReg;
	};
  
  var addEvent = function(func,onEvent,elementDom) { 
		    if (window.addEventListener) { 
				elementDom.addEventListener(onEvent, func, false); 
			} else if (document.addEventListener) { 
				elementDom.addEventListener(onEvent, func, false); 
			} else if (window.attachEvent) { 
				elementDom.attachEvent("on"+onEvent, func); 
		    } 
	  	};
  
  var affectToInput = function(final){
  	if(!final){
  		pickHour.inputChoice.value = pickHour.choiceHour+":"+((parseInt(pickHour.choiceMin) < 10 ) ? "0"+pickHour.choiceMin:pickHour.choiceMin);
	}
	else{
		pickHour.choiceHour = ((final == 12) ? pickHour.choiceHour : (((parseInt(pickHour.choiceHour)+12 ) == 24 ) ? 00 : parseInt(pickHour.choiceHour)+12));
		pickHour.inputChoice.value = pickHour.choiceHour+":"+((parseInt(pickHour.choiceMin) < 10 ) ? "0"+pickHour.choiceMin:pickHour.choiceMin);
	}
  };
  //Méthodes / variables publique 
  return {
  		"picker":null,
		"inputChoice":null,
		"pickMin":null,
		"pickFormat":null,
		"choiceHour":0,
		"choiceMin":0,
		"choiceFormat":12,
		
		"init" : function() { 
			//Récupération de tous les éléments aillant la classe spécifiée
			var hourPick = getElementsByReg(/hourPicker/,'className');
			//Affectation de l'évènement onclick sur le champs pour afficher la pickHour
			for(var i = 0 , l = hourPick.length; i <l ; i++ ){
				addEvent(function(elemDom){return function(){
					pickHour.buildPicker(elemDom)
				}}(hourPick[i])
				,"click",hourPick[i]);
			}
	  	},
		"addLoadListener" : function(func) { 
		    if (window.addEventListener) { 
				window.addEventListener("load", func, false); 
			} else if (document.addEventListener) { 
				document.addEventListener("load", func, false); 
			} else if (window.attachEvent) { 
				window.attachEvent("onload", func); 
		    } 
	  	},
	    "buildPicker":function(elementDom){
			if (pickHour.picker != null) {
				pickHour.showPicker(elementDom);
				pickHour.inputChoice = elementDom;
			}
			else {
				//On commence par créer la structure : hourPicker + ul + li
				var divContent = document.createElement("div");
				var ulContent = document.createElement("ul");
				var ulMinContent = document.createElement("ul");
				
				//Création du block Format ( 12/24 )
				var ulFormatContent = document.createElement("ul");
				ulFormatContent.className = "formatHour";
				var liContent12 = document.createElement("li");
				var aContent12 = document.createElement("a");
				aContent12.href = "#";
				aContent12.onclick = function(){
					affectToInput(12);
					pickHour.picker.style.display = "none";
				}
				var newtext12 = document.createTextNode("AM");
				aContent12.appendChild(newtext12);
				liContent12.appendChild(aContent12);
				
				var liContent24 = document.createElement("li");
				var aContent24 = document.createElement("a");
				aContent24.href = "#";
				aContent24.onclick = function(){
					affectToInput(24);
					pickHour.picker.style.display = "none";
				}
				var newtext24 = document.createTextNode("PM");
				aContent24.appendChild(newtext24);
				liContent24.appendChild(aContent24);
				
				var liContentClose = document.createElement("li");
				var aContentClose = document.createElement("a");
				var imgContent = document.createElement("img");
				imgContent.src="images/delete.png";
				aContentClose.href = "#";
				
				imgContent.onclick = function(){
					pickHour.picker.style.display = "none";
				}
				
				aContentClose.appendChild(imgContent);
				liContentClose.appendChild(aContentClose);
				
				
				//On créer toute les li format avec les liens
				var liFormat = [liContent24,liContent12,liContentClose];
				for (var i = 0, l = liFormat.length; i < l; i ++) {
					
						addEvent(function(finalFormat){
							return function(e){
								if (!e) var e = window.event;
								e.cancelBubble = true;
								
							}
						}(liFormat[i]), "click", liFormat[i]);
						
						addEvent(function(finalFormat){
							return function(e){
								if (!e) var e = window.event;
								e.cancelBubble = true;
								finalFormat.className = "outSee";
							}
						}(liFormat[i]), "mouseout", liFormat[i]);
						
						addEvent(function(finalFormat){
							return function(e){
								if (!e) var e = window.event;
								e.cancelBubble = true;
								aContent.className = "inSee";
							}
						}(liFormat[i]), "mouseover", liFormat[i]);
				}
				
				
				ulFormatContent.appendChild(liContent12);
				ulFormatContent.appendChild(liContent24);
				ulFormatContent.appendChild(liContentClose);
				
				//On créer toute les li minutes avec les liens
				for (var i = 0; i < 60; i+=5) {
						var liContent = document.createElement("li");
						var aContent = document.createElement("a");
						aContent.href = "#";
						var newtext = document.createTextNode(i);
						aContent.appendChild(newtext);
						
						addEvent(function(liContent){
							return function(e){
								if (!e) var e = window.event;
								e.cancelBubble = true;
								liContent.className = "outSee";
							}
						}(liContent), "mouseout", liContent);
						
						addEvent(function(liContent){
							return function(e){
								if (!e) var e = window.event;
								e.cancelBubble = true;
								aContent.className = "inSee";
								liContent.appendChild(pickHour.pickFormat);
								//Récupération de la valeur du lien
								pickHour.choiceMin = liContent.getElementsByTagName('a')[0].innerHTML;
								
								affectToInput();
							}
						}(liContent), "mouseover", liContent);
						liContent.appendChild(aContent);
						ulMinContent.appendChild(liContent);

				}
				
				//On créer toute les li heures avec les liens
				for (var i = 0; i < 13; i++) {
					var liContent = document.createElement("li");
					var aContent = document.createElement("a");
					aContent.href = "#";
					var newtext = document.createTextNode(i);
					aContent.appendChild(newtext);
					liContent.appendChild(aContent);
					//Sur chaque li, on affecte l'évènement d'ajout de la liste
					//des minutes
					addEvent(function(currentLi){return function(e){
						currentLi.appendChild(pickHour.pickMin);
						//Récupération de la valeur du lien
						pickHour.choiceHour = currentLi.getElementsByTagName('a')[0].innerHTML;
						affectToInput();
					}}(liContent)
					,"mouseover",liContent);
					
					ulContent.appendChild(liContent);
				}
				
				//Ajout des propriétés sur la div : className
				divContent.className = "pickHour";
				divContent.appendChild(ulContent);
				var coord = pickHour.getPosition(elementDom);
				
				divContent.style.left = coord[0] + "px";
				divContent.style.top = coord[1] + elementDom.offsetHeight + "px";
				document.body.appendChild(divContent);
				
				pickHour.picker = divContent;
				pickHour.pickMin = ulMinContent;
				pickHour.pickFormat = ulFormatContent;
				
				pickHour.inputChoice = elementDom;
			}
		},
		"showPicker" : function(elementDom){
			var coord = pickHour.getPosition(elementDom);
			pickHour.picker.style.left = coord[0] + "px";
			pickHour.picker.style.top = coord[1] + elementDom.offsetHeight + "px";
			pickHour.picker.style.display = "block"; 
		},
		
		"ajouterClasse" : function(element, classe) { 
	    if (element.className) { 
	      element.className += " "; 
	    } 
	 
	    element.className += classe; 
	  },
	  
	//Fonction permettant de trouver la position de l'élément ( input ) pour pouvoir positioner le calendrier
		"getPosition" : function(element) {
		var tmpLeft = element.offsetLeft;
		var tmpTop = element.offsetTop;
		var MyParent = element.offsetParent;
		while(MyParent) {
			tmpLeft += MyParent.offsetLeft;
			tmpTop += MyParent.offsetTop;
			MyParent = MyParent.offsetParent;
		}
			return [tmpLeft,tmpTop];
	}
  }; 
 
  
})();

if (document.getElementById && document.createTextNode) {
    pickHour.addLoadListener(pickHour.init); 
 }
