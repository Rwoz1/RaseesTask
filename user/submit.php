<?php
require __DIR__ . "/../includes/supabase_client.php"; // AR: عميل Supabase | EN: Supabase client | SA: كلاينت سوبر بيس

// AR: لو مو POST رجّعه | EN: guard non-POST | SA: حماية
if ($_SERVER["REQUEST_METHOD"] !== "POST") { header("Location: register.php"); exit; } // AR: حماية | EN: guard | SA: حماية

// AR: نقرأ المدخلات | EN: read inputs | SA: ناخذ المدخلات
$name      = trim($_POST["name"] ?? "");       // AR: الاسم | EN: name | SA: الاسم
$id_number = trim($_POST["id_number"] ?? "");  // AR: الهوية | EN: id number | SA: الهوية
$email     = trim($_POST["email"] ?? "");      // AR: الإيميل | EN: email | SA: الايميل
$city      = trim($_POST["city"] ?? "");       // AR: المدينة | EN: city | SA: المدينة

// AR: تحقق بسيط | EN: tiny validation | SA: تحقق بسيط
if ($name === "" || $id_number === "" || $email === "" || $city === "") { // AR: لو ناقص | EN: missing fields | SA: ناقص
  header("Location: register.php?e=missing"); exit; // AR: رجّع مع خطأ | EN: back with error | SA: رجعه
}

// AR: نسوي insert في Supabase | EN: insert into Supabase | SA: نضيف بالسوبر بيس
$res = sb_insert_registration([ // AR: صف واحد | EN: one row | SA: صف
  'name'      => $name, // AR: عمود name | EN: name col | SA: عمود الاسم
  'id_number' => $id_number, // AR: عمود الهوية | EN: id_number col | SA: رقم الهوية
  'email'     => $email, // AR: عمود الايميل | EN: email col | SA: الايميل
  'city'      => $city, // AR: عمود المدينة | EN: city col | SA: المدينة
]);

// AR: لو فشل نرجع برسالة | EN: if failed, back with error | SA: لو خرب
if (!$res['ok']) { // AR: فشل | EN: failed | SA: فشل
  header("Location: register.php?e=save"); exit; // AR: خطأ حفظ | EN: save error | SA: خطأ حفظ
}

// AR: نجاح - نودّي المستخدم لصفحة نجاح بسيطة | EN: success -> success page | SA: نجاح
header("Location: success.php"); exit; // AR: تحويل | EN: redirect | SA: تحويل
