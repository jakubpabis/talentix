<ul class="tabs__nav nav nav-tabs">

	<?php foreach (get_has_field('tabs', []) as $key => $tab) : ?>

		<li class="tabs__nav-item nav-item" data-aos="fade-up">

			<button <?php tabs_nav_link_attr(['tab' => $tab, 'count' => $key, 'id' => $id]); ?>>

				<span class="tabs__label">

					<?php acf_text('tab_label', $tab); ?>

				</span>

			</button>

		</li>

	<?php endforeach; ?>

</ul>
