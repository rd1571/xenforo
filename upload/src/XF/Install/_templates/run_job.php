<?php
	class_exists('XF\Install\App', false) || die('Invalid');

	$templater->setTitle('Processing...');
?>

<form action="<?php echo htmlspecialchars($submitUrl); ?>" method="post" class="blockMessage" data-xf-init="auto-submit">

	<div><?php echo (!empty($status) ? htmlspecialchars($status) : 'Processing...'); ?></div>

	<div class="u-noJsOnly">
		<button accesskey="s" class="button">Proceed...</button>
	</div>

	<?php echo $templater->fn('redirect_input', [$redirect, null, false]); ?>
	<?php echo $templater->fn('csrf_input'); ?>

	<input type="hidden" name="execute" value="1" />
</form>