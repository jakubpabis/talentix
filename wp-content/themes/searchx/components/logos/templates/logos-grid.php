<?php

/**
 * Template Name: Logos Grid
 */

?>

<div <?php component_row(); ?>>

	<?php require locate_template('template-parts/component-heading.php'); ?>

</div>

<?php

$breakpoints = [
	'xs'  => '2',
	'sm'  => '2',
	'md'  => '3',
	'lg'  => '3',
	'xl'  => '4',
	'xxl' => '4',
];

?>

<div <?php component_card_group_row('logos', [], $breakpoints); ?>>

	<?php foreach (get_has_field('logos', []) as $logo) : ?>

		<div <?php component_col(); ?>>

			<?php include component_part_path('logos-card'); ?>

		</div>

	<?php endforeach; ?>

</div>