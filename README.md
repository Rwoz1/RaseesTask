
1) تشغيل المشروع محليًا (Local Setup)

AR:
	1.	افتح MAMP
	2.	شغّل Apache
	3.	افتح مجلد المشروع وحطه في المسار التالي:

/Applications/MAMP/htdocs/contest-registration/


	4.	افتح المتصفح وروح للرابط:

http://localhost:8888/contest-registration/



EN:
	1.	Open MAMP
	2.	Start Apache
	3.	Place the project folder here:

/Applications/MAMP/htdocs/contest-registration/


	4.	Open your browser and go to:

http://localhost:8888/contest-registration/



⸻

2) إعداد Supabase (Supabase Setup)

A) إنشاء جدول البيانات (Create Database Table)

AR:
	1.	افتح Supabase
	2.	ادخل على SQL Editor
	3.	انسخ محتوى الملف:

supabase_setup.sql


	4.	اضغط Run

EN:
	1.	Open Supabase
	2.	Go to SQL Editor
	3.	Copy the content of:

supabase_setup.sql


	4.	Click Run

⸻

B) استخراج المفاتيح (Get API Keys)

AR:
	1.	Supabase → Project Settings → API
	2.	انسخ التالي:
	•	Project URL
	•	anon public key
	•	service_role key ⚠️ (خطير – لا تخليه مكشوف)

EN:
	1.	Supabase → Project Settings → API
	2.	Copy the following:
	•	Project URL
	•	anon public key
	•	service_role key ⚠️ (Sensitive – never expose it)

⸻

C) ربط المفاتيح بالمشروع (Connect Keys to Project)

AR:
افتح الملف:

includes/supabase_config.php

وعدّل القيم التالية:
	•	SUPABASE_URL
	•	SUPABASE_ANON_KEY
	•	SUPABASE_SERVICE_KEY
	•	ADMIN_ACCESS_CODE (كود دخول الأدمن)

EN:
Open the file:

includes/supabase_config.php

Update the following values:
	•	SUPABASE_URL
	•	SUPABASE_ANON_KEY
	•	SUPABASE_SERVICE_KEY
	•	ADMIN_ACCESS_CODE (admin login code)

ملاحظة | Note:
	•	AR: إذا رفعت المشروع على استضافة، يفضّل تحط المفاتيح في ENV variables
	•	EN: If deployed online, store keys in environment variables for security

⸻

3) روابط الصفحات (Project Routes)

AR:
	•	الصفحة الرئيسية: /
	•	تسجيل مشارك: /user/register.php
	•	لوحة الأدمن: /admin/login.php (الدخول بكود الأدمن)

EN:
	•	Home page: /
	•	User registration: /user/register.php
	•	Admin panel: /admin/login.php (access via admin code)

⸻

4) ملف Excel (CSV Export)

AR:
زر تحميل Excel يطلع ملف CSV
ملف CSV يفتح مباشرة في Excel بدون مشاكل.

EN:
The Download Excel button generates a CSV file.
CSV files open normally in Excel.

⸻

