<?php $uniqid = uniqid(); ?>
<?php
$border_bottom = get_field('accordion_border_b', "options") || get_field('accordion_border_b', "options") === "0" ? ' border-bottom-width: ' . get_field('accordion_border_b', "options") . 'px; ' : '';
$border_radius = get_field('accordion_radius', "options") ? ' border-radius: ' . get_field('border_' . get_field('accordion_radius', "options"), "options") . 'px; ' : '';
$padding_y = get_field('accordion_padding_y', "options") ? ' padding-top: ' . get_field('accordion_padding_y', "options") / 16 . 'rem; padding-bottom: ' . get_field('accordion_padding_y', "options") / 16 . 'rem;' : '';
$padding_b = get_field('accordion_padding_y', "options") ? ' padding-top: 0!important; padding-bottom: ' . get_field('accordion_padding_y', "options") / 16 . 'rem;' : '';
$padding_x = get_field('accordion_padding_x', "options") ? ' padding-left: ' . get_field('accordion_padding_x', "options") / 16 . 'rem; padding-right: ' . get_field('accordion_padding_x', "options") / 16 . 'rem;' : '';
?>
<div class="accordions__item col" data-aos="fade-up">
	<div id="accordion-heading-<?php echo $uniqid; ?>" class="accordions__header">
		<button
			class="accordions__btn collapsed"
			data-bs-toggle="collapse"
			data-bs-target="#accordion-collapse-<?php echo $uniqid; ?>"
			aria-expanded="false"
			aria-controls="#accordion-collapse-<?php echo $uniqid; ?>">
			<span class="lead fw-medium my-3">
				<?php acf_text('accordion_item_title', $accordion_item); ?>
			</span>
			<span class="accordions__icon">
				<i class="accordions__icon-collapse fa-regular fa-chevron-down text-primary"></i>
				<i class="accordions__icon-collapsed fa-regular fa-chevron-up text-primary"></i>
			</span>
		</button>
	</div>
	<div
		id="accordion-collapse-<?php echo $uniqid; ?>"
		class="collapse accordions__collapse"
		data-bs-parent="#accordion-<?php echo $parent_id; ?>"
		aria-labelledby="#accordion-heading-<?php echo $uniqid; ?>"
		style="<?php echo $border_radius; ?>">
		<div class="accordions__body py-5">
			<?php echo acf_text('accordion_item_content', $accordion_item); ?>
		</div>
	</div>
</div>
<?php
$json[] = (object) [
	"@type" => "Question",
	"name" => get_has_field('accordion_item_title', '', $accordion_item),
	"acceptedAnswer" => (object) [
		"@type" => "Answer",
		"text" => get_has_field('accordion_item_content', '', $accordion_item),
	]
];
