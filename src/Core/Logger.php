<?php
use Monolog\Logger as MonoLogger;
use Monolog\Handler\StreamHandler;
class Logger {
  private static $log;
  public static function get() {
    if (!self::$log) {
      self::$log = new MonoLogger('app');
      self::$log->pushHandler(new StreamHandler(__DIR__.'/../../logs/app.log', MonoLogger::DEBUG));
    }
    return self::$log;
  }
}
?>