<?php
/**
 * Template Name: Style Guide
 */

wp_enqueue_script( 'style-guide', get_stylesheet_directory_uri() . '/assets/js/modules/style-guide.js', [ 'jquery' ] );

include_once dirname( __DIR__ ) . '/inc/style-guide-functions.php';
?>

<?php get_header(); ?>

<?php
	$sections = [
		'Branding' => [
			'Logo',
			'Favicon',
		],
		'Typography' => [
			'Fonts',
			'Headings',
			'Display Headings',
			'Global Text',
			'Blockquotes',
		],
		'Colors' => [
			'Theme',
			'Alternate Colors',
			'Light/Dark Colors'
		],
		'Buttons' => [
			'Solid',
			'Outline',
			'Sizes',
			'Text Link',
		],
		'Icons' => [
			'Icons Social',
		],
		'Forms' => [],
		'Components' => component_get_blocks(),
	];
?>

<main id="main" class="style-guide" role="main">

	<div class="style-guide__menu">

		<div class="style-guide__menu-button">
			<button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#sgMenu">
			<i class="fa-solid fa-brush"></i>
			</button>
		</div><!-- .style-guide__menu-button -->

		<!-- Modal -->
		<div class="modal sg-menu-left fade" id="sgMenu" tabindex="-1" role="dialog" aria-labelledby="sgMenuLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<button type="button" class="close text-right p-3" data-bs-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">
							<i class="fa-solid fa-xmark"></i>
						</span>
					</button>

					<div class="modal-header">
						<header id="sgMenuLabel" class="p-2">
							<a class="h4 text--dark" href="#"><?php the_title(); ?></a>
						</header>
					</div><!-- .modal-header -->

					<div class="modal-body">
						<nav class="style-guide__nav nav flex-column">
							<div class="style-guide__nav-inner">
								<?php foreach($sections as $section => $sub_sections): ?>
									<a class="nav-link" href="#<?php echo sanitize_title($section); ?>" role="button" aria-expanded="false" aria-controls="collapseExample"><?php echo ucfirst($section);?> <i data-toggle="collapse" href="#<?php echo 'collapse-'. sanitize_title($section); ?>" class="fa fa-chevron-right"></i></a>
									<?php if( ! empty( $sub_sections ) ): ?>
									<div class="style-guide__sub-nav collapse" id="collapse-<?php echo sanitize_title($section); ?>">
										<ul class="">
											<?php foreach($sub_sections as $sub_section): ?>
												<li><a href="#<?php echo sanitize_title($section) . '__' . sanitize_title($sub_section); ?>" data-scroll-offset="-50"><?php echo $sub_section; ?></a></li>
											<?php endforeach; ?>
										</ul>
									</div>

									<?php endif; ?>
								<?php endforeach; ?>
							</div><!-- .style-guide__nav-inner -->
						</nav><!-- .style-guide__nav -->
					</div><!-- .modal-body -->

				</div><!-- modal-content -->
			</div><!-- modal-dialog -->
		</div>
		<!-- modal -->

	</div><!-- .style-guide__menu -->

	<section class="style-guide__content p-md-4 p-lg-5 ms-5">
		<div class="container style-guide__container">

			<?php the_content(); ?>

			<?php foreach($sections as $section => $sub_sections) : ?>
				<?php if( 'Components' === $section ) continue; ?>
				<article id="<?php echo sanitize_title($section); ?>">
					<a class="anchor" id="<?php echo sanitize_title($section); ?>"></a>
					<h2 class="h1"><?php echo $section; ?></h2>
					<hr>
					<?php get_template_part('template-parts/style-guide/' . strtolower($section)); ?>
				</article>
			<?php endforeach; ?>

		</div>
	</section>

	<?php /* Components are separated to avoid an extra wrapping container */?>
	<section class="style-guide__content ms-5">
		<?php $section = 'Components'; ?>
		<article id="<?php echo sanitize_title($section); ?>">
			<div class="container">
				<a class="anchor" id="<?php echo sanitize_title($section); ?>"></a>
				<h2 class="h1"><?php echo $section; ?></h2>
				<hr>
			</div>
			<?php get_template_part('template-parts/style-guide/' . strtolower($section)); ?>
		</article>
	</section>
</main><!-- #main -->

<?php get_footer(); ?>
