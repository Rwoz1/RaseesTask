<?php
// AR: صفحة البداية - اختيار (تسجيل / أدمن) | EN: landing choose | SA: الصفحة الرئيسية
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rasees Contest Hub</title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="page">
  <main class="landing">
    <header class="hero">
      <div class="hero-badge">Rasees • Contest Hub</div>
      <h1 class="hero-title">تسجيل المسابقة</h1>
      <p class="hero-sub">اختر طريقتك: تسجيل مشارك أو دخول الأدمن</p>
    </header>

    <section class="choice-grid">
      <a class="choice-card glass-effect neo-card" href="user/register.php">
        <div class="choice-icon">📝</div>
        <div class="choice-title">تسجيل مشارك</div>
        <div class="choice-sub">أدخل بياناتك </div>
        <div class="choice-cta btn-gold">ابدأ التسجيل</div>
      </a>

      <a class="choice-card glass-effect neo-card" href="admin/login.php">
        <div class="choice-icon">🛡️</div>
        <div class="choice-title">لوحة الأدمن</div>
        <div class="choice-sub">عرض / تعديل / حذف / تصدير</div>
        <div class="choice-cta btn-ghost">دخول الأدمن</div>
      </a>
    </section>

    <footer class="footer">
      <small>© Rasees • built with PHP + Supabase</small>
    </footer>
  </main>
</body>
</html>
