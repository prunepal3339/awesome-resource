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
            'name' => $plural_name,
            'singular_name' => $singular_name,
            'add_new_item' => "Add New {$singular_name}",
            'edit_item' => "Edit {$singular_name}",
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
