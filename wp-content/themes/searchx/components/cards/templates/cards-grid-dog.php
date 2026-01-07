<?php

/**
 * Template Name: Cards Grid Dog
 */
?>

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

<div class="row justify-content-between">

	<div class="<?php echo get_field('cards_image') ? 'col-lg-9' : 'col-12';  ?>">

		<div <?php component_row(); ?>>

			<?php require locate_template('template-parts/component-heading.php'); ?>

		</div>

		<div <?php component_card_group_row('cards', [], $breakpoints); ?>>

			<?php $cards = get_has_field('cards', []); ?>
			<?php foreach ($cards as $card): ?>

				<div <?php component_col(); ?> data-aos="fade-up">

					<?php include component_part_path('cards-card'); ?>

				</div>

			<?php endforeach; ?>

		</div>
	</div>

	<?php if (get_field('cards_image')): ?>

		<div class="col-lg-3 ps-lg-20 pt-lg-16">
			<div <?php component_row(); ?>>

				<?php acf_image('cards_image', 'medium_large'); ?>

			</div>
		</div>

	<?php endif; ?>

</div>