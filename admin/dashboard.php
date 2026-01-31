<?php
require __DIR__ . "/../includes/auth.php"; // AR: حماية الأدمن | EN: admin guard | SA: حماية الأدمن
require __DIR__ . "/../includes/supabase_client.php"; // AR: Supabase | EN: Supabase | SA: سوبر بيس

// AR: تنفيذ أوامر (حذف/تعديل/تصدير) | EN: handle actions | SA: أوامر
if ($_SERVER["REQUEST_METHOD"] === "POST") { // AR: لو POST | EN: if POST | SA: لو بوست
  $action = $_POST["action"] ?? ""; // AR: نوع العملية | EN: action | SA: اكشن

  // AR: تصدير Excel (CSV) | EN: export CSV | SA: تصدير
  if ($action === "export") { // AR: تصدير | EN: export | SA: تصدير
    $list = sb_list_registrations(); // AR: نجيب البيانات | EN: fetch | SA: نجيب
    $rows = $list["ok"] ? ($list["data"] ?? []) : []; // AR: صفوف | EN: rows | SA: صفوف

    header("Content-Type: text/csv; charset=utf-8"); // AR: نوع الملف | EN: content type | SA: نوع
    header("Content-Disposition: attachment; filename=rasees_registrations.csv"); // AR: اسم الملف | EN: filename | SA: الاسم

    $out = fopen("php://output", "w"); // AR: نكتب على الإخراج | EN: output stream | SA: نكتب
    fputcsv($out, ["id","created_at","name","id_number","email","city"]); // AR: رؤوس | EN: headers | SA: عناوين

    foreach ($rows as $r) { // AR: لكل صف | EN: loop | SA: لوب
      fputcsv($out, [
        $r["id"] ?? "",
        $r["created_at"] ?? "",
        $r["name"] ?? "",
        $r["id_number"] ?? "",
        $r["email"] ?? "",
        $r["city"] ?? "",
      ]); // AR: سطر | EN: line | SA: سطر
    }
    fclose($out); exit; // AR: اطلع | EN: done | SA: خلص
  }

  // AR: حذف | EN: delete | SA: حذف
  if ($action === "delete") { // AR: حذف | EN: delete | SA: حذف
    $id = $_POST["id"] ?? ""; // AR: id | EN: id | SA: ايدي
    if ($id) { sb_delete_registration($id); } // AR: نفذ | EN: do it | SA: نفذ
    header("Location: dashboard.php"); exit; // AR: رجوع | EN: back | SA: رجوع
  }

  // AR: تعديل | EN: edit | SA: تعديل
  if ($action === "edit") { // AR: تعديل | EN: edit | SA: تعديل
    $id = $_POST["id"] ?? ""; // AR: id | EN: id | SA: ايدي
    if ($id) { // AR: لو موجود | EN: if exists | SA: لو موجود
      $patch = [ // AR: بيانات التعديل | EN: patch payload | SA: الباتش
        "name"      => trim($_POST["name"] ?? ""),
        "id_number" => trim($_POST["id_number"] ?? ""),
        "email"     => trim($_POST["email"] ?? ""),
        "city"      => trim($_POST["city"] ?? ""),
      ];
      sb_update_registration($id, $patch); // AR: نفذ تعديل | EN: patch | SA: عدل
    }
    header("Location: dashboard.php"); exit; // AR: رجوع | EN: back | SA: رجوع
  }
}

