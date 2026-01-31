<?php
require __DIR__ . "/../includes/auth.php"; // AR: حماية | EN: guard | SA: حماية
require __DIR__ . "/../includes/supabase_client.php"; // AR: Supabase | EN: Supabase | SA: سوبر بيس

$list = sb_list_registrations(); // AR: جلب | EN: fetch | SA: جلب
$rows = $list["ok"] ? ($list["data"] ?? []) : []; // AR: صفوف | EN: rows | SA: صفوف

header("Content-Type: text/csv; charset=utf-8"); // AR: CSV | EN: CSV | SA: CSV
header("Content-Disposition: attachment; filename=rasees_registrations.csv"); // AR: اسم الملف | EN: name | SA: اسم

$out = fopen("php://output", "w"); // AR: فتح | EN: open | SA: افتح
fputcsv($out, ["id","created_at","name","id_number","email","city"]); // AR: رؤوس | EN: headers | SA: رؤوس

foreach($rows as $r){ // AR: لكل صف | EN: loop | SA: لوب
  fputcsv($out, [
    $r["id"] ?? "",
    $r["created_at"] ?? "",
    $r["name"] ?? "",
    $r["id_number"] ?? "",
    $r["email"] ?? "",
    $r["city"] ?? "",
  ]); // AR: سطر | EN: line | SA: سطر
}
fclose($out); exit; // AR: خلص | EN: done | SA: خلص
