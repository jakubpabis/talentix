<?php $navigation_position = $args['navigation_position'] ?? ''; ?>

<?php if ($navigation_position) : ?>

	<div class="swiper-navigation--wrapper swiper-navigation--wrapper-<?php echo $navigation_position; ?> container">

		<div class="swiper-navigation swiper-navigation--<?php echo $navigation_position; ?>">

			<div class="swiper-button-prev d-flex align-items-center justify-content-center">
				<i class="fa-regular fa-arrow-left-long"></i>
			</div>

			<div class="swiper-button-next d-flex align-items-center justify-content-center"><i class="fa-regular fa-arrow-right-long"></i></div>

		</div>

	</div>

<?php endif; ?>

<?php $pagination_position = $args['pagination_position'] ?? ''; ?>

<?php if ($pagination_position) : ?>

	<div class="swiper-pagination--wrapper swiper-pagination--wrapper-<?php echo $pagination_position; ?> container">

		<div class="swiper-pagination swiper-pagination--<?php echo $pagination_position; ?>"></div>

	</div>

<?php endif; ?>