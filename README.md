# Rasees Contest Hub (PHP + Supabase)

## 1) تشغيل المشروع على MAMP (زي الطفل 😄)

1. افتح MAMP
2. شغّل **Apache**
3. افتح مجلد المشروع وحطه هنا:
   - `/Applications/MAMP/htdocs/contest-registration/`
4. افتح المتصفح:
   - `http://localhost:8888/contest-registration/`

## 2) تجهيز Supabase

### A) سوّ جدول البيانات
1. افتح Supabase
2. روح: **SQL Editor**
3. انسخ محتوى الملف:
   - `supabase_setup.sql`
4. اضغط **Run**

### B) خذ المفاتيح
1. Supabase -> **Project Settings** -> **API**
2. انسخ:
   - Project URL
   - anon public key
   - service_role key (خطير لا تخليه مكشوف)

### C) حط المفاتيح في المشروع
افتح الملف:
- `includes/supabase_config.php`

وغيّر:
- `SUPABASE_URL`
- `SUPABASE_ANON_KEY`
- `SUPABASE_SERVICE_KEY`
- `ADMIN_ACCESS_CODE` (كود دخول الأدمن)

> ملاحظة: لو رفعت المشروع على استضافة، خَلّ المفاتيح في ENV variables أحسن.

## 3) الروابط
- الصفحة الرئيسية: `/`
- تسجيل مشارك: `/user/register.php`
- لوحة الأدمن: `/admin/login.php`  (تدخل بكود الأدمن)

## 4) Excel
زر **تحميل Excel** يطلع ملف CSV.
Excel يفتحه طبيعي.
