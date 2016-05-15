<?php
/**
  *
 * @package Accesspress Store
 */
?>
<form method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>" role="search">
	<input type="text" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" class="search-field" placeholder="<?php __('Search...','eightstore-lite') ?>" />
	<div class="search-in-select">
		<span class="search-in"><?php _e('in','eightstore-lite') ?></span>
		<select name="post_type" class="select-search-type">
			<option value=""><?php echo __('All','eightstore-lite');?></option>
			<option value="product"><?php echo __('Product','eightstore-lite');?></option>
			<option value="post"><?php echo __('Post','eightstore-lite');?></option>
		</select>
	</div>
	<button type="submit" class="searchsubmit"><i class="fa fa-search"></i></button>
</form>