// AR: عرض البيانات | EN: view data | SA: عرض
$list = sb_list_registrations(); // AR: نجيب قائمة | EN: fetch list | SA: قائمة
$rows = $list["ok"] ? ($list["data"] ?? []) : []; // AR: صفوف | EN: rows | SA: صفوف
$loadError = $list["ok"] ? "" : "تعذر جلب البيانات من Supabase. تأكد من المفاتيح والسياسات."; // AR: خطأ | EN: error | SA: خطأ
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>لوحة التحكم - المسجلين</title>
  <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="page admin-page">
  <div class="admin-layout">
    <!-- AR: الشريط الجانبي | EN: sidebar | SA: السايد بار -->
    <aside class="sidebar glass-effect neo-card">
      <div class="sidebar-brand">
        <div class="brand-mark">R</div>
        <div class="brand-text">
          <div class="brand-title">Rasees Contest</div>
          <div class="brand-sub">Admin Dashboard</div>
        </div>
      </div>

      <nav class="sidebar-nav">
        <a class="nav-item active" href="dashboard.php">المسجلين</a>
        <a class="nav-item" href="logout.php">تسجيل خروج</a>
        <a class="nav-item" href="../index.php">الصفحة الرئيسية</a>
      </nav>

      <div class="sidebar-footer">
      </div>
    </aside>

    <!-- AR: المحتوى | EN: content | SA: المحتوى -->
    <main class="content">
      <header class="topbar">
        <h1 class="page-title">المسجلين</h1>
        <div class="topbar-actions">
          <form method="POST">
            <input type="hidden" name="action" value="export">
            <button class="btn-gold" type="submit">تحميل Excel</button>
          </form>
        </div>
      </header>

      <?php if ($loadError): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($loadError) ?></div>
      <?php endif; ?>

      <section class="cards-grid">
        <div class="stat-card glass-effect neo-card">
          <div class="stat-label">عدد المسجلين</div>
          <div class="stat-value"><?= count($rows) ?></div>
        </div>
        <div class="stat-card glass-effect neo-card">
          <div class="stat-label">آخر تسجيل</div>
          <div class="stat-value"><?= htmlspecialchars($rows[0]["created_at"] ?? "-") ?></div>
        </div>
      </section>

      <section class="table-card glass-effect neo-card">
        <div class="table-header">
          <h2 class="table-title">قائمة المسجلين</h2>
          <p class="table-sub">تقدر تعدّل أو تحذف مباشرة</p>
        </div>

        <div class="table-wrap">
          <table class="table">
            <thead>
              <tr>
                <th>الاسم</th>
                <th>رقم الهوية</th>
                <th>البريد</th>
                <th>المدينة</th>
                <th>التاريخ</th>
                <th>إجراءات</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($rows as $r): ?>
                <tr>
                  <td data-label="الاسم"><?= htmlspecialchars($r["name"] ?? "") ?></td>
                  <td data-label="رقم الهوية"><?= htmlspecialchars($r["id_number"] ?? "") ?></td>
                  <td data-label="البريد"><?= htmlspecialchars($r["email"] ?? "") ?></td>
                  <td data-label="المدينة"><?= htmlspecialchars($r["city"] ?? "") ?></td>
                  <td data-label="التاريخ"><?= htmlspecialchars($r["created_at"] ?? "") ?></td>
                  <td data-label="إجراءات">
                    <!-- AR: زر تعديل يفتح مودال | EN: edit opens modal | SA: تعديل يفتح مودال -->
                    <button class="btn-ghost" type="button"
                      onclick='openEditModal(<?= json_encode($r, JSON_UNESCAPED_UNICODE) ?>)'>تعديل</button>

                    <!-- AR: حذف | EN: delete | SA: حذف -->
                    <form method="POST" class="inline" onsubmit="return confirm('متأكد تحذف؟');">
                      <input type="hidden" name="action" value="delete">
                      <input type="hidden" name="id" value="<?= htmlspecialchars($r["id"] ?? "") ?>">
                      <button class="btn-danger" type="submit">حذف</button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>

              <?php if (empty($rows)): ?>
                <tr><td colspan="6" class="empty">لا يوجد مسجلين حالياً</td></tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </section>
    </main>
  </div>

  <!-- AR: مودال التعديل | EN: edit modal | SA: مودال -->
  <div class="modal" id="editModal" aria-hidden="true">
    <div class="modal-backdrop" onclick="closeEditModal()"></div>
    <div class="modal-card glass-effect neo-card">
      <div class="modal-head">
        <h3>تعديل بيانات</h3>
        <button class="icon-btn" onclick="closeEditModal()">✕</button>
      </div>

      <form method="POST" class="form">
        <input type="hidden" name="action" value="edit">
        <input type="hidden" name="id" id="edit_id">

        <label class="field">
          <span class="label">الاسم</span>
          <input class="input-styled" name="name" id="edit_name" required>
        </label>

        <label class="field">
          <span class="label">رقم الهوية</span>
          <input class="input-styled" name="id_number" id="edit_id_number" required>
        </label>

        <label class="field">
          <span class="label">البريد الإلكتروني</span>
          <input class="input-styled" name="email" id="edit_email" type="email" required>
        </label>

        <label class="field">
          <span class="label">المدينة</span>
          <input class="input-styled" name="city" id="edit_city" required>
        </label>

        <div class="modal-actions">
          <button class="btn-gold" type="submit">حفظ</button>
          <button class="btn-ghost" type="button" onclick="closeEditModal()">إلغاء</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    // AR: فتح المودال وتعبئة البيانات | EN: open modal fill data | SA: نفتح المودال
    function openEditModal(row){
      document.getElementById('edit_id').value = row.id || '';
      document.getElementById('edit_name').value = row.name || '';
      document.getElementById('edit_id_number').value = row.id_number || '';
      document.getElementById('edit_email').value = row.email || '';
      document.getElementById('edit_city').value = row.city || '';
      const m = document.getElementById('editModal');
      m.classList.add('open');
      m.setAttribute('aria-hidden','false');
    }
    // AR: إغلاق | EN: close | SA: إغلاق
    function closeEditModal(){
      const m = document.getElementById('editModal');
      m.classList.remove('open');
      m.setAttribute('aria-hidden','true');
    }
  </script>
</body>
</html>
