<?php
// AR: إعدادات Supabase | EN: Supabase config | SA: إعدادات سوبر بيس
// AR: عبّي القيم تحت من لوحة Supabase (Project Settings -> API) | EN: fill from Supabase dashboard | SA: حطها من لوحة سوبر بيس

// AR: رابط المشروع (بدون /) | EN: project URL | SA: رابط المشروع
define('SUPABASE_URL', 'https://aemhgsotertmbqxdiytc.supabase.co'); // AR: رابط مشروعك | EN: your project url | SA: رابط مشروعك // AR: غيّرها | EN: replace | SA: عدلها

// AR: مفتاح anon (للعمليات العامة) | EN: anon key | SA: انون كي
define('SUPABASE_ANON_KEY', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImFlbWhnc290ZXJ0bWJxeGRpeXRjIiwicm9sZSI6ImFub24iLCJpYXQiOjE3Njk3NTA4NTcsImV4cCI6MjA4NTMyNjg1N30.UKaLd9TK3JDIIDOjpggKff-63EIA2KGxcpPBDLBpDVY'); // AR: anon key | EN: anon key | SA: انون كي // AR: من API Keys | EN: from API keys | SA: من الاي بي آي

// AR: مفتاح service_role (للأدمن فقط - لا تحطه بالواجهة) | EN: service role key (server only) | SA: سرفس رول للأدمن بس
define('SUPABASE_SERVICE_KEY', ''); // AR: لا تحطه هنا (خله فـ ENV) | EN: keep in ENV | SA: لا تحطه هنا // AR: مهم جدًا | EN: super sensitive | SA: لا أحد يشوفه

// AR: اسم الجدول | EN: table name | SA: اسم الجدول
define('SUPABASE_TABLE', 'registrations'); // AR: ثابت | EN: fixed | SA: ثابت

// AR: كود دخول الأدمن (بسيط للتجربة) | EN: simple admin access code | SA: كود الأدمن
define('ADMIN_ACCESS_CODE', getenv('ADMIN_ACCESS_CODE') ?: 'rasees2026'); // AR: غيّره | EN: change it | SA: غيّره
