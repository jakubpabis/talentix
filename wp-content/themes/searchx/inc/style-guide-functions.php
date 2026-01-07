<?php

function style_guide_site_icon() {
	$url = get_site_icon_url();
	$id = attachment_url_to_postid( $url );
	acf_single_image( $id );
}

function style_guide_description( string $component ) {
	$json = component_json( $component, true );

	$styleGuide = $json->blennder->styleGuide ?? null;
	if( ! $styleGuide ) {
		$styleGuide = (object) [
			'description' => ''
		];
	}

	$description = $styleGuide->description ?: component_description( $component );
	if( empty( $description ) ) {
		$description = style_guide_lorem_ipsum( 20 );
	}
	return $description;
}

function style_guide_random_form( int $form_id = 0 ) {
	if( 0 === $form_id ) {
		$forms = GFAPI::get_forms();
		$form_id = $forms[ random_int( 0, count( $forms ) - 1 ) ];
	}
	return GFAPI::get_form( $form_id );
}

function style_guide_random_image( int $img_id = 0 ) {
	$image_ids = get_posts( [
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'post_status'    => 'inherit',
		'posts_per_page' => 500,
	] );
	if( 0 === $img_id ) {
		$img_id = random_int( 0, count( $image_ids ) - 1 );
	}
	return $image_ids[ $img_id ];
}

function style_guide_random_image_url( int $img_id = 0, string $size = 'full' ) {
	$id = style_guide_random_image( $img_id );
	$img_atts = wp_get_attachment_image_src( $id->ID , $size );
	return $img_atts[0];
}

function style_guide_repeater_content( int $number, string $repeater_key, array $subfields ) {
	$value = [ $repeater_key => [] ];
	for( $i = 0; $i < $number; $i++ ){
		$value[ $repeater_key ][] = $subfields;
	}
	return $value;
}

function style_guide_custom_content( string $component ) : array {

	switch( $component ) {
		case 'accordions':
			return style_guide_repeater_content( 4, 'accordion_items', [
				'accordion_item_title' => style_guide_lorem_ipsum( 16 ),
				'accordion_item_content' => style_guide_lorem_ipsum( 20 ),
			] );
		case 'blurbs':
			return style_guide_repeater_content( 3, 'blurbs', [
				'blurb_image_icon' => style_guide_random_image_url(),
				'blurb_title' => style_guide_lorem_ipsum( 2 ),
				'blurb_content' => style_guide_lorem_ipsum( 20 ),
				'blurb_button' => [
					'url' => '#',
					'title' => 'Button'
				],
			]);
		case 'cards':
			return style_guide_repeater_content( 6, 'cards', [
				'card_sub_header' => style_guide_lorem_ipsum( 2 ),
				'card_header' => style_guide_lorem_ipsum( 2 ),
				'card_image' => style_guide_random_image_url(),
				'card_content' => style_guide_lorem_ipsum( 20 ),
				'card_link' => [
					'url' => '#',
					'title' => 'Button'
				]
			]);
		case 'counters':
			return style_guide_repeater_content( 3, 'counters', [
				'counter_number' => '100',
				'counter_suffix' => '+',
				'counter_image' => style_guide_random_image_url(),
				'counter_title' => style_guide_lorem_ipsum( 2 ),
				'counter_start_val' => 00,
				'counter_link' => [
					'url' => '#',
					'title' => 'Button'
				],
			]);
		case 'cta':
			return [
				'component_color_theme' => 'dark',
				'background_type' => 'image',
				'background_image' => style_guide_random_image_url(),
				'cta_form' => style_guide_random_form(),
			];
		case 'hero':
			return [
				'background_type' => 'image',
				'background_image' => style_guide_random_image_url(),
			];
		case 'image-gallery':
			$image_gallery_item_content = [];
			for( $i = 0; $i < 6; $i++ ){
				$img = style_guide_random_image();
				$image_gallery_item_content[] = [ 'ID' => $img->ID, 'id' => $img->ID ];
			};
			return [
				'image_gallery' => $image_gallery_item_content,
			];
		case 'logos':
			return style_guide_repeater_content( 6, 'logos', [
				'logo_image' => style_guide_random_image_url(),
				'logo_link' => [
					'url' => '#',
					'title' => 'Button'
				],
			]);
		case 'slider':
			return style_guide_repeater_content( 6, 'slides', [
				'slide_preheader' => style_guide_lorem_ipsum( 2 ),
				'slide_header' => style_guide_lorem_ipsum( 2 ),
				'slide_content' => style_guide_lorem_ipsum( 20 ),
				'slide_image' => style_guide_random_image_url(),
				'slide_button' => [
					'url' => '#',
					'title' => 'Button'
				]
			]);
		case 'tabs':
			return style_guide_repeater_content( 3, 'tabs', [
				'tab_label' => style_guide_lorem_ipsum( 2 ),
				'panel_title' => style_guide_lorem_ipsum( 2 ),
				'panel_content' => style_guide_lorem_ipsum( 20 ),
				'panel_link' => [
					'url' => '#',
					'title' => 'Link'
				],
			]);
		case 'text-media':
			return [
				'text_media_media_type' => 'image',
				'text_media_image' => style_guide_random_image_url(),
			];
		case 'video-player':
			return [
				'source' => 'embed',
				'video_player_poster' => style_guide_random_image_url(),
				'embed' => 'https://www.youtube.com/embed/NpEaa2P7qZI?feature=oembed',
			];
	}
	return [];
}

function style_guide_lorem_ipsum( int $num_words = 55 ) : string {
	$lorem_ipsum = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec enim lectus, fermentum consequat sem eu, pulvinar varius augue. Duis ex est, ultrices quis varius non, dapibus ut neque. Vivamus tempus malesuada ex, non pulvinar ante bibendum vel. Curabitur posuere, ex ut tempor vestibulum, odio mauris maximus nulla, a commodo turpis eros sit amet odio. Duis quis dapibus leo, quis fringilla nibh. Pellentesque imperdiet odio neque, sed accumsan nisi hendrerit nec. Sed sodales erat feugiat fringilla vulputate. Donec viverra bibendum elit in convallis. Vivamus egestas feugiat porttitor. Pellentesque ultrices feugiat ligula. Pellentesque sit amet mi vitae lectus placerat rutrum a eget risus. Cras eget aliquam metus.";
	$lorem_ipsum = explode( ' ', $lorem_ipsum );
	shuffle( $lorem_ipsum );
	$lorem_ipsum = implode( ' ', $lorem_ipsum );
	return wp_trim_words( $lorem_ipsum, $num_words, '' );
}
