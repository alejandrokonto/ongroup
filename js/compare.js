var myPos;
var bsPrice = 0;
var bsDur = 0;
var bsDist = 0;
var cmpAgency = null;
var packages = [];
var pckgs = []; var cnt=0; 
	
function init(){
	loadPackages();	
}

function loadPackages(){
		
		var tempLatS,tempLongS = 0;

		if(localStorage.length != 0) {
		
		for (var i=0; i < localStorage.length; i++){
			/*retreive the stored packages*/
			var key = localStorage.key(i);
			var value = localStorage.getItem(key);
			var parsedValue = JSON.parse(value);
			packages[i] = parsedValue;
                        
		}

		/*initialize global variable cnt and then import packages while calculating the distances from each package*/	  
	

			    navigator.geolocation.getCurrentPosition(function(position){
				myPos = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
				
				for(var i = 0; i < packages.length;i++){
							var latS = 0;
						   var longS = 0;var distance = 0;
						   var latC = 0;
  						    var longC = 0;

  						 for(var j=0; j < packages[i].lat.length; j++){
               					 latS += parseFloat(packages[i].lat[j]);
               					 longS += parseFloat(packages[i].long[j]);
       						 }

   						 latC = latS/packages[i].lat.length;
   						 longC = longS/packages[i].lat.length;

						 var destPlace = new google.maps.LatLng(latC,longC);
	
						distance = google.maps.geometry.spherical.computeDistanceBetween(myPos,destPlace);
                        			distance = distance/1000;
                      				distance = (distance).toFixed(0);
					
						if(bsDist == 0){bsDist = distance}

						addToDOM(packages[i],distance);
				}
			});
			
			
		
		}else{alert("no destinations choosed!");}

}

function addToDOM(item,distance){
   
   /*define wether it is the compared pckg or not*/
   var div = document.createElement("div");
   if(bsPrice == 0){ div.setAttribute("class","pckgFrame basePckg");}
		else{div.setAttribute("class","pckgFrame");}

   

   /*define footer of the package*/
   var footer = document.createElement("div");
   footer.setAttribute("class","footer");
   if(bsPrice == 0){
   	footer.innerHTML = '<a href="./destination.php?id='+item.id+'&ag='+item.agID+'" class="view"><i class="fa fa-eye"></i> View</a>';
   	footer.innerHTML += '<a href="./cart.php?id='+item.id+'&ag='+item.agID+'" class="cartIt"><i class="fa fa-shopping-cart"></i> Buy Now</a>';
   }else{
	var button = document.createElement("button");
	button.innerHTML = "COMPARE THIS";
	button.onclick = function(){reEvaluate(item.id);}
        footer.appendChild(button);	
   }		
   createDestTitleAppend(item.dests,div);  

   var img = document.createElement("img");
   img.src = item.pic;
   div.appendChild(img);
   /*calculate duration of the tour*/
   var leaving = getDateFromFormat(item.ldate,"d-M-yyyy");
   var returning = getDateFromFormat(item.rdate,"d-M-yyyy");
   
   var duration = dateDiff(leaving,returning);
   
   
				
   /*compare data before adding 'em to the DOM*/
	var lengthPrice = item.price.length;
	var numPrice = parseInt(item.price.substr(0,lengthPrice-1));

   if(bsPrice == 0){
	cmpPrice = '<i class="fa fa-hand-o-left"></i>';
	cmpDur = '<i class="fa fa-hand-o-left"></i>';
	cmpDist = '<i class="fa fa-hand-o-left"></i>';
	bsPrice = numPrice;
	bsDur = duration;
	}else{
	if(numPrice > bsPrice){cmpPrice = '<i class="fa fa-arrow-circle-up red"></i>'; }
		else if(numPrice < bsPrice){cmpPrice = '<i class="fa fa-arrow-circle-down green"></i>';}
			else {cmpPrice = '<i class="fa fa-check-square green"></i>'; }

	if(duration > bsDur){cmpDur = '<i class="fa fa-arrow-circle-up green"></i>';}
		else if(duration < bsDur){cmpDur = '<i class="fa fa-arrow-circle-down red"></i>';}
			else{cmpDur = '<i class="fa fa-check-square green"></i>';}
	if(distance > bsDist){cmpDist = '<i class="fa fa-arrow-circle-up green"></i>'; }
		else if(distance < bsDist){cmpDist = '<i class="fa fa-arrow-circle-down red"></i>'; }
			else{cmpDist = '<i class="fa fa-check-square green"></i>';}	
  	}
  /*create an object for each package for later comparisons and add it to an array*/
    
   if(cnt < packages.length){
	pckgs[cnt] = new pckgs2cmp(item.id,item.agID,distance,duration,numPrice,item.agency,item.pic,item.dests);
	cnt++; 
   } 
  /*give them the appropriate output form*/
   item.price = item.price.substr(0,item.price.length-1);
   item.price = item.price+" &euro;";
   item.duration = item.duration+" days";
   distance = distance+" km";
  
   createDetailNappend("Agency: ",item.agency,div,cmpAgency);
   createDetailNappend("Price: ",item.price,div,cmpPrice);
   createDetailNappend("Duration: ",duration,div,cmpDur);
   createDetailNappend("Distance: ",distance,div,cmpDist);
   div.appendChild(footer);
		      
   /*add it to the content*/
	var content = document.querySelector(".packagesWrapper");
	content.appendChild(div);
   
}

function reEvaluate(id){
	for(var i=0;i < cnt;i++){

		if(pckgs[i].id == id){
			evaluate(pckgs[i].id,pckgs[i]);
			break;	
		}
	}
}

function evaluate(baseID,basePckg){
	
	/*change the base pckg details*/
	var titleDets = document.querySelector(".basePckg .destsWrapper");
		/*clear the title contents*/
		while(titleDets.hasChildNodes()){
			titleDets.removeChild(titleDets.firstChild);
		}
		/* and refill them */
		for(var i =0;i < basePckg.dests.length;i++ ){
			var divValue = document.createElement("div");
			divValue.setAttribute("class","value");
			divValue.innerHTML = basePckg.dests[i];
			titleDets.appendChild(divValue);
		}
        var pckgImg = document.querySelector(".basePckg img");
	pckgImg.src = basePckg.img;
	
	/* pick all the details of base package and update*/
	var details = document.querySelectorAll(".basePckg .details");
	
	for(var i =0;i < details.length;i++){
		var newValue = details[i].querySelector(".value");
		if(i==0){newValue.innerHTML = basePckg.agency;}
		  else if(i==1){var tempPrice = basePckg.price+" &euro;";newValue.innerHTML = tempPrice;}
	  	    else if(i==2){var tempDur = basePckg.dur+" days";newValue.innerHTML = tempDur;}
		      else{var tempDist = basePckg.dist+" Km"; newValue.innerHTML = tempDist;} 
	}	
	/*and change the button links*/
	var viewLink = document.querySelector(".basePckg .footer .view");
        var cartLink = document.querySelector(".basePckg .footer .cartIt");

	viewLink.href = "./destination.php?id="+baseID+"&ag="+basePckg.agID;
	cartLink.href = "./cart.php?id="+baseID+"&ag="+basePckg.agID;
	
	/*prepare input for modification, selecting all pckgFrames*/
	var pckgFrames = document.getElementsByClassName("pckgFrame");
        /*for every i of pckgs, j is modified*/
	var j = 0;
	for(var i = 0; i < pckgs.length;i++){
	if(pckgs[i].id != baseID){
		j++;
		reform(pckgs[i],pckgFrames[j],baseID,basePckg);

	/*if - ends*/
	}

	/* for pckgs loop-ends*/
	}
/*function evaluate ends here*/
}

function transformDate(date){
		var day = date.getDate();
		var month = date.getMonth();
		date.setDate(month+1);
		date.setMonth(day-1);
		
		return date;
}

