<?php

declare(strict_types=1);

namespace App\Setup;

use WP_REST_Server;
use WP_REST_Request;

/**
 * REST Class
 */
final class REST
{

	private $postTypes = [
		'post',
		'team',
		'jobs',
		'testimonials'
	];

	public function init()
	{
		add_action('rest_api_init', [$this, 'rest_api_init']);
		add_action('wp_head', [$this, 'wp_head']);
	}

	public function wp_head()
	{

		if (
			! is_home() &&
			! is_post_type_archive($this->postTypes)
		) {
			return;
		}

		global $wp_query;

		$page = $wp_query->query['paged'] ?? 1;
		$page = $page ?: 1;

		$taxonomy = get_primary_taxonomy();

		$postType = get_post_type();
		if ('post' === $postType) {
			$postType = 'posts';
			$taxonomy = 'categories';
		}

		$value = json_encode([
			'page' => $page,
			'totalPages' => $wp_query->max_num_pages,
			'postsPerPage' => $wp_query->query_vars['posts_per_page'],
			'postType' => $postType,
			'taxonomy' => $taxonomy,
		]);
?>
		<script>
			var pagination = <?php echo $value; ?>
		</script>
	<?php
	}

	public function rest_api_init(): void
	{
		add_filter('rest_pre_dispatch', [$this, 'rest_pre_dispatch'], 10, 3);

		register_rest_field($this->postTypes, 'card', [
			'get_callback' => [$this, 'get_callback'],
		]);
	}

	public function get_callback(
		array $wp_post_array
	): array {
		ob_start(); ?>
		<div class="col archive__col">
			<?php get_template_part('template-parts/content', 'post'); ?>
		</div>
<?php $card = ob_get_clean();

		return ['rendered' => $card];
	}

	public function rest_pre_dispatch(
		mixed $result,
		WP_REST_Server $server,
		WP_REST_Request $request
	): mixed {

		$value = [];

		$params = [
			'categories',
			'page',
			'per_page',
		];

		foreach ($params as $param) {
			if (isset($_GET[$param])) {
				$value[$param] = sanitize_title($_GET[$param]);
			}
		}

		if (! empty($value)) {
			$value = json_encode($value);
			header("X-Pagination: $value");
		}

		return $result;
	}
}
