-- AR: انسخ هذا في Supabase -> SQL Editor -> Run | EN: paste in SQL editor | SA: الصقه وشغله

-- AR: جدول المسجلين | EN: registrations table | SA: جدول التسجيلات
create table if not exists public.registrations (
  id uuid primary key default gen_random_uuid(), -- AR: معرف | EN: id | SA: ايدي
  created_at timestamptz not null default now(), -- AR: وقت | EN: timestamp | SA: وقت
  name text not null, -- AR: اسم | EN: name | SA: اسم
  id_number text not null, -- AR: رقم الهوية | EN: id number | SA: هوية
  email text not null, -- AR: ايميل | EN: email | SA: ايميل
  city text not null -- AR: مدينة | EN: city | SA: مدينة
);

-- AR: تشغيل RLS | EN: enable RLS | SA: تشغيل الحماية
alter table public.registrations enable row level security;

-- AR: سياسة إضافة للجميع (الصفحة العامة) | EN: allow public insert | SA: إضافة للجميع
drop policy if exists "Public can insert" on public.registrations;
create policy "Public can insert"
on public.registrations
for insert
to public
with check (true);

-- AR: (اختياري) منع القراءة العامة | EN: block public select | SA: منع القراءة
drop policy if exists "Public can select" on public.registrations;
-- create policy "Public can select"
-- on public.registrations
-- for select
-- to public
-- using (false);

-- AR: ملاحظة: Service Role يتجاوز RLS (مناسب للأدمن في PHP) | EN: service role bypasses RLS | SA: السرفس رول يتجاوز
