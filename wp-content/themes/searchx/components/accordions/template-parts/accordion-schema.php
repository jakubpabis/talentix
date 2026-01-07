<?php if( 'true' === get_has_field( 'accordion_use_as_schema', 'false' ) ) : ?>
<script type="application/ld+json">
{
	"@context": "https://schema.org",
	"@type": "FAQPage",
	"mainEntity": [
		<?php echo json_encode( $json ); ?>
	]
}
</script>
<?php endif; ?>
