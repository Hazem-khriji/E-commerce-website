(function() {
	'use strict';

	var tinyslider = function() {
		var el = document.querySelectorAll('.testimonial-slider');

		if (el.length > 0) {
			var slider = tns({
				container: '.testimonial-slider',
				items: 1,
				axis: "horizontal",
				controlsContainer: "#testimonial-nav",
				swipeAngle: false,
				speed: 700,
				nav: true,
				controls: true,
				autoplay: true,
				autoplayHoverPause: true,
				autoplayTimeout: 3500,
				autoplayButtonOutput: false
			});
		}
	};
	tinyslider();

	


	var sitePlusMinus = function() {

		var value,
    		quantity = document.getElementsByClassName('quantity-container');

		function createBindings(quantityContainer) {
	      var quantityAmount = quantityContainer.getElementsByClassName('quantity-amount')[0];
	      var increase = quantityContainer.getElementsByClassName('increase')[0];
	      var decrease = quantityContainer.getElementsByClassName('decrease')[0];
	      increase.addEventListener('click', function (e) { increaseValue(e, quantityAmount); });
	      decrease.addEventListener('click', function (e) { decreaseValue(e, quantityAmount); });
	    }

	    function init() {
	        for (var i = 0; i < quantity.length; i++ ) {
						createBindings(quantity[i]);
	        }
	    };

	    function increaseValue(event, quantityAmount) {
	        value = parseInt(quantityAmount.value, 10);

	        console.log(quantityAmount, quantityAmount.value);

	        value = isNaN(value) ? 0 : value;
	        value++;
	        quantityAmount.value = value;
	    }

	    function decreaseValue(event, quantityAmount) {
	        value = parseInt(quantityAmount.value, 10);

	        value = isNaN(value) ? 0 : value;
	        if (value > 0) value--;

	        quantityAmount.value = value;
	    }
	    
	    init();
		
	};
	sitePlusMinus();


})()



// shay hedha tebe3 chat bot 5at l be9i lkoll
// Chatbot Functionality
document.addEventListener('DOMContentLoaded', function() {
	const chatbotToggle = document.getElementById('chatbotToggle');
	const chatbotClose = document.getElementById('chatbotClose');
	const chatbotContainer = document.getElementById('chatbotContainer');
	const chatbotInput = document.getElementById('chatbotInput');
	const chatbotSend = document.getElementById('chatbotSend');
	const chatbotMessages = document.getElementById('chatbotMessages');
	const suggestionChips = document.querySelectorAll('.suggestion-chip');

	// Toggle chatbot visibility
	chatbotToggle.addEventListener('click', function() {
		chatbotContainer.classList.toggle('active');
	});

	// Close chatbot
	chatbotClose.addEventListener('click', function() {
		chatbotContainer.classList.remove('active');
	});

	// Function to add message to chat
	function addMessage(message, isUser = false) {
		const messageDiv = document.createElement('div');
		messageDiv.className = `message ${isUser ? 'user-message' : 'bot-message'}`;

		const messageContent = document.createElement('div');
		messageContent.className = 'message-content';
		messageContent.textContent = message;

		messageDiv.appendChild(messageContent);
		chatbotMessages.appendChild(messageDiv);

		// Scroll to bottom of messages
		chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
	}

	// Function to process user input and generate response
	function processMessage(message) {
		addMessage(message, true);

		// Simple response logic (can be expanded)
		let response = '';
		const messageLower = message.toLowerCase();

		if (messageLower.includes('classic living room')) {
			response = "For a classic living room, I recommend our Nordic Chair collection and our vintage coffee tables. They create an elegant, timeless ambiance.";
		} else if (messageLower.includes('ergonomic')) {
			response = "Our Ergonomic Chair series is perfect for home offices. They provide excellent lumbar support and are designed for all-day comfort.";
		} else if (messageLower.includes('sofa') || messageLower.includes('couch')) {
			response = "We have several sofa options! Our bestsellers include the Plush Comfort sofa and the Modern Sectional. Would you like to see our sofa collection?";
		} else if (messageLower.includes('dining') || messageLower.includes('food') || messageLower.includes('kitchen')) {
			response = "For dining furniture, I'd recommend our Oak Dining Set for classic styles, or our Modern Glass collection for contemporary spaces.";
		} else if (messageLower.includes('price') || messageLower.includes('cost') || messageLower.includes('how much')) {
			response = "Our furniture ranges from budget-friendly to premium options. Could you tell me which specific piece you're interested in?";
		} else if (messageLower.includes('delivery') || messageLower.includes('shipping')) {
			response = "We offer free delivery . Standard delivery takes 3-5 business days, and premium delivery with installation is also available.";
		} else if (messageLower.includes('return') || messageLower.includes('warranty')) {
			response = "We have a 30-day return policy and most of our furniture comes with a 2-year warranty. Some collections may have extended warranty options.";
		} else if (messageLower.includes('material') || messageLower.includes('wood')) {
			response = "We use ethically sourced materials including oak, walnut, pine, and sustainable engineered wood. Our upholstery options include premium leather, cotton, and stain-resistant synthetics.";
		} else if (messageLower.includes('hello') || messageLower.includes('hi') || messageLower.includes('hey')) {
			response = "Hello! How can I help you find the perfect furniture today?";
		}else if (messageLower.includes('yes') || messageLower.includes('yeah')){
			response = "One of our employees will reach out to you soon . please wait";
		}else if (messageLower.includes('no') || messageLower.includes('nope')){
			response = "Okay.Please take your time discovering our products .";
		} else {
			response = "Do you want one of for one of our employees to contact you for further information ? ";
		}

		// Add slight delay for more natural feeling
		setTimeout(() => {
			addMessage(response);
		}, 500);
	}

	// Send message on button click
	chatbotSend.addEventListener('click', function() {
		const message = chatbotInput.value.trim();
		if (message) {
			processMessage(message);
			chatbotInput.value = '';
		}
	});

	// Send message on Enter key
	chatbotInput.addEventListener('keypress', function(e) {
		if (e.key === 'Enter') {
			const message = chatbotInput.value.trim();
			if (message) {
				processMessage(message);
				chatbotInput.value = '';
			}
		}
	});

	// Handle suggestion chips
	suggestionChips.forEach(chip => {
		chip.addEventListener('click', function() {
			processMessage(chip.textContent);
		});
	});
});