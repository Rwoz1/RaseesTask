<?php
// AR: صفحة تسجيل المشاركة | EN: registration page | SA: صفحة التسجيل
$err = $_GET["e"] ?? ""; // AR: كود خطأ | EN: error code | SA: ايرور
$msg = ""; // AR: رسالة | EN: msg | SA: رسالة
if ($err === "missing") { $msg = "فضلاً عبّي كل الحقول"; } // AR: ناقص | EN: missing | SA: ناقص
if ($err === "save") { $msg = "صار خطأ بالحفظ، جرب مرة ثانية"; } // AR: حفظ | EN: save | SA: حفظ
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>تسجيل المسابقة</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="page">
  <main class="auth-shell">
    <section class="auth-card glass-effect neo-card">
      <header class="auth-header">
        <div class="hero-badge">Rasees • Contest</div>
        <h1 class="auth-title">تسجيل المشاركة</h1>
        <p class="auth-sub">دخل بياناتك </p>
      </header>

      <?php if ($msg): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($msg) ?></div>
      <?php endif; ?>

      <form action="submit.php" method="POST" class="form">
        <label class="field">
          <span class="label">الاسم</span>
          <input class="input-styled" type="text" name="name" placeholder="عبدالعزيز" required>
        </label>

        <label class="field">
          <span class="label">رقم الهوية</span>
          <input class="input-styled" type="text" name="id_number" placeholder="10xxxxxxxx" required>
        </label>

        <label class="field">
          <span class="label">البريد الإلكتروني</span>
          <input class="input-styled" type="email" name="email" placeholder="name@email.com" required>
        </label>

        <label class="field">
          <span class="label">المدينة</span>
          <input class="input-styled" type="text" name="city" placeholder="Riyadh" required>
        </label>

        <button class="btn-gold w-full" type="submit">إرسال</button>
        <a class="link-muted" href="../index.php">رجوع للرئيسية</a>
      </form>
    </section>
  </main>
</body>
</html>
