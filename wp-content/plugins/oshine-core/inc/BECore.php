<?php
/**
 * Handle plugin contents
 *
 * This class handle pathing the core information to other classes like plugin path, plugin version, plugin url..etc
 *
 * @since 1.0
 *
 * @package be
 * @subpackage be-functions
 */
Class BECore implements ArrayAccess {
	protected $contents;

	function __construct() {
		$this->contents = array();
	}
	public function offsetSet( $offset, $value ) {
        $this->contents[$offset] = $value;
    }

    public function offsetExists($offset) {
        return isset( $this->contents[$offset] );
    }

    public function offsetUnset($offset) {
        unset( $this->contents[$offset] );
    }

    public function offsetGet($offset) {
        if( is_callable($this->contents[$offset]) ){
            return call_user_func( $this->contents[$offset], $this );
        }
        return isset( $this->contents[$offset] ) ? $this->contents[$offset] : null;
    }
    
    public function run(){ 
        foreach( $this->contents as $key => $content ){ // Loop on contents
            if( is_callable($content) ){
                $content = $this[$key];
            }
            if( is_object( $content ) ){
                $reflection = new ReflectionClass( $content );
                if( $reflection->hasMethod( 'run' ) ){
                    $content->run(); // Call run method on object
                }
            }
        }
    }
}
?>