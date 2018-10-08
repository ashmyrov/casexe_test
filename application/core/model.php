<?php
class Model
{
	public $home_link = '/casexe_test/';
	public $main_lang = 'en';
	public $lang_array = array('en', 'es', 'de', 'fr', 'it', 'cz');

    function __construct()
    {
        $servername = "localhost";
        $username = "root";
        $password = "";

        try {
            $this->conn = new PDO("mysql:host=$servername;dbname=casexe_test", $username, $password);
            // set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }
        catch(PDOException $e)
        {
            echo "Connection failed: " . $e->getMessage();
        }
    }

	public function selected_lang()
	{
		if(isset($_GET['lang']) and $_GET['lang']!=''){
			$selected_lang=$_GET['lang'];
		}
		else{
			$selected_lang=$this->main_lang;
		}
		return $selected_lang;
	}
	public function home_link_lang()
	{
		$home_link_lang = Model::selected_lang() == 'en' ? $this->home_link : $this->home_link .Model::selected_lang().'/';
		return $home_link_lang;
	}

	public function change_lang_link()
	{
		$langs=false;
		foreach ($this->lang_array as $id_lang_key) {
			$sel_opt = Model::selected_lang() == $id_lang_key ? "selected" : false;
			if ($id_lang_key == $this->main_lang) {
				$other_pages=preg_replace('~^\/(\w{2})\/~is', '/', $_SERVER['REQUEST_URI']);
				$langs.= '<option value="'.$other_pages.'" '.$sel_opt.'>lang - ' . strtoupper($id_lang_key) . '</option>';
			}
			else {
				if (preg_match('~^\/(\w{2})\/~', $_SERVER['REQUEST_URI'])) $other_pages=preg_replace('~^\/(\w{2})\/~is', '/'.$id_lang_key.'/', $_SERVER['REQUEST_URI']);
				else $other_pages=preg_replace('~^\/~is', '/'.$id_lang_key.'/', $_SERVER['REQUEST_URI']);
				$langs.= '<option value="'.$other_pages.'" '.$sel_opt.'>lang - ' . strtoupper($id_lang_key) . '</option>';
			}

		}
		return $langs;
	}
	public function get_categories_data()
	{
		$xmlc = simplexml_load_file('xml/categories.xml');
		foreach ($xmlc->category as $category) {
			$info_category = $category->info_category;
			foreach ($info_category->info as $info) {
				if (strtolower($info->lang) == Model::selected_lang()) {
					$categories[''. $category->id->__tostring() .''] = $info->title->__tostring();
				}
			}
		}
		return $categories;
	}
	public function get_curr_data()
	{
		if (isset($_COOKIE['currCookie'])) $curr = $_COOKIE['currCookie'];
		else {
			setcookie('currCookie', 'USD', time()+7*24*60*60, '/');
			$curr = 'USD';
		}
		return $curr;
	}
	public function get_sigs_data()
	{
		$xmlcur = simplexml_load_file('xml/settings.xml');
		foreach ($xmlcur->configs->config as $config_val){
			if ($config_val->id==11) $eu_curr = $config_val->value;
		}
		$sigs = array(
		'USD' => array('&dollar;', '1', '$'),
		'EUR' => array('&euro;', ''.$eu_curr.'', '€'),
		//'pounds' => array('&pound;', ''.$po_curr.'')
		);
		return $sigs;
	}
	public function get_sig_data()
	{
		$cur_sig=Model::get_sigs_data()[Model::get_curr_data()][0];
		return $cur_sig;
	}
	public function get_mod_data()
	{
		$cur_mod=Model::get_sigs_data()[Model::get_curr_data()][1];
		return $cur_mod;
	}
	public function get_cart_cookie_data()
	{
		if (isset($_COOKIE['cart'])) {
			foreach ($_COOKIE['cart'] as $k => $v) {
				$cart_cookie[$k] = $v;
			}
			return $cart_cookie;
		} else {
			$cart_cookie = 0;
			return $cart_cookie;
		}
	}
	public function get_header_cart_data()
	{
		if (Model::get_cart_cookie_data() != 0) {
			$total_items = false;
			$total_price = false;
			foreach (Model::get_cart_cookie_data() as $k => $v) {
				$arr_k = explode(':', $v);
				$total_items += $arr_k[1];
				$total_price += $arr_k[1]*$arr_k[2];
			}
			$header_cart = array($total_items, $total_price); // * Model::get_mod_data(), 2) . ' ' . Model::get_sig_data();
			return $header_cart;
		} else {
			$header_cart = array('0', '0.00');
			return $header_cart;
		}
	}
}