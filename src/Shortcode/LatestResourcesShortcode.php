<?php
namespace ASMR\Shortcode;

use ASMR\Abstracts\AbstractShortcode;

class LatestResourcesShortcode extends AbstractShortcode {
    protected array $defaults = [
        'limit' => 5,
    ];
    protected function get_tag_name(): string {
        return 'latest_resources';
    }
    protected function render( array $atts, ?string $content ): string {
        $atts = array_merge( $this->defaults, $atts );
        $query = new \WP_Query([
            'post_type' => 'awesome_resource',
            'posts_per_page' => intval( $atts[ 'limit' ] ),
        ]);

        return ASMR()->view( 'shortcodes/latest_resources.php', [
            'query' => $query
        ] );
    }
    public function __construct() {
        parent::__construct();
    }
}