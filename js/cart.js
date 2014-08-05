var startingPrices = [];
var total;
var previousMult = [];

function reCalc(id){
	/*find the chosen select element and recalculate the price*/
	var select = document.querySelector("#No"+id+" .orderDets select");
	var num = select.options[select.selectedIndex].value;
	
	var initialPrice = document.querySelector("#No"+id+" .subTotal");
	
	var newPriceNo = num*startingPrices[id];
	
	/*check the quantity multiplier and recalculate the total price*/
	if(previousMult[id] > num){
		sub = (previousMult[id]-num)*startingPrices[id];
		total -= sub;
	}else if(previousMult[id] < num){
		plus = (num - previousMult[id])*startingPrices[id];
		total += plus;
	}
	previousMult[id] = num;
	/*show the total price*/
	var initialTotal = document.querySelector(".totalPrice .value");
	initialTotal.innerHTML = total+' &euro;';
	
	initialPrice.innerHTML = '<div class="label">Subtotal:</div>'+newPriceNo+' &euro;';	
	
	}

	
	
function init() {
		total = 0;
	var index, initialPrice, label, length, priceNo, initialTotal;
	var indexIDS = document.querySelectorAll(".packageFrame");
	
	/*for every package, find the id from the id css attribute, parse the price element and store it to the array*/
	for(var i=0;i<indexIDS.length;i++){
		index = indexIDS[i].id.substr(-2, 2);
		
		initialPrice = document.querySelector("#No"+index+" .subTotal");
		label = document.querySelector("#No"+index+" .subTotal .label");
		initialPrice.removeChild(label);
		
		length = initialPrice.innerHTML.length;
		priceNo = initialPrice.innerHTML.substr(0,length-2);
		startingPrices[index] = priceNo;
		
		total += parseInt(priceNo);
		previousMult[index] = 1;
		/*re-build initial html*/
		initialPrice.innerHTML = '<div class="label">Subtotal:</div>'+priceNo+' &euro;';
		
		}
	/*show the total price*/
	var initialTotal = document.querySelector(".totalPrice .value");
	initialTotal.innerHTML = total+' &euro;';
	
	}

window.onload = init;
