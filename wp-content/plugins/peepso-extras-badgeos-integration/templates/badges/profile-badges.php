<div class="peepso">
	<div class="ps-page ps-page--badgeos">
		<?php PeepSoTemplate::exec_template('general','navbar'); ?>

		<div class="ps-badgeos">
			<?php PeepSoTemplate::exec_template('profile', 'focus', array('current'=>'badges')); ?>

			<div class="ps-badgeos__page">
				<?php echo $list_badges;?>
			</div>
		</div>
	</div>
</div>

<?php PeepSoTemplate::exec_template('activity', 'dialogs'); ?>
