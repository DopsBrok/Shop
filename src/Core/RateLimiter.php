<?php
class RateLimiter {
  private $pdo;
  private $maxAttempts = 5;
  private $decaySeconds = 300;
  public function __construct(PDO $pdo) {
    $this->pdo = $pdo;
  }
  public function hit($key) {
    $stmt = $this->pdo->prepare(
      "INSERT INTO login_attempts (ip, attempt_time) VALUES (:ip, NOW())"
    );
    $stmt->execute(['ip' => $key]);
  }
  public function tooManyAttempts($key) {
    $stmt = $this->pdo->prepare(
      "SELECT COUNT(*) FROM login_attempts
       WHERE ip = :ip AND attempt_time > (NOW() - INTERVAL :decay SECOND)"
    );
    $stmt->execute(['ip' => $key, 'decay' => $this->decaySeconds]);
    return $stmt->fetchColumn() >= $this->maxAttempts;
  }
  public function clearAttempts($key) {
    $stmt = $this->pdo->prepare("DELETE FROM login_attempts WHERE ip = :ip");
    $stmt->execute(['ip' => $key]);
  }
}
?>