<?php
/**
 * Cart Module classes
 *
 * @since      1.0.0
 * @package    waorder
 * @subpackage waorder/inc
 * @author     Fiq Hidayat <taufik@fiqhidayat.com>
 */

Class Waorder_Cart{

    /**
	 * define inserted args
	 * @var [type]
	 */
	private $args = array();

	/**
	 * define error
	 * @var [type]
	 */
	private $error = array();

	/**
	 * data
	 * @var [type]
	 */
	public $data = array();

    /**
	 * table
	 * @var [type]
	 */
	public $table = NULL;

	/**
	 * Construction
	 */
	public function __construct($cart = false){

		global $wpdb;

        $this->table = $wpdb->prefix . 'waorder_cart';

		if( is_object($cart) && isset($cart->ID) || is_array($cart) && isset($cart['ID']) ):

			$this->data = is_object($cart) ? $cart : (object) $cart;

        elseif( is_int($cart) && $cart >= 1 || is_string($cart) && intval($cart) >= 1 ):

			$cart_id = intval($cart);

			$d = wp_cache_get($cart_id, 'waorder_cart');

			if( $d ){
				$this->data = $d;
			}else{

				$table = $wpdb->prefix. 'waorder_cart';

				$d = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table WHERE ID = %d LIMIT 1", intval($cart_id) ) );

				if( $d ){
					wp_cache_add($cart_id, $d, 'waorder_cart');
					$this->data = $d;
				}
			}

		endif;

		if( $this->data && isset($this->data->data) && $this->data->data ):
			$this->data->data = maybe_unserialize($this->data->data);
		endif;

	}

	/**
	 * getter
	 * @param  string $key [description]
	 * @return [type]      [description]
	 */
	public function __get($key){

		$data = get_object_vars($this->data);

		if (array_key_exists($key, $data))
		    return $data[$key];

		return NULL;
	}

	/**
	 * set subdomain
	 * @param string $string [description]
	 */
	public function set_user_key($string){

        if( empty($string) ) {
            $this->error['user_key'] = 'User key is required';

            return $this;
        }

		$this->args['user_key'] = sanitize_text_field($string);

		return $this;
	}

	/**
	 * set status
	 * @param string $status [description]
	 */
	public function set_data($data=array()){

		if( !is_array($data) ){
            $this->error['data'] = 'Data is required';

            return $this;
        }

		$this->args['data'] = maybe_serialize($data);

		return $this;
	}

	/**
	 * insert to database
	 * @return [type] [description]
	 */
	public function insert(){

		global $wpdb;

		if( isset($this->error['user_key']) )
			return new WP_Error( 'error', $this->error['user_key'] );

		if( isset($this->error['data']) )
			return new WP_Error( 'error', $this->error['data'] );

		$wpdb->insert($this->table,$this->args);

		return $wpdb->insert_id;
	}

	/**
	 * update;
	 * @return [type] [description]
	 */
	public function update(){

		global $wpdb;

		if( isset($this->args['user_id']) && $user = get_userdata($this->args['user_id']) ):
			if( !in_array('administrator', $user->roles) ){
				$this->args['subdomain'] = $user->user_login;
			}
		endif;

		$this->args['updated_at'] = date('Y-m-d H:i:s', time() );

		if( isset($this->error['data']) )
			return new WP_Error( 'error', $this->error['data'] );

		$updated = $wpdb->update($this->table,$this->args, ['ID' => $this->ID]);

		if( false === $updated )
			return new WP_Error( 'error', __( 'Update error', 'wpapg'  ) );

		wp_cache_delete($this->ID, 'wpapg_subdomain');

		return $this->ID;
	}

	/**
	 * delete
	 * @return [type] [description]
	 */
	public function delete(){

		global $wpdb;

		$deleted = $wpdb->delete($this->table,['ID' => $this->ID]);

		if( false === $deleted )
			return new WP_Error( 'error', __( 'Delete error', 'wpapg'  ) );

		wp_cache_delete($this->ID, 'wpapg_subdomain');

		return true;
	}

}
