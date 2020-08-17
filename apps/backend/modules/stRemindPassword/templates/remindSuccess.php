<div id="password_reminder_form">
	<div id="message">
		<?php if ($send): ?>
			<p class="message">
				<?php echo __('Na adres "%email%" zostało wysłane nowe hasło', array('%email%' => $user->getUsername())) ?>
			</p>
		<?php else: ?>
			<p class="message form-error-msg">
				<?php echo __('Nowe hasło nie zostało wysłane, ponieważ konto pocztowe sklepu nie jest skonfigurowane prawidłowo.') ?> 
			</p>
		<?php endif; ?>
	</div>
	<div class="submit">
		<a href="/backend.php"><button type="submit"><?php echo __('Zamknij', null, 'sfGuardUser') ?></button></a>
	</div>
</div>