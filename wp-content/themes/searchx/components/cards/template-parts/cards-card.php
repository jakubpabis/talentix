<?php
$link = get_has_field('card_link', [], $card);
$image = get_has_field('card_image', null, $card);
$icon = get_has_field('card_icon', null, $card);
$icon_color = get_has_field('card_icon_color', null, $card);
$icon_size = get_has_field('card_icon_size', null, $card);
$card_image_style = get_has_field('card_image_style', '');
switch ($card_image_style) {
	case 'icon-top':
		$card_class = 'card-icon-top';
		break;
	case 'background':
		$card_class = 'card-img-background';
		break;
	case 'top':
		$card_class = 'card-img-top';
		break;
	case 'numbers':
		$card_class = 'card-numbered';
		break;
	case 'small':
		$card_class = 'card-img-small';
		break;
	case 'small-big':
		$card_class = 'card-img-small-big';
		break;
	default:
		$card_class = 'card-img-top';
		break;
}
$card_bg = get_has_field('cards_background_color', '#ffffff');
$card_shadow = get_has_field('cards_shadow', 'shadow shadow-lg');
?>

<div class="card <?php echo $card_shadow; ?> <?php echo $card_class; ?>" <?php echo 'style="background-color: ' . $card_bg . ';"'; ?>>

	<?php if (! empty($image) && $card_image_style !== 'small' && $card_image_style !== 'small-big') : ?>
		<div class="card-img-wrapper">
			<?php acf_image('card_image', 'medium', ['class' => 'card-image'], $card); ?>
		</div>
	<?php endif; ?>

	<div class="card-body">

		<?php if ($card_image_style === 'small-big') : ?>
			<div class="row px-lg-10">
				<?php if (!empty($image)): ?>
					<div class="col-lg-3 pe-lg-10">
						<?php acf_image('card_image', 'medium', ['class' => 'card-image-small rounded rounded-circle'], $card); ?>
					</div>
				<?php endif; ?>
				<div class="col-lg-9">
					<div class="card-stars d-flex align-items-center my-6">
						<?php for ($i = 1; $i <= 5; $i++): ?>
							<i class="fa-sharp fa-solid fa-star-sharp fa-xl <?php echo $i <= get_has_field('card_stars', 5, $card) ? 'text-warning' : 'text-light'; ?>"></i>
						<?php endfor; ?>
					</div>
				<?php endif; ?>

				<?php if (!empty($icon)) : ?>
					<?php
					$classes = 'card-icon mb-md-4 ' . $icon_size;
					$atts = 'aria-hidden="true"' . $icon_color ? 'style="color: ' . $icon_color . ';"' : '';
					$replace = $atts . 'class="' . $classes . ' ';
					$icon = str_replace('class="', $replace, $icon);
					echo $icon;
					?>
				<?php endif; ?>

				<?php if ($card_image_style === 'numbers'): ?>
					<span class="h3 card-number d-block mb-4 mt-0 text-primary">
						<?php echo $key < 9 ? '0' . ($key + 1) : $key + 1; ?>
					</span>
				<?php endif; ?>

				<?php if ($card_image_style === 'small'): ?>
					<?php acf_image('card_image', 'thumbnail', ['class' => 'card-image-small rounded rounded-circle'], $card); ?>
					<div class="card-stars d-flex align-items-center my-6">
						<?php for ($i = 1; $i <= 5; $i++): ?>
							<i class="fa-sharp fa-solid fa-star-sharp fa-xl <?php echo $i <= get_has_field('card_stars', 5, $card) ? 'text-warning' : 'text-light'; ?>"></i>
						<?php endfor; ?>
					</div>
				<?php endif; ?>

				<?php if (!empty($card['card_sub_header'])): ?>

					<span class="card-subtitle">

						<?php acf_text('card_sub_header', $card); ?>

					</span>

				<?php endif; ?>

				<?php if (!empty($card['card_header'])): ?>

					<h4 class="card-title">

						<?php acf_text('card_header', $card); ?>

					</h4>

				<?php endif; ?>

				<?php acf_wysiwyg('card_content', ['class' => ['card-text']], $card); ?>

				<?php if (! empty($link) && $link['title']) : ?>

					<span class="btn btn-lg btn-link">

						<?php echo get_has_field('title', '', $link); ?>

					</span>

				<?php elseif (! empty($link) && empty($link['title'])): ?>

					<i class="fa-sharp fa-solid fa-chevron-right fa-2x"></i>

				<?php elseif (! empty($link) && $card_image_style == "top"): ?>

					<a class="card-link btn btn-primary" href="<?php echo get_has_field('url', '', $link); ?>">

						<?php echo get_has_field('title', '', $link); ?>

					</a>

				<?php endif; ?>

				<?php if ($card_image_style === 'small-big'): ?>
				</div>
			</div>
		<?php endif; ?>

	</div>

	<?php if (! empty($link)) : ?>

		<a class="stretched-link" title="<?php echo get_has_field('title', '', $link); ?>" href="<?php echo get_has_field('url', '', $link); ?>"> </a>

	<?php endif; ?>

</div>