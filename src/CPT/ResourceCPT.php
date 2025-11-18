<?php
namespace ASMR\CPT;

use ASMR\Abstracts\AbstractCPT;

class ResourceCPT extends AbstractCPT {
    protected function define_fields() : array {
        return array();
    }
    public function __construct() {
        parent::__construct( 'awesome_resource' );
        $this->args = [
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 20,
            'capability_type' => 'post',
            'supports' => [ 'title', 'thumbnail', 'excerpt' ],
        ];
    }
}