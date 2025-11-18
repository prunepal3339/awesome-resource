<?php
namespace ASMR\Abstracts;

abstract class AbstractShortcode {
    protected string $tag;
    protected array $defaults = [];
    public function __construct() {
        add_action( 'init', function() {
            add_shortcode( $this->get_tag_name(), [ $this, 'handle' ] );
        });
    }
    abstract protected function get_tag_name(): string;
    public function handle( array $atts = [], ?string $content = null ): string {
        $atts = shortcode_atts( $this->defaults, $atts, $this->get_tag_name() );
        wp_enqueue_style(
            'asmr-shortcode-css',
            ASMR_PLUGIN_URL . 'assets/dist/css/shortcodes.css',
            [],
            ASMR_PLUGIN_VERSION
        );
        return $this->render( $atts, $content );
    }
    abstract protected function render( array $atts, ?string $content ): string;
}