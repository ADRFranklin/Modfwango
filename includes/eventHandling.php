<?php
	class EventHandling {
		private static $events = array();
		
		public static function createEvent($name, $module, $callback) {
			if (method_exists($module, $callback) && !isset(self::$events[$name])) {
				self::$events[$name] = array($module, $callback, array());
				return true;
			}
			return false;
		}
		
		public static function destroyEvent($name) {
			if (isset(self::$events[$name])) {
				unset(self::$events[$name]);
				return true;
			}
			return false;
		}
		
		public static function getEvents() {
			return self::$events;
		}
		
		public static function receiveData($connection, $data) {
			foreach (self::$events as $key => $event) {
				$event[0]->$event[1]($key, $event[2], $connection, trim($data));
			}
			return true;
		}
		
		public static function registerForEvent($name, $module, $callback, $data = null) {
			if (isset(self::$events[$name]) && method_exists($module, $callback)) {
				self::$events[$name][2][] = array($module, $callback, $data);
				return true;
			}
			return false;
		}
		
		public static function triggerEvent($name, $id, $data = null) {
			if (isset(self::$events[$name])) {
				$registration = self::$events[$name][2][$id];
				if (method_exists($registration[0], $registration[1])) {
					$registration[0]->$registration[1]($name, $data);
				}
				return true;
			}
			return false;
		}
		
		public static function unregisterForEvent($name, $module) {
			if (isset(self::$events[$name])) {
				foreach (self::$events[$name][2] as $key => $registration) {
					if ($registration[0]->name == $module->name) {
						unset(self::$events[$name][2][$key]);
						return true;
					}
				}
			}
			return false;
		}
		
		public static function unregisterModule($module) {
			foreach (self::$events as $key => $event) {
				self::unregisterForEvent($key, $module);
			}
			return true;
		}
	}
?>