<?php
  class @@CLASSNAME@@ {
    public $name = "RawEvent";

    public function preprocessEvent($name, $registrations, $connection, $data) {
      $ex = explode(" ", $data);

      // Iterate through each registration.
      foreach ($registrations as $id => $registration) {
        // Trigger the event for a certain registration.
        EventHandling::triggerEvent($name, $id, array($connection, $data, $ex));
      }
    }

    public function isInstantiated() {
      // Create an event for raw data.
      EventHandling::createEvent("rawEvent", $this, "preprocessEvent");
      return true;
    }
  }
?>
