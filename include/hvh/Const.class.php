<?php
namespace hvh {

class SERVER_ERR {
	const REGISTER_FAILED = array('errno'=>1000, 'data'=>'', 'error'=>'Register Failed');
	const LOGIN_FAILED = array('errno'=>1000, 'data'=>'', 'error'=>'Login Failed');
	
	public static function Test() {
		echo __NAMESPACE__;
	}
}

}// End of namespace
?>