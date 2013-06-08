<?
/**
 * Class di
 */
final class di {

	/**
	 * @param $name
	 * @return mixed
	 * @throws Exception
	 */
	public function __get($name) {
		if (isset(di_container::$registrants[$name])) {
			$val = di_container::$registrants[$name];
			if (gettype($val) == 'object' && is_callable($val)) {
				// Functions stored within DI aren't executed unless required to same on memory and if called again the value is simply returned
				$val = $val();
				di_container::$registrants[$name] = $val;
			}
			return $val;
		}

		throw new Exception($name . ' not set, please check isset() before attempting to fetch');
	}

	/**
	 * @param $name
	 * @param $value
	 */
	public function __set($name, $value) {
		$this->add($name, $value);
	}

	/**
	 * @param $name
	 * @return bool
	 */
	public function __isset($name) {
		return isset(di_container::$registrants[$name]);
	}

	/**
	 * @param $name
	 */
	public function __unset($name) {
		if (isset($this->$name)) {
			unset(di_container::$registrants[$name]);
		}
	}

	/**
	 * @param $name
	 * @param $value
	 */
	public function add($name, $value) {
		di_container::$registrants[$name] = $value;
	}
}