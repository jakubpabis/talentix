<?php

/**
 * Smash Balloon Social Wall Item Template
 * Adds an image, link, and other data for each post in the feed
 *
 * @version 1.0 Social Wall by Smash Balloon
 *
 */

// Don't load directly
if (! defined('ABSPATH')) {
	die('-1');
}

$plugin = SW_Parse::get_plugin($post);
$item_classes = SW_Display_Elements::get_item_classes($settings, $post);

/* Style attributes */
$sb_item_style = SW_Display_Elements::get_sb_items_style($settings);
$sb_inner_item_style = SW_Display_Elements::get_sb_inner_item_style($settings);

/* Header and identity */
$post_id = SW_Parse::get_post_id($post, $plugin);

$item_permalink = SW_Parse::get_post_permalink($post, $plugin);
$sm_icon = SW_Display_Elements::get_icon($plugin);

$link_title = 'View more';

$platforms = [
	'instagram' => 'instagram',
	'twitter' => 'twitter',
	'x' => 'x.com',
	'facebook' => 'facebook',
	'tiktok' => 'tiktok',
	'youtube' => 'youtube',
];

foreach ($platforms as $platform => $domain) {
	if (strpos($item_permalink, $domain) !== false) {
		$link_title = 'View more on ' .  ucfirst($platform);
	}
}

/* Media and light box */
$available_images_attribute = SW_Display_Elements::get_available_images_attribute($account_data, $post, $plugin, $misc_data);

$media_type = SW_Parse::get_media_type($post, $plugin);
$maybe_play_button_html = SW_Display_Elements::maybe_play_button_html($media_type);
$media_html = SW_Display_Elements::get_media_html($post, $settings, $plugin);
$post_elements = isset($settings['postElements']) ? $settings['postElements'] : array();
/* Text and bottom content */
$escaped_post_bottom_content = SW_Display_Elements::get_escaped_bottom_content($post, $plugin, $settings);

/* Stats and Share */
$footer_class = empty($media_html) ? ' sbsw-no-media' : '';
$escaped_stats_html = SW_Display_Elements::get_escaped_stats_html($account_data, $post, $misc_data, $plugin, $settings);
$escaped_share_html = SW_Display_Elements::get_escaped_share_content($account_data, $post, $plugin);
?>
<div class="sbsw-item sbsw-<?php echo esc_attr($plugin); ?>-item<?php echo esc_attr($item_classes); ?>" id="sbsw-<?php echo esc_attr($post_id); ?>" <?php echo $sb_item_style; ?>>

	<div class="sbsw-item-inner card shadow-sm rounded-2" <?php echo $sb_inner_item_style; ?>>

		<div class="card-body bg-white">

			<?php if (! empty($media_html) && in_array('media', $post_elements)) : ?>
				<a href="<?php echo esc_url($item_permalink); ?>" target="_blank">
					<div class="sbsw-item-media" <?php echo $available_images_attribute; ?>>
						<?php echo $maybe_play_button_html; ?>
						<?php echo $media_html; ?>
					</div>
				</a>
			<?php endif; ?>

			<?php if (! empty($escaped_post_bottom_content) && in_array('text', $post_elements)) : ?>
				<div class="sbsw-item-bottom-content pb-4">
					<a href="<?php echo esc_url($item_permalink); ?>" class="fw-bold pt-4 d-block" target="_blank"><?php echo $link_title; ?></a>
					<hr />
					<?php if (in_array('summary', $post_elements)) : ?>
						<div class="sbsw-item-stats">
							<?php echo $escaped_stats_html; ?>
						</div>
					<?php endif; ?>
					<?php echo $escaped_post_bottom_content; ?>
				</div>
			<?php endif; ?>

		</div>

	</div>

</div>
