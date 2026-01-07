<?php

/**
 * Template Name: Cards Grid
 */
?>

<div <?php component_row(); ?>>

	<?php require locate_template('template-parts/component-heading.php'); ?>

</div>

<?php
$sizes = [
	'xs',
	'sm',
	'md',
	'lg',
	'xl',
	'xxl',
];
$breakpoints = [];
foreach ($sizes as $size) {
	if (get_field('cards_cols_' . $size)) {
		$breakpoints[$size] = get_field('cards_cols_' . $size);
	}
}
?>

<div <?php component_card_group_row('cards', [], $breakpoints); ?>>

	<?php $cards = get_has_field('cards', []); ?>
	<?php foreach ($cards as $key => $card): ?>

		<div <?php component_col(); ?> data-aos="fade-up">

			<?php include component_part_path('cards-card'); ?>

		</div>

	<?php endforeach; ?>

</div>
