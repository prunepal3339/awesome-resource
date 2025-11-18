<?php
namespace ASMR\Abstracts;

abstract class AbstractPlugin {
    protected abstract function listPluginClasses(): array;
    public function instantiatePluginClasses() {
        $pluginClasses = $this->listPluginClasses();
        foreach ( $pluginClasses as $pluginClass => $config ) {
            $arguments = isset( $config[ 'arguments' ] ) ? $config[ 'arguments' ] : [];
            $singleton = isset( $config[ 'singleton' ] ) ? $config[ 'singleton' ] : true;
            $this->instantiate( $pluginClass, $arguments, $singleton );
        }
    }
    public function instantiate($fqcn, array $arguments = [], $singleton = true ) {
        static $storage = [];
        if( ! class_exists( $fqcn ) ) {
            throw new \InvalidArgumentException( "Class {$fqcn} does not exist!" );
        }
        $hash = self::get_arguments_hash( $arguments );
        if( $singleton && isset( $storage[ $fqcn ][ $hash ] ) ) {
            return $storage[ $fqcn ][ $hash ];
        }

        /**
         * Filter to modify arguments before object instantiation.
         */
        $arguments = apply_filters( 'asmr_pre_instantiation_args', $arguments, $fqcn );

        try {
            $klass = new \ReflectionClass( $fqcn );
            if ( ! empty( $arguments ) ) {
                $resolved_arguments = array_map(
                    function( $argument ) {
                        if ( class_exists( $argument ) ) {
                            return $this->instantiate( $argument );
                        }
                        return $argument;
                    }, $arguments
                );
                
                $instance = $klass->newInstanceArgs( $resolved_arguments );
            } else {
                $instance = $klass->newInstance();
            }
        } catch( \Exception $e ) {
            throw new \InvalidArgumentException( "Failed to instantiate {$fqcn}: " . $e->getMessage() );
        }
        /**
         * Fires right after the object is instantiated via instantiate method.
         * 
         * We can add additional cross-cutting concerns like book-keeping object instantiation.
         */
        do_action( 'asmr_post_instantiation', $instance, $arguments, $fqcn );

        if( $singleton ) {
            $storage[ $fqcn ][ $hash ] = $instance;
        }
        return $instance;
    }
    protected static function get_arguments_hash( array $arguments ) {
        return md5( maybe_serialize( $arguments ) );
    }
}