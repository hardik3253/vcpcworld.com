<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>

<section class="vcpc-diagnosis" id="vcpc-diagnosis">
	<div class="vcpc-diagnosis__shell">
		<div class="vcpc-diagnosis__header">
			<div class="vcpc-diagnosis__logo">VCPC</div>
			<p class="vcpc-diagnosis__eyebrow">Hair Protection Diagnosis</p>
			<h2>VCPC Hair Protection Diagnosis</h2>
			<p class="vcpc-diagnosis__subhead">Let's understand your hair and identify what it needs.</p>
			<p class="vcpc-diagnosis__meta">Complete this quick assessment to help us create your personalized VCPC protocol.</p>
			<div class="vcpc-diagnosis__time">2–3 minutes</div>
		</div>

		<div class="vcpc-diagnosis__progress" aria-label="Diagnosis progress">
			<div class="vcpc-diagnosis__progress-step is-active"><span>01</span><small>Profile</small></div>
			<div class="vcpc-diagnosis__progress-step"><span>02</span><small>Hair Condition</small></div>
			<div class="vcpc-diagnosis__progress-step"><span>03</span><small>Hair Stressors</small></div>
			<div class="vcpc-diagnosis__progress-step"><span>04</span><small>Hair Needs</small></div>
			<div class="vcpc-diagnosis__progress-step"><span>05</span><small>Protocol</small></div>
		</div>

		<form id="vcpc-diagnosis-form" class="vcpc-diagnosis__form" novalidate>
			<div class="vcpc-diagnosis__step is-active" data-step="1">
				<div class="vcpc-diagnosis__content-top">
					<h3>Let's start with you</h3>
					<p>Tell us a little about yourself so we can personalize your diagnosis.</p>
				</div>
				<div class="vcpc-diagnosis__grid">
					<div class="vcpc-diagnosis__field">
						<label for="vcpc-diagnosis-name">Full Name <span>*</span></label>
						<input id="vcpc-diagnosis-name" name="name" type="text" required />
						<span class="vcpc-diagnosis__error" data-error-for="name"></span>
					</div>
					<div class="vcpc-diagnosis__field">
						<label for="vcpc-diagnosis-phone">Contact Number <span>*</span></label>
						<input id="vcpc-diagnosis-phone" name="contactNumber" type="tel" required />
						<span class="vcpc-diagnosis__error" data-error-for="contactNumber"></span>
					</div>
					<div class="vcpc-diagnosis__field">
						<label for="vcpc-diagnosis-email">Email Address <span>*</span></label>
						<input id="vcpc-diagnosis-email" name="email" type="email" required />
						<span class="vcpc-diagnosis__error" data-error-for="email"></span>
					</div>
					<div class="vcpc-diagnosis__field">
						<label for="vcpc-diagnosis-instagram">Instagram Handle</label>
						<input id="vcpc-diagnosis-instagram" name="instagram" type="text" />
					</div>
					<div class="vcpc-diagnosis__field">
						<label for="vcpc-diagnosis-city">City <span>*</span></label>
						<input id="vcpc-diagnosis-city" name="city" type="text" required />
						<span class="vcpc-diagnosis__error" data-error-for="city"></span>
					</div>
				</div>
				<div class="vcpc-diagnosis__actions">
					<button type="button" class="btn btn--primary vcpc-diagnosis__next" data-next-step>Continue →</button>
				</div>
			</div>

			<div class="vcpc-diagnosis__step" data-step="2">
				<div class="vcpc-diagnosis__content-top">
					<h3>What is happening to your hair?</h3>
					<p>Select all that apply.</p>
				</div>
				<div class="vcpc-diagnosis__option-grid" data-group="hairCondition">
					<button type="button" class="vcpc-diagnosis__option" data-group="hairCondition" data-value="Dry">Dry</button>
					<button type="button" class="vcpc-diagnosis__option" data-group="hairCondition" data-value="Damaged">Damaged</button>
					<button type="button" class="vcpc-diagnosis__option" data-group="hairCondition" data-value="Coloured">Coloured</button>
					<button type="button" class="vcpc-diagnosis__option" data-group="hairCondition" data-value="Weak">Weak</button>
					<button type="button" class="vcpc-diagnosis__option" data-group="hairCondition" data-value="Frizzy">Frizzy</button>
					<button type="button" class="vcpc-diagnosis__option" data-group="hairCondition" data-value="Fine">Fine</button>
					<button type="button" class="vcpc-diagnosis__option" data-group="hairCondition" data-value="Dull">Dull</button>
					<button type="button" class="vcpc-diagnosis__option" data-group="hairCondition" data-value="Chemically treated">Chemically treated</button>
				</div>
				<input type="hidden" name="hairCondition" data-hidden-group="hairCondition" value="" />
				<span class="vcpc-diagnosis__error vcpc-diagnosis__error--selection" data-error-for="hairCondition"></span>
				<div class="vcpc-diagnosis__actions two-actions">
					<button type="button" class="btn btn--outline vcpc-diagnosis__back" data-prev-step>← Back</button>
					<button type="button" class="btn btn--primary vcpc-diagnosis__next" data-next-step>Continue →</button>
				</div>
			</div>

			<div class="vcpc-diagnosis__step" data-step="3">
				<div class="vcpc-diagnosis__content-top">
					<h3>What is causing it?</h3>
					<p>Select the factors that may be affecting your hair.</p>
				</div>
				<div class="vcpc-diagnosis__option-grid" data-group="hairStressors">
					<button type="button" class="vcpc-diagnosis__option" data-group="hairStressors" data-value="Colour">Colour</button>
					<button type="button" class="vcpc-diagnosis__option" data-group="hairStressors" data-value="Bleach">Bleach</button>
					<button type="button" class="vcpc-diagnosis__option" data-group="hairStressors" data-value="Heat">Heat</button>
					<button type="button" class="vcpc-diagnosis__option" data-group="hairStressors" data-value="Chemical service">Chemical service</button>
					<button type="button" class="vcpc-diagnosis__option" data-group="hairStressors" data-value="Environment">Environment</button>
					<button type="button" class="vcpc-diagnosis__option" data-group="hairStressors" data-value="Mechanical stress">Mechanical stress</button>
					<button type="button" class="vcpc-diagnosis__option" data-group="hairStressors" data-value="Lifestyle">Lifestyle</button>
				</div>
				<input type="hidden" name="hairStressors" data-hidden-group="hairStressors" value="" />
				<span class="vcpc-diagnosis__error vcpc-diagnosis__error--selection" data-error-for="hairStressors"></span>
				<div class="vcpc-diagnosis__actions two-actions">
					<button type="button" class="btn btn--outline vcpc-diagnosis__back" data-prev-step>← Back</button>
					<button type="button" class="btn btn--primary vcpc-diagnosis__next" data-next-step>Continue →</button>
				</div>
			</div>

			<div class="vcpc-diagnosis__step" data-step="4">
				<div class="vcpc-diagnosis__content-top">
					<h3>What does your hair need?</h3>
					<p>Select what you feel your hair needs most.</p>
				</div>
				<div class="vcpc-diagnosis__option-grid" data-group="hairNeeds">
					<button type="button" class="vcpc-diagnosis__option" data-group="hairNeeds" data-value="Hydration">Hydration</button>
					<button type="button" class="vcpc-diagnosis__option" data-group="hairNeeds" data-value="Strength">Strength</button>
					<button type="button" class="vcpc-diagnosis__option" data-group="hairNeeds" data-value="Colour protection">Colour protection</button>
					<button type="button" class="vcpc-diagnosis__option" data-group="hairNeeds" data-value="Manageability">Manageability</button>
					<button type="button" class="vcpc-diagnosis__option" data-group="hairNeeds" data-value="Repair">Repair</button>
					<button type="button" class="vcpc-diagnosis__option" data-group="hairNeeds" data-value="Protection">Protection</button>
				</div>
				<input type="hidden" name="hairNeeds" data-hidden-group="hairNeeds" value="" />
				<span class="vcpc-diagnosis__error vcpc-diagnosis__error--selection" data-error-for="hairNeeds"></span>
				<div class="vcpc-diagnosis__actions two-actions">
					<button type="button" class="btn btn--outline vcpc-diagnosis__back" data-prev-step>← Back</button>
					<button type="button" class="btn btn--primary vcpc-diagnosis__next" data-next-step>Continue →</button>
				</div>
			</div>

			<div class="vcpc-diagnosis__step" data-step="5">
				<div class="vcpc-diagnosis__content-top">
					<h3>Your VCPC Protocol</h3>
					<p>Based on your hair diagnosis, your recommended VCPC protocol is:</p>
				</div>
				<div class="vcpc-diagnosis__protocol-wrap">
					<div class="vcpc-diagnosis__protocol-card">
						<h4>Professional Treatment</h4>
						<div id="diagnosis-professional-treatment" class="vcpc-diagnosis__protocol-copy">Targeted protocol will be prepared by a VCPC professional after review.</div>
					</div>
					<div class="vcpc-diagnosis__protocol-card">
						<h4>Homecare</h4>
						<div id="diagnosis-homecare" class="vcpc-diagnosis__protocol-copy">Supportive at-home care guided by your diagnosed needs and stressors.</div>
					</div>
					<div class="vcpc-diagnosis__protocol-card vcpc-diagnosis__protocol-card--focus">
						<h4>Your Hair Protection Focus</h4>
						<div id="diagnosis-summary-tags" class="vcpc-diagnosis__summary-tags"></div>
					</div>
				</div>
				<div class="vcpc-diagnosis__actions two-actions">
					<button type="button" class="btn btn--outline vcpc-diagnosis__back" data-prev-step>← Back</button>
					<button type="submit" class="btn btn--primary vcpc-diagnosis__submit" data-submit>Submit My Diagnosis</button>
				</div>
			</div>

			<div class="vcpc-diagnosis__success" aria-live="polite">
				<h3>Thank you.</h3>
				<p>Your hair diagnosis has been received.</p>
				<p>We'll review your responses and prepare your personalized VCPC protocol.</p>
			</div>
		</form>
	</div>
</section>
