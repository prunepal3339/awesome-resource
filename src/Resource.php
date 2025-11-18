<?php
namespace ASMR;

use ASMR\Abstracts\AbstractPlugin;
use ASMR\CPT\ResourceCPT;
use ASMR\Shortcode\LatestResourcesShortcode;

class Resource extends AbstractPlugin {
    private static ?Resource $instance = null;
    public static function instance() {
        return self::$instance ?? (self::$instance = new self());
    }
    public function __construct() {
        $this->init();
    }
    public function init() {
        $this->instantiatePluginClasses();
    }

    public function view( $template_path, $data = [] ) {
        $resolved_path = ASMR_PLUGIN_PATH . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . $template_path;
        if( ! file_exists( $resolved_path ) ) {
            //[IMPROVEMENTS] Log: Path not resolved: ${resolved_path}
            return;
        }
        ob_start();
        extract($data);
        include_once $resolved_path;
        return ob_get_clean();
    }
    protected function listPluginClasses(): array {
        return [
            ResourceCPT::class => [
                'arguments' => [],
                'singleton' => true,
            ],
            LatestResourcesShortcode::class => [
                'arguments' => [],
                'singleton' => true,
            ]
        ];
    }
}