function reform(pckg,pckgFrame,baseID,basePckg){


		var titleDets = pckgFrame.querySelector(".destsWrapper");
		while(titleDets.hasChildNodes()){titleDets.removeChild(titleDets.firstChild); }

		for(var index = 0; index < pckg.dests.length;index++){
			var newValue = document.createElement("div");
			newValue.setAttribute("class","value");
			newValue.innerHTML = pckg.dests[index];
			titleDets.appendChild(newValue);
		}
	
		var img = pckgFrame.querySelector("img");
		img.src = pckg.img;

		/*changle the compare buttons*/	
		var newButton = pckgFrame.querySelector(".footer button");
		newButton.innerHTML = "COMPARE THIS";	
		newButton.onclick = function(){reEvaluate(pckg.id);}

		var details = pckgFrame.querySelectorAll(".details");		

		for(var index = 0; index < details.length; index++){
			var newValue = details[index].querySelector(".value");
			var newComparator = details[index].querySelector(".comparator");

			if(index == 0){
				newValue.innerHTML = pckg.agency;
				newComparator.innerHTML = null;

			}else if(index == 1){
				newValue.innerHTML = pckg.price+" &euro;";
				        if(pckg.price > basePckg.price){ 
						newComparator.innerHTML = '<i class="fa fa-arrow-circle-up red"></i>';
					 }else if(pckg.price < basePckg.price){
						newComparator.innerHTML = '<i class="fa fa-arrow-circle-down green"></i>';
					 }else {
						newComparator.innerHTML = '<i class="fa fa-check-square green"></i>';
					 }

			}else if(index == 2){
				newValue.innerHTML = pckg.dur+" days";

					if(pckg.dur > basePckg.dur){
						newComparator.innerHTML = '<i class="fa fa-arrow-circle-up green"></i>';
					}
               			        else if(pckg.dur < basePckg.dur){
						newComparator.innerHTML = '<i class="fa fa-arrow-circle-down red"></i>';
					}
                       		        else{
						newComparator.innerHTML = '<i class="fa fa-check-square green"></i>';
					}


			}else{
				newValue.innerHTML = pckg.dist+" Km";
				
					if(pckg.dist > basePckg.dist){
						newComparator.innerHTML = '<i class="fa fa-arrow-circle-up green"></i>';
					 }
	               			 else if(pckg.dist < basePckg.dist){
						newComparator.innerHTML = '<i class="fa fa-arrow-circle-down red"></i>';
					 }
                       			 else{
						newComparator.innerHTML = '<i class="fa fa-check-square green"></i>';
					}


			}
		/*for details loop-ends*/

		}
}

function createDestTitleAppend(dests,div){
	
	var divDestsWrapper = document.createElement("div");
	divDestsWrapper.setAttribute("class","destsWrapper");
	
	
	for(var i=0;i<dests.length;i++){
		
		divValue = document.createElement("div");
		divValue.setAttribute("class","value");
		divValue.innerHTML = dests[i];
		divDestsWrapper.appendChild(divValue);
		
	
	}

	div.appendChild(divDestsWrapper);
}


function createDetailNappend(title,data,div,icon){   
  
   /*create the details elements and add them to the DOM*/
   var divDetails = document.createElement("div");
   divDetails.setAttribute("class","details");

   var divLabel = document.createElement("div");
   divLabel.setAttribute("class","label");
   divLabel.innerHTML = title;
   
   var divValue = document.createElement("div");
   divValue.setAttribute("class","value");
   divValue.innerHTML = data;
   
   var divComparator = document.createElement("div");
   divComparator.setAttribute("class","comparator");
   divComparator.innerHTML = icon;
   
   divDetails.appendChild(divLabel);
   divDetails.appendChild(divValue);
   divDetails.appendChild(divComparator);
   
   div.appendChild(divDetails);
   
}

function pckgs2cmp(id,agID,dist,dur,price,agency,img,dests){
	this.id = id;
	this.agID = agID;
	this.dist = dist;
	this.dur = dur;
	this.price = price;
	this.agency = agency;
	this.img = img;
	this.dests = dests;
	}

function dateDiff(date1,date2){
		
	var one_day=1000*60*60*24;
	
    
	
	var difference_ms = date2 - date1;
	
	return Math.round(difference_ms/one_day);
	
}

window.onload = init;
