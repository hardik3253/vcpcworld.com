(function () {
	'use strict';

	var form = document.getElementById( 'vcpc-join-form' );
	if ( ! form ) return;

	var statusEl = document.getElementById( 'join-status' );
	var submitBtn = form.querySelector( '.join__submit' );

	function setStatus( message, type ) {
		statusEl.textContent = message;
		statusEl.className = 'join__status' + ( type ? ' is-' + type : '' );
	}

	form.addEventListener( 'submit', function ( e ) {
		e.preventDefault();
		setStatus( '', '' );

		var data = {
			first_name: form.first_name.value.trim(),
			last_name:  form.last_name.value.trim(),
			email:      form.email.value.trim(),
			mobile:     form.mobile.value.trim(),
			country:    form.country.value.trim(),
			audience:   form.audience.value,
			website:    form.website.value, // honeypot, should stay empty
		};

		if ( ! data.first_name || ! data.email ) {
			setStatus( 'Please fill in your name and email.', 'error' );
			return;
		}

		submitBtn.disabled = true;
		submitBtn.textContent = 'Submitting…';

		fetch( vcpcForm.endpoint, {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
				'X-WP-Nonce': vcpcForm.nonce,
			},
			body: JSON.stringify( data ),
		} )
			.then( function ( res ) { return res.json(); } )
			.then( function ( result ) {
				if ( result.success ) {
					setStatus( result.message || 'Thank you — you\'re on the list.', 'success' );
					form.reset();
				} else {
					setStatus( result.message || 'Something went wrong. Please try again.', 'error' );
				}
			} )
			.catch( function () {
				setStatus( 'Network error. Please try again.', 'error' );
			} )
			.finally( function () {
				submitBtn.disabled = false;
				submitBtn.textContent = 'Join VCPC';
			} );
	} );
})();
