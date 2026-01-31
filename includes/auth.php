<?php
// AR: جلسات الأدمن | EN: admin session helper | SA: سيشن الأدمن
if (session_status() === PHP_SESSION_NONE) { session_start(); } // AR: شغل السيشن | EN: start session | SA: شغله

// AR: تأكد أنه أدمن | EN: require admin login | SA: لازم أدمن
function require_admin(): void { // AR: دالة حماية | EN: guard | SA: حماية
  if (empty($_SESSION["admin_logged_in"])) { // AR: مو داخل | EN: not logged | SA: مو داخل
    header("Location: login.php"); exit; // AR: روح تسجيل الدخول | EN: go login | SA: للّوقن
  }
}

require_admin(); // AR: نفذ الحماية مباشرة | EN: run guard | SA: نفذ
