{{

var memberActions, followerActions;

data = data || {};
memberActions = data.member_actions || [];
followerActions = data.follower_actions || [];

_.each( memberActions.concat( followerActions ), function( item ) {
	if ( _.isArray( item.action ) ) {

}}

<span class="ps-dropdown ps-dropdown--left ps-dropdown--follow ps-js-dropdown">
	<a href="javascript:" class="ps-focus__cover-action ps-js-dropdown-toggle {{= item.class }}">
		<i class="{{= item.icon }}"></i>
		<span>{{= item.label }}</span>
		<img class="ps-loading" src="<?php echo PeepSo::get_asset('images/ajax-loader.gif') ?>" />
	</a>
	<div class="ps-dropdown__menu ps-js-dropdown-menu">
		{{ _.each( item.action, function( item ) { }}
		<a class="ps-dropdown__group ps-js-group-member-action"
				{{= item.action ? 'data-method="' + item.action + '"' : 'disabled="disabled"' }}
				data-confirm="{{= item.confirm }}"
				{{ if ( item.args ) _.each( item.args, function( value, key ) { }}
				data-{{= key }}="{{= value }}"
				{{ }); }}
		>
			<div class="ps-dropdown__group-title">
				<i class="{{= item.icon }}"></i>
				<span>{{= item.label }}</span>
			</div>
			<div class="ps-dropdown__group-desc">{{= item.desc }}</div>
		</a>
		{{ }); }}
	</div>
</span>

{{

	} else {

}}

<a href="javascript:" role="button" aria-label="{{= item.label }}" class="ps-focus__cover-action ps-js-group-member-action {{= item.class }}"
		{{= item.action ? 'data-method="' + item.action + '"' : 'disabled="disabled"' }}
		data-confirm="{{= item.confirm }}"
		{{ if ( item.args ) _.each( item.args, function( value, key ) { }}
		data-{{= key }}="{{= value }}"
		{{ }); }}
>
	<i class="{{= item.icon }}"></i>
	<span>{{= item.label }}</span>
	<img class="ps-loading" src="<?php echo PeepSo::get_asset('images/ajax-loader.gif') ?>" />
</a>

{{

	}
});

}}