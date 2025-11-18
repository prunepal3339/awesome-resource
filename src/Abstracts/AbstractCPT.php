<?php 
namespace ASMR\Abstracts;
/**
 * Abstract Custom Post Type.
 */
abstract class AbstractCPT {
    protected string $post_type;
    protected array $labels = [];
    protected array $fields = [];
    protected array $args = [];
    public function __construct( $post_type ) {
        $this->post_type = $post_type;
        add_action( 'init', [ $this, 'register_cpt' ] );
    }
    abstract protected function define_fields(): array;
    protected function singularize() {
        return ucwords( str_replace( ['_', '-'], ' ', $this->post_type ) );
    }
    protected function pluralize() {
        return $this->singularize() . 's';
    }
    public function register_cpt() {
        $this->fields = $this->define_fields();
        $plural_name = $this->pluralize();
        $singular_name = $this->singularize();
        $labels = [
            'name'               => esc_html__( $plural_name, 'awesome-resource' ),
            'singular_name'      => esc_html__( $singular_name, 'awesome-resource' ),
            'add_new_item'       => esc_html__( sprintf( 'Add New %s', $singular_name ), 'awesome-resource' ),
            'edit_item'          => esc_html__( sprintf( 'Edit %s', $singular_name ), 'awesome-resource' ),
            'all_items'          => esc_html__( sprintf( 'All %s', $plural_name ), 'awesome-resource' ),
            'view_item'          => esc_html__( sprintf( 'View %s', $singular_name ), 'awesome-resource' ),
            'search_items'       => esc_html__( sprintf( 'Search %s', $plural_name ), 'awesome-resource' ),
            'not_found'          => esc_html__( sprintf( 'No %s found', strtolower($plural_name) ), 'awesome-resource' ),
            'not_found_in_trash' => esc_html__( sprintf( 'No %s found in Trash', strtolower($plural_name) ), 'awesome-resource' ),
        ];

        $default_args = [
            'labels' => array_merge( $labels, $this->labels ),
            'public' => true,
            'supports' => [],
            'show_icon_menu' => 'AA',
            'has_archive' => false,
            'show_in_rest' => true,
        ];

        register_post_type( $this->post_type, array_merge( $default_args, $this->args) );
    }
}
