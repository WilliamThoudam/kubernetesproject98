<?php

class PeepSoVipIconAdmin
{
	public static function administration()
	{
		self::enqueue_scripts();

		$PeepSoVipIconsModel = new PeepSoVipIconsModel();

		PeepSoTemplate::exec_template('peepsovip','admin_vipicons', $PeepSoVipIconsModel->vipicons);
	}

	public static function enqueue_scripts()
	{
		wp_register_script('peepso-admin-vip',
			PeepSo::get_asset('js/admin.js', dirname(dirname(__FILE__))),
			array('jquery', 'jquery-ui-sortable', 'underscore', 'peepso'), PeepSo::PLUGIN_VERSION, TRUE);

		wp_register_script('peepso-admin-vip', PeepSo::get_asset('js/admin-profiles.min.js'),
			array('jquery', 'jquery-ui-sortable', 'underscore', 'peepso'), PeepSo::PLUGIN_VERSION, TRUE);

		wp_enqueue_script('peepso-admin-vip');

		wp_enqueue_style('peepso-vip-admin',
			PeepSo::get_asset('css/admin.css', dirname(dirname(__FILE__))),
			array(), PeepSo::PLUGIN_VERSION);
	}
}
