
	
	function init(){

	/*find the clear list button to clear the side list*/				
	var clear = document.getElementById("clearButton");
	clear.onclick = clearList;
	loadPckglist();
	}
	


	
	function save(item,id){
		var index = "it_"+id;
		localStorage.setItem(index,JSON.stringify(item));	
	}
	
	function loadPckglist(){
		if(localStorage.length != 0) {
		
		for (var i=0; i < localStorage.length; i++){
			/*retreive the stored packages*/
			var key = localStorage.key(i);
			var value = localStorage.getItem(key);
			var parsedValue = JSON.parse(value);
			addToDOM(parsedValue);
			
			/*delete the selected package*/
			var toGo = document.getElementById("no"+parsedValue.id);
			toGo.parentNode.removeChild(toGo);
			}	
		
		}
	}
	function addToDOM(item){
		var div = document.createElement("div");
		div.setAttribute('class', 'packageFrame fr'+item.id);
		
		var divDestFrame = document.createElement("div");
		divDestFrame.setAttribute('class', 'destTitleFrame')
		
		var divAgency = document.createElement("div");
		divAgency.setAttribute('class', 'info');
		divAgency.innerHTML = item.agency;
		
		var img = document.createElement("img");
		img.src = item.pic;
		
		for(var i=0; i< item.dests.length;i++){
			var divDests = document.createElement("div");
			divDests.innerHTML = item.dests[i];
			divDests.setAttribute('class', 'destTitle');
			divDestFrame.appendChild(divDests);
			}
		
		div.appendChild(divAgency);
		div.appendChild(img);
		div.appendChild(divDestFrame);
		
			
		var list = document.getElementById("sideBarList");
		list.appendChild(div);
		
		
		}
	
	function addToList(id) {
		var lat = [];
		var long = [];
		/*create the frame of the package in the list*/
		var div = document.createElement("div");
		div.setAttribute('class', 'packageFrame fr'+id);
		
		/*retreive lat and long and agencyID and display:none them to store them in localStorage*/
		var latTemp = document.querySelectorAll("#no"+id+" .domTargetLat");
		var longTemp = document.querySelectorAll("#no"+id+" .domTargetLong");
		var agID = document.querySelectorAll("#no"+id+" .domTargetAgencyID");
		
		tempAgID = agID[0].innerHTML;
		
		for(var i=0;i<latTemp.length;i++){
			lat[i] = latTemp[i].innerHTML;
			long[i] = longTemp[i].innerHTML;
			}
		
		/*select the elements you need and put them in the frame*/
		var pckgImg = document.querySelector("#no"+id+" .pckgFrame img");
		var pckgAgency = document.querySelector("#no"+id+" #title"+id);
		var pckgAgencyTitle = document.querySelector("#no"+id+" #title"+id+" .title");
		pckgAgency.removeChild(pckgAgencyTitle);
		var pckgTitle = document.querySelector("#no"+id+" .destTitleFrame");
	
		/*add them to the DOM list*/
		div.appendChild(pckgAgency);
		div.appendChild(pckgImg);
		div.appendChild(pckgTitle);
		
		var list = document.getElementById("sideBarList");
		list.appendChild(div);
		
		/*create an object of this package*/
		var pckg = new Packages(id,lat,long,tempAgID);
		save(pckg,id);
		
		/*delete the selected package*/
		var toGo = document.getElementById("no"+id);
		toGo.parentNode.removeChild(toGo);
		
		
	}
	
	
	
	function clearList(){
		localStorage.clear("sideBarList");
		location.reload();
		
	}
	
	/*object definition*/
	function Packages(id,lat,long,agID){
		this.id = id;
		 
		this.agency = document.querySelector("#sideBarList #title"+id).innerHTML;
		this.pic = document.querySelector("#sideBarList .fr"+id+" img").src;
		this.dests = [];
		
		var elements = document.querySelectorAll("#sideBarList .fr"+id+" .destTitle");
		for(var i=0;i < elements.length;i++){
				this.dests[i] = elements[i].innerHTML;
			}
		var priceWrapper = document.querySelector("#no"+id+" #price"+id);
		var remove = document.querySelector("#no"+id+" #price"+id+" .title");
		priceWrapper.removeChild(remove);
		this.price = priceWrapper.innerHTML;
		
		var ldateWrapper = document.getElementById("ldate"+id);
		var ldateRem = document.querySelector("#ldate"+id+" .title");
		ldateWrapper.removeChild(ldateRem);
		this.ldate = ldateWrapper.innerHTML;
		
		var rdateWrapper = document.getElementById("rdate"+id);
		var rdateRem = document.querySelector("#rdate"+id+" .title");
		rdateWrapper.removeChild(rdateRem);
		this.rdate = rdateWrapper.innerHTML;
		
		this.lat = lat;
		this.long = long;
		this.agID = agID;
		
		
	} 
	
	window.onload = init;

