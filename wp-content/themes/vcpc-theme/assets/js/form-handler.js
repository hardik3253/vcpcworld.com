document.addEventListener( 'DOMContentLoaded', function() {
	'use strict';

	var form = document.getElementById('vcpc-journey-form');
	if (!form) return;

	var submitBtn = document.getElementById('vcpc-submit-btn');
	var btnText = submitBtn.querySelector('.btn-text');
	var btnSpinner = submitBtn.querySelector('.btn-spinner');
	var generalMsg = document.getElementById('form-general-msg');

	form.addEventListener('submit', function(e) {
		e.preventDefault();

		// Reset states & errors
		generalMsg.innerHTML = '';
		generalMsg.className = 'form-status-msg';
		document.querySelectorAll('.error-msg').forEach(function(el) {
			el.innerHTML = '';
		});

		// Build form payload dynamically from form elements
		var payload = {};
		var formData = new FormData(form);
		formData.forEach(function(value, key) {
			payload[key] = value;
		});

		// Disable submit & show spinner
		submitBtn.disabled = true;
		if (btnSpinner) btnSpinner.style.display = 'inline-block';
		if (btnText) btnText.style.opacity = '0.5';

		fetch(vcpcForm.endpoint, {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
				'X-WP-Nonce': vcpcForm.nonce
			},
			body: JSON.stringify(payload)
		})
		.then(function(response) {
			return response.json().then(function(data) {
				return { status: response.status, data: data };
			});
		})
		.then(function(res) {
			if (res.status === 200 && res.data.success) {
				generalMsg.className = 'form-status-msg success';
				generalMsg.innerHTML = res.data.message;
				form.reset();
			} else {
				generalMsg.className = 'form-status-msg error';
				if (res.data.errors) {
					// Field validation errors
					Object.keys(res.data.errors).forEach(function(key) {
						var errEl = document.getElementById('err-' + key);
						if (errEl) {
							errEl.innerHTML = res.data.errors[key];
						}
					});
					generalMsg.innerHTML = res.data.message || 'Please fix the errors in the fields above.';
				} else {
					generalMsg.innerHTML = res.data.message || 'An error occurred. Please try again.';
				}
			}
		})
		.catch(function(err) {
			generalMsg.className = 'form-status-msg error';
			generalMsg.innerHTML = 'Network error. Please try again later.';
		})
		.finally(function() {
			submitBtn.disabled = false;
			if (btnSpinner) btnSpinner.style.display = 'none';
			if (btnText) btnText.style.opacity = '1';
		});
	});
});
