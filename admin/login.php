<?php
session_start(); // AR: نبدأ السيشن | EN: start session | SA: نشغل السيشن
require __DIR__ . "/../includes/supabase_config.php"; // AR: إعدادات | EN: config | SA: كونفق

// AR: لو الأدمن داخل خلاص | EN: already logged in | SA: داخل
if (!empty($_SESSION["admin_logged_in"])) { header("Location: dashboard.php"); exit; } // AR: تحويل | EN: redirect | SA: تحويل

// AR: استقبال الفورم | EN: handle form | SA: نعالج الفورم
$error = ""; // AR: رسالة خطأ | EN: error msg | SA: رسالة خطأ
if ($_SERVER["REQUEST_METHOD"] === "POST") { // AR: لو ضغط تسجيل | EN: on submit | SA: لو ضغط
  $code = trim($_POST["code"] ?? ""); // AR: كود الأدمن | EN: admin code | SA: كود الأدمن
  if ($code === ADMIN_ACCESS_CODE) { // AR: لو صحيح | EN: match | SA: إذا صح
    $_SESSION["admin_logged_in"] = true; // AR: نخزن دخول | EN: store login | SA: نخزنه
    header("Location: dashboard.php"); exit; // AR: للوحة التحكم | EN: go dashboard | SA: للداش
  }
  $error = "الكود غير صحيح"; // AR: خطأ | EN: wrong | SA: غلط
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>لوحة التحكم - تسجيل دخول</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="page">
  <main class="auth-shell">
    <section class="auth-card glass-effect neo-card">
      <header class="auth-header">
        <h1 class="auth-title">لوحة التحكم</h1>
        <p class="auth-sub">ادخل كود الأدمن للتجربة</p>
      </header>

      <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>

      <form method="POST" class="form">
        <!-- AR: حقل كود الأدمن بتصميم Uiverse (نفس الكود اللي عطيتني) | EN: admin code field using your Uiverse snippet | SA: حقل كود الأدمن بنفس ستايل يوفرس -->
        <div class="input__container admin-code">
          <div class="shadow__input"></div>
          <button class="input__button__shadow" type="button" aria-label="admin icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" role="img" aria-hidden="true">
              <path d="M0 0h24v24H0z" fill="none"></path>
              <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
            </svg>
          </button>
          <input type="password" name="code" class="input__search" placeholder="اكتب كود الأدمن" required />
        </div>
        <button class="btn-gold w-full" type="submit">دخول</button>
        <a class="link-muted" href="../index.php">رجوع للرئيسية</a>
      </form>
    </section>
  </main>
</body>
</html>
