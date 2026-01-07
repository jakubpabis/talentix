<?php global $blennder_search_form_atts; ?>
<?php if (! is_array($blennder_search_form_atts)) return; ?>
<form id="<?php echo $blennder_search_form_atts['form_id']; ?>" role="search" method="get" class="<?php echo $blennder_search_form_atts['form_class']; ?>" action="<?php echo esc_url(home_url('/')); ?>">
	<div class="input-group input-group--overlay">
		<div class="input-group-prepend">
			<?php
			printf(
				'<label id="%1$s" for="%2$s" class="input-group-text"><i class="fa fa-search"></i></label>',
				$blennder_search_form_atts['aria-describedby'] ?? 'search-btn',
				$blennder_search_form_atts['input_id'] ?? 'search-input'
			);
			?>
		</div>
		<?php
		printf(
			'<input id="%1$s" type="search" class="form-control" placeholder="%2$s" value="%3$s" name="s" title="%4$s" aria-label="%5$s" aria-describedby="%6$s"/>',
			$blennder_search_form_atts['input_id'] ?? 'search-input',
			$blennder_search_form_atts['placeholder'] ?? pll__('Search articles...'),
			get_search_query(),
			$blennder_search_form_atts['title'] ?? pll__('Search'),
			$blennder_search_form_atts['aria-label'] ?? pll__('Search'),
			$blennder_search_form_atts['aria-describedby'] ?? 'search-btn'
		);
		?>
		<div class="input-group-append">
			<?php
			printf(
				'<button class="%1$s" type="submit" id="%2$s">%3$s</button>',
				$blennder_search_form_atts['button']['class'] ?? 'btn btn-light',
				$blennder_search_form_atts['aria-describedby'] ?? 'search-btn',
				$blennder_search_form_atts['button']['text'] ?? '<span class="visually-hidden">Search</span><i class="fa fa-chevron-right"></i>'
			);
			?>
		</div>
	</div>
</form>
<?php unset($blennder_search_form_atts);
