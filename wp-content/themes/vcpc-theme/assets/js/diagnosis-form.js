document.addEventListener('DOMContentLoaded', function () {
	'use strict';

	var form = document.getElementById('vcpc-diagnosis-form');
	if (!form) return;

	var steps = Array.prototype.slice.call(form.querySelectorAll('.vcpc-diagnosis__step'));
	var progressSteps = Array.prototype.slice.call(document.querySelectorAll('.vcpc-diagnosis__progress-step'));
	var currentStep = 0;
	var submissionState = false;

	function setStep(index) {
		currentStep = Math.max(0, Math.min(index, steps.length - 1));
		steps.forEach(function (step, i) {
			step.classList.toggle('is-active', i === currentStep);
		});
		progressSteps.forEach(function (step, i) {
			step.classList.toggle('is-active', i === currentStep);
			step.classList.toggle('is-complete', i < currentStep);
		});
	}

	function getSelectedValues(groupName) {
		var selected = [];
		var optionButtons = document.querySelectorAll('[data-group="' + groupName + '"]');
		optionButtons.forEach(function (button) {
			if (button.classList.contains('is-selected')) {
				selected.push(button.dataset.value);
			}
		});
		return selected;
	}

	function updateHiddenField(groupName) {
		var hiddenField = form.querySelector('[data-hidden-group="' + groupName + '"]');
		if (!hiddenField) return;
		hiddenField.value = getSelectedValues(groupName).join(', ');
	}

	function validateStep(stepIndex) {
		var activeStep = steps[stepIndex];
		var errors = activeStep.querySelectorAll('.vcpc-diagnosis__error');
		errors.forEach(function (error) {
			error.textContent = '';
		});

		if (stepIndex === 0) {
			var requiredFields = activeStep.querySelectorAll('input[required]');
			var valid = true;
			requiredFields.forEach(function (field) {
				var value = field.value.trim();
				if (!value) {
					var error = activeStep.querySelector('[data-error-for="' + field.name + '"]');
					if (error) error.textContent = 'This field is required.';
					valid = false;
					return;
				}
				if (field.type === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
					var emailError = activeStep.querySelector('[data-error-for="' + field.name + '"]');
					if (emailError) emailError.textContent = 'Please enter a valid email address.';
					valid = false;
				}
				if (field.type === 'tel' && !/^[0-9+()\-\s]{7,}$/.test(value)) {
					var phoneError = activeStep.querySelector('[data-error-for="' + field.name + '"]');
					if (phoneError) phoneError.textContent = 'Please enter a valid phone number.';
					valid = false;
				}
			});
			return valid;
		}

		if (stepIndex >= 1 && stepIndex <= 3) {
			var groupName = stepIndex === 1 ? 'hairCondition' : stepIndex === 2 ? 'hairStressors' : 'hairNeeds';
			var selected = getSelectedValues(groupName);
			var error = activeStep.querySelector('[data-error-for="' + groupName + '"]');
			if (selected.length === 0) {
				if (error) error.textContent = 'Please select at least one option.';
				return false;
			}
			updateHiddenField(groupName);
			return true;
		}

		return true;
	}

	function updateSummary() {
		var tags = document.getElementById('diagnosis-summary-tags');
		if (!tags) return;

		var allGroups = ['hairCondition', 'hairStressors', 'hairNeeds'];
		var values = [];
		allGroups.forEach(function (groupName) {
			var selected = getSelectedValues(groupName);
			selected.forEach(function (value) {
				if (value && values.indexOf(value) === -1) {
					values.push(value);
				}
			});
		});

		tags.innerHTML = '';
		values.forEach(function (value) {
			var chip = document.createElement('span');
			chip.className = 'vcpc-diagnosis__summary-tag';
			chip.textContent = value;
			tags.appendChild(chip);
		});

		var professionalEl = document.getElementById('diagnosis-professional-treatment');
		var homecareEl = document.getElementById('diagnosis-homecare');
		if (professionalEl) {
			professionalEl.textContent = values.length ? 'Targeted treatment plan prepared around: ' + values.join(', ') : 'Targeted protocol will be prepared by a VCPC professional after review.';
		}
		if (homecareEl) {
			homecareEl.textContent = values.length ? 'Personalized homecare guidance focused on ' + values.join(', ') + '.' : 'Supportive at-home care guided by your diagnosed needs and stressors.';
		}
	}

	function bindOptionToggle() {
		document.querySelectorAll('.vcpc-diagnosis__option').forEach(function (button) {
			button.addEventListener('click', function () {
				var groupName = button.dataset.group;
				button.classList.toggle('is-selected');
				if (button.classList.contains('is-selected')) {
					button.setAttribute('aria-pressed', 'true');
				} else {
					button.setAttribute('aria-pressed', 'false');
				}
				updateHiddenField(groupName);
				updateSummary();
			});
		});
	}

	form.addEventListener('submit', function (event) {
		event.preventDefault();
		if (submissionState) return;
		submissionState = true;

		var payload = {
			client: {},
			hairCondition: [],
			hairStressors: [],
			hairNeeds: [],
			protocol: {
				professionalTreatment: document.getElementById('diagnosis-professional-treatment') ? document.getElementById('diagnosis-professional-treatment').textContent : '',
				homecare: document.getElementById('diagnosis-homecare') ? document.getElementById('diagnosis-homecare').textContent : ''
			}
		};

		Array.prototype.forEach.call(form.querySelectorAll('input, textarea, select'), function (field) {
			if (!field.name || field.type === 'button' || field.type === 'submit') return;
			if (field.name === 'hairCondition' || field.name === 'hairStressors' || field.name === 'hairNeeds') {
				var values = field.value ? field.value.split(',').map(function (item) { return item.trim(); }).filter(Boolean) : [];
				payload[field.name] = values;
				return;
			}
			payload.client[field.name] = field.value.trim();
		});

		var submitButton = form.querySelector('[data-submit]');
		if (submitButton) {
			submitButton.disabled = true;
			submitButton.textContent = 'Submitting...';
		}

		fetch(vcpcDiagnosis.endpoint, {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
				'X-WP-Nonce': vcpcDiagnosis.nonce
			},
			body: JSON.stringify(payload)
		}).then(function (response) {
			return response.json().then(function (data) {
				return { response: response, data: data };
			});
		}).then(function (result) {
			if (result.response.ok && result.data.success) {
				var successState = form.querySelector('.vcpc-diagnosis__success');
				if (successState) {
					successState.classList.add('is-visible');
					form.classList.add('is-success');
				}
				steps.forEach(function (step) {
					step.classList.remove('is-active');
				});
				var submitButton = form.querySelector('[data-submit]');
				if (submitButton) submitButton.style.display = 'none';
			} else {
				alert(result.data.message || 'Please review your diagnosis and try again.');
			}
		}).catch(function () {
			alert('Something went wrong while submitting your diagnosis. Please try again.');
		}).finally(function () {
			if (form.querySelector('[data-submit]')) {
				form.querySelector('[data-submit]').disabled = false;
				form.querySelector('[data-submit]').textContent = 'Submit My Diagnosis';
			}
			submissionState = false;
		});
	});

	form.querySelectorAll('[data-next-step]').forEach(function (button) {
		button.addEventListener('click', function () {
			var stepIndex = Number(button.closest('.vcpc-diagnosis__step').dataset.step) - 1;
			if (validateStep(stepIndex)) {
				setStep(stepIndex + 1);
			}
		});
	});

	form.querySelectorAll('[data-prev-step]').forEach(function (button) {
		button.addEventListener('click', function () {
			var stepIndex = Number(button.closest('.vcpc-diagnosis__step').dataset.step) - 1;
			setStep(stepIndex - 1);
		});
	});

	form.querySelectorAll('input[required]').forEach(function (field) {
		field.addEventListener('blur', function () {
			if (!field.value.trim()) {
				var error = form.querySelector('[data-error-for="' + field.name + '"]');
				if (error) error.textContent = 'This field is required.';
				return;
			}
			if (field.type === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(field.value.trim())) {
				var emailError = form.querySelector('[data-error-for="' + field.name + '"]');
				if (emailError) emailError.textContent = 'Please enter a valid email address.';
			}
		});
	});

	bindOptionToggle();
	setStep(0);
	updateSummary();
});
