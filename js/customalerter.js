let stylesmade = false;

function mekstyles() {
    let mystyles = `
    	/* alert holder */

		#alertContainer {
			position: fixed;
			bottom: 0;
			left: 0;
			width: 100%;
			height: auto;
			pointer-events: none;
			padding: 20px 30px 80px 30px;
			z-index: 4;
    		--c: #fff;
    		--altc: #000;
		}

		#alertContainer button {
			border:none;
		}

		.alert {
			position: relative;
			padding: 1.2em 2em;
			margin-bottom: 20px;
			color: var(--c);
			border-radius: var(--roundness);
			width: 100%;
			max-width: 400px;
    		font-weight: 700;
		}

		.alert.success{background-color: mediumseagreen;box-shadow: 0 0 12px mediumseagreen;}
		.alert.info{background-color: dodgerblue;box-shadow: 0 0 12px dodgerblue;}
		.alert.warning{background-color: rgb(255, 166, 0);box-shadow: 0 0 12px rgb(255, 166, 0);color:var(--altc)}
		.alert.danger,.alert.error{background-color: red;box-shadow: 0 0 12px red;}
		.alert.primary{background-color: var(--themecolor);box-shadow: 0 0 12px var(--themecolor);}
		.alert.secondary{background-color: var(--altbg);box-shadow: 0 0 12px var(--altbg);}
		.alert.light{background-color: var(--bs-light);box-shadow: 0 0 12px var(--bs-light);}
		.alert.dark{background-color: var(--bs-dark);box-shadow: 0 0 12px var(--bs-dark);}
		.alert b,.alert strong{
			display: inline-block;
			border-radius: calc(var(--roundness) / 2);
			background-color: var(--alttextcolor);
			padding: 2px 12px;
		}
    `;

    let st = document.createElement('style');
    st.innerHTML = mystyles;
    document.body.appendChild(st);

    let thecon = document.createElement('div');
    thecon.id = 'alertContainer';
    document.body.appendChild(thecon);

    stylesmade = true;

    console.log("made styles");
}

function showAlert(alertMessage = 'test message', alertTime = 5, alertType = 'info') {
    if(!stylesmade){
        mekstyles();
    }

	// Create alert container if it doesn't exist
	let alertContainer = document.getElementById('alertContainer');

	// Create alert element
	const alertElement = document.createElement('div');
	alertElement.className = `alert ${alertType} alert-dismissible fade show`;
	alertElement.role = 'alert';
	alertElement.innerHTML = `
		${alertMessage}
		<button type="button" class="closebtn w3-right w3-hide" data-bs-dismiss="alert" aria-label="Close">
			<i class="fa fa-close"></i>
		</button>
	`;

	// Append alert to container
	alertContainer.appendChild(alertElement);

	// animate coming in
	let animoptions = {
		duration: 300,
		easing: 'ease-out',
		fill: 'forwards'
	};
	let leaveAnim = [
		{opacity: 1},
		{opacity: 0}
	];
	alertElement.animate([
		{opacity: 0,translate: '0 20px'},
		{opacity: 1,translate: '0 0'}
	],animoptions);

	alertElement.querySelector('button').addEventListener('click',() => {
		alertElement.animate(leaveAnim,animoptions);
		setTimeout(() => alertElement.remove(), animoptions.duration + 50);
	})

	if(alertTime.toString().toLowerCase() != "infinity"){
		setTimeout(() => {
			if(alertElement != null){
				alertElement.animate(leaveAnim,animoptions);
				setTimeout(() => alertElement.remove(), animoptions.duration + 50); // Allow fade-out effect
			}
		}, alertTime * 1000);
	}
	console.log(`i will die in ${alertTime} seconds`);
}

window.addEventListener('keydown',(e) => {
	if(e.key.toLowerCase() == 'tab'){
		let mystring = mekRandomString(16);
		showAlert(`random string : ${mystring}`,7,'warning');
	}
})