<?php
require __DIR__ . '/supabase_config.php'; // AR: نجيب الإعدادات | EN: load config | SA: نجيب الكونفق

// AR: دالة طلب HTTP بسيطة | EN: tiny HTTP request helper | SA: طلب بسيط
function sb_request(string $method, string $path, array $query = [], $body = null, bool $useServiceKey = false): array {
  // AR: نكوّن الرابط | EN: build url | SA: نسوي اللينك
  $url = rtrim(SUPABASE_URL, '/') . $path; // AR: رابط كامل | EN: full url | SA: الرابط كامل

  // AR: نحط query string لو موجود | EN: add query string | SA: نضيف باراميترز
  if (!empty($query)) { $url .= '?' . http_build_query($query); } // AR: باراميترز | EN: params | SA: باراميترز

  // AR: نختار المفتاح (لو service key فاضي نرجع للـ anon) | EN: choose key (fallback to anon if service key empty) | SA: نختار المفتاح (لو السرفس فاضي خذ انون)
  $key = ($useServiceKey && defined('SUPABASE_SERVICE_KEY') && SUPABASE_SERVICE_KEY) ? SUPABASE_SERVICE_KEY : SUPABASE_ANON_KEY; // AR: أدمن/عام | EN: admin/public | SA: أدمن/عام

  // AR: هيدرز Supabase | EN: Supabase headers | SA: الهيدرز
  $headers = [
    'apikey: ' . $key, // AR: مفتاح API | EN: apikey header | SA: ابكي
    'Authorization: Bearer ' . $key, // AR: توكن | EN: bearer token | SA: بيرر
    'Content-Type: application/json', // AR: JSON | EN: JSON | SA: جيسون
    'Prefer: return=representation', // AR: يرجع البيانات بعد العملية | EN: return row | SA: يرجع الداتا
  ];

  // AR: خيار تجاوز SSL في لوكل (مفيد في MAMP لو صارت مشكلة شهادة) | EN: insecure SSL for local dev | SA: لو SSL يعلق
  $insecureSSL = (getenv('SUPABASE_INSECURE_SSL') === '1') || in_array($_SERVER['HTTP_HOST'] ?? '', ['localhost', '127.0.0.1']); // AR: لوكل؟ | EN: local? | SA: لوكل؟

  // AR: لو cURL موجود نستخدمه | EN: prefer cURL | SA: نفضل كرِل
  if (function_exists('curl_init')) {
    $ch = curl_init($url); // AR: افتح | EN: init | SA: افتح
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // AR: رجّع الرد كنص | EN: return response | SA: يرجّعه نص
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method); // AR: نوع الطلب | EN: HTTP method | SA: ميثود
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); // AR: الهيدرز | EN: headers | SA: هيدرز
    if ($insecureSSL) {
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // AR: لا تتحقق من الشهادة | EN: skip cert verify | SA: تجاهل الشهادة
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // AR: تجاهل الهوست | EN: skip host verify | SA: تجاهل الهوست
    }
    if ($body !== null) {
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body, JSON_UNESCAPED_UNICODE)); // AR: JSON encode | EN: encode json | SA: نحول لجيسون
    }
    $raw = curl_exec($ch); // AR: نفذ | EN: execute | SA: نفذ
    $err = curl_error($ch); // AR: خطأ لو صار | EN: error | SA: ايرور
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE); // AR: كود الاستجابة | EN: status code | SA: ستاتس كود
    curl_close($ch); // AR: اقفل | EN: close | SA: سكّر
    if ($raw === false) { return ['ok' => false, 'code' => 0, 'error' => $err ?: 'Unknown curl error', 'data' => null]; } // AR: فشل | EN: failed | SA: فشل
  } else {
    // AR: بديل بدون cURL (لو السيرفر ناقصه) | EN: fallback via file_get_contents | SA: بديل
    $ctx = stream_context_create([
      'http' => [
        'method' => $method,
        'header' => implode("\r\n", $headers),
        'content' => $body !== null ? json_encode($body, JSON_UNESCAPED_UNICODE) : '',
        'ignore_errors' => true,
      ],
      'ssl' => [
        'verify_peer' => !$insecureSSL,
        'verify_peer_name' => !$insecureSSL,
      ],
    ]);
    $raw = @file_get_contents($url, false, $ctx);
    $code = 0;
    if (isset($http_response_header) && is_array($http_response_header)) {
      foreach ($http_response_header as $h) {
        if (preg_match('#^HTTP/\\S+\\s+(\\d{3})#', $h, $m)) { $code = (int)$m[1]; break; }
      }
    }
    if ($raw === false) { return ['ok' => false, 'code' => 0, 'error' => 'HTTP request failed (no cURL).', 'data' => null]; }
  }

  $data = json_decode($raw, true); // AR: نفك JSON | EN: parse json | SA: نفك الجيسون
  $ok = $code >= 200 && $code < 300; // AR: نجاح | EN: success flag | SA: تمام ولا لا

  return ['ok' => $ok, 'code' => $code, 'error' => $ok ? null : $raw, 'data' => $data]; // AR: نرجع النتيجة | EN: return | SA: نرجع
}

// AR: إنشاء سجل جديد | EN: insert registration | SA: إضافة تسجيل
function sb_insert_registration(array $row): array {
  return sb_request('POST', '/rest/v1/' . SUPABASE_TABLE, [], [$row], false); // AR: insert | EN: insert | SA: إضافة
}

// AR: جلب قائمة المسجلين (للأدمن) | EN: list registrations (admin) | SA: نجيب اللي مسجلين
function sb_list_registrations(): array {
  return sb_request('GET', '/rest/v1/' . SUPABASE_TABLE, [
    'select' => 'id,created_at,name,id_number,email,city',
    'order'  => 'created_at.desc',
  ], null, true); // AR: لو service key مو موجود راح يطيح على anon تلقائي | EN: falls back to anon | SA: تلقائي
}

// AR: حذف مسجل | EN: delete registration | SA: حذف
function sb_delete_registration(string $id): array {
  return sb_request('DELETE', '/rest/v1/' . SUPABASE_TABLE, [
    'id' => 'eq.' . $id,
  ], null, true); // AR: حذف | EN: delete | SA: حذف
}

// AR: تعديل مسجل | EN: update registration | SA: تعديل
function sb_update_registration(string $id, array $patch): array {
  return sb_request('PATCH', '/rest/v1/' . SUPABASE_TABLE, [
    'id' => 'eq.' . $id,
  ], $patch, true); // AR: تعديل | EN: patch | SA: تعديل
}
