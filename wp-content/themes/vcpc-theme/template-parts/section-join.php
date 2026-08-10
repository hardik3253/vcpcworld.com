<?php if ( ! defined( 'ABSPATH' ) ) exit; ?>
<section class="section section--join" id="join">
	<div class="section__inner">
		<p class="eyebrow" data-anim="fade-up"><?php echo esc_html( vcpc_field( 'join_heading', 'Join the Journey' ) ); ?></p>
		<p class="join__body" data-anim="fade-up">
			<?php echo esc_html( vcpc_field( 'join_body', 'Be among the first to experience VCPC. Receive exclusive updates, launch invitations and early access.' ) ); ?>
		</p>

		<form id="vcpc-join-form" class="join__form" data-anim="fade-up" novalidate>
			<!-- honeypot -->
			<input type="text" name="website" class="hp-field" tabindex="-1" autocomplete="off">

			<div class="join__row">
				<div class="field">
					<label for="first_name">First Name</label>
					<input type="text" id="first_name" name="first_name" required>
				</div>
				<div class="field">
					<label for="last_name">Last Name</label>
					<input type="text" id="last_name" name="last_name">
				</div>
			</div>

			<div class="join__row">
				<div class="field">
					<label for="email">Email</label>
					<input type="email" id="email" name="email" required>
				</div>
				<div class="field">
					<label for="mobile">Mobile Number</label>
					<input type="tel" id="mobile" name="mobile">
				</div>
			</div>

			<div class="join__row">
				<div class="field">
					<label for="country">Country</label>
					<input type="text" id="country" name="country">
				</div>
				<div class="field">
					<label for="audience">I am a</label>
					<select id="audience" name="audience">
						<option value="Consumer">Consumer</option>
						<option value="Hair Professional">Hair Professional</option>
						<option value="Salon Owner">Salon Owner</option>
						<option value="Distributor">Distributor</option>
						<option value="Media">Media</option>
					</select>
				</div>
			</div>

			<button type="submit" class="btn btn--primary join__submit">Join VCPC</button>
			<p class="join__status" id="join-status" role="status" aria-live="polite"></p>
		</form>
	</div>
</section>
