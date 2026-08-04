# نشر مشروع RIGHT على cPanel (Subdomain)

دليل خطوة بخطوة لرفع الموقع على **subdomain** (مثل `demo.example.com`) حتى يراجعه العميل.

> **الترتيب الموصى به:** GitHub أولاً → ثم clone على cPanel.  
> راجع [`GITHUB_SETUP.md`](GITHUB_SETUP.md) لرفع المشروع على GitHub.

---

## 0) إذا رفعت على GitHub — على cPanel

```bash
cd ~
git clone https://github.com/YOUR_USERNAME/right-center.git right
cd right
```

ثم أكمل من **القسم 4** (قاعدة البيانات) و **القسم 7** (أوامر Laravel).

للتحديثات لاحقاً:
```bash
cd ~/right
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 1) المتطلبات على السيرفر

| البند | المطلوب |
|--------|---------|
| PHP | **8.2** أو أحدث |
| Composer | متوفر في Terminal (أو `composer.phar`) |
| MySQL | قاعدة بيانات (مُفضّل للإنتاج) |
| Extensions | `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `fileinfo`, `curl`, `intl`, `gd` أو `imagick`, `zip`, `bcmath` |

**من cPanel:**
1. **MultiPHP Manager** → اختر PHP **8.2+** للـ subdomain.
2. **Select PHP Version / PHP Extensions** → فعّل الإضافات أعلاه.

---

## 2) قبل الرفع — على جهازك (Windows / XAMPP)

نفّذ هذه الأوامر **محلياً** داخل مجلد المشروع `c:\xampp\htdocs\right`:

```bash
# بناء ملفات CSS/JS (مهم — public/build غير موجود على Git)
npm install
npm run build

# تثبيت حزم PHP للإنتاج (اختياري — أو تثبتها على السيرفر)
composer install --no-dev --optimize-autoloader
```

### ماذا ترفع؟

**ارفع:**
- كل ملفات المشروع **ما عدا**:
  - `node_modules/`
  - `.git/` (اختياري)
  - `.env` (لا ترفع ملف البيئة المحلي)
  - `storage/logs/*.log`

**تأكد أن هذه المجلدات/الملفات موجودة بعد الرفع:**
- `public/build/` (من `npm run build`)
- `public/js/filament/forms/components/rich-editor.js`
- `public/images/` (بما فيها `logo_ar.jpeg` إن كنت تستخدمه)
- `vendor/` (إما ترفعه أو تثبته على السerver بـ `composer install`)

**طريقة الرفع:** File Manager أو FTP أو Git — المهم أن يكون مسار المشروع مثل:
```
/home/USERNAME/right/
```
(يمكن أي اسم للمجلد — المهم أن **Document Root** يشير إلى `public/` داخله)

---

## 3) إعداد Subdomain في cPanel

1. **Domains → Subdomains** (أو **Create Domain**)
2. أنشئ: `demo.example.com`
3. **Document Root** — اضبطه على:
   ```
   /home/USERNAME/right/public
   ```
   > هذا الأفضل. Laravel يجب أن يُخدم من مجلد `public` فقط.

إذا **لا يمكن** تغيير Document Root، راجع [القسم 8 — البديل](#8-بديل-إذا-لم-تستطع-توجيه-document-root-إلى-public).

---

## 4) إنشاء قاعدة بيانات MySQL

1. **MySQL® Databases**
2. أنشئ Database: مثلاً `username_right`
3. أنشئ User + Password
4. **Add User To Database** → أعطِ **ALL PRIVILEGES**

احفظ:
- `DB_DATABASE`
- `DB_USERNAME`
- `DB_PASSWORD`
- `DB_HOST` → غالباً `localhost`

---

## 5) أوامر Terminal على cPanel

افتح **Terminal** في cPanel ثم:

```bash
# 1) ادخل مجلد المشروع (عدّل USERNAME واسم المجلد)
cd ~/right

# 2) تحقق من PHP
php -v
# يجب 8.2+

# 3) تثبيت Composer (إذا vendor غير مرفوع)
composer install --no-dev --optimize-autoloader

# 4) إنشاء ملف البيئة
cp .env.example .env
nano .env
# أو عدّله من File Manager → Edit
```

---

## 6) محتوى ملف `.env` على السيرفر

عدّل القيم التالية (مثال):

```env
APP_NAME="RIGHT Center"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://demo.example.com

APP_LOCALE=ar
APP_FALLBACK_LOCALE=en

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=username_right
DB_USERNAME=username_rightuser
DB_PASSWORD=YOUR_STRONG_PASSWORD

SESSION_DRIVER=database
QUEUE_CONNECTION=database
CACHE_STORE=database

FILESYSTEM_DISK=public

MAIL_MAILER=smtp
MAIL_HOST=mail.example.com
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="info@right-center.org"
MAIL_FROM_NAME="${APP_NAME}"
```

> **مهم:** `APP_URL` يجب أن يطابق رابط الـ subdomain **بالضبط** (http/https) — الصور والملفات المرفوعة تعتمد عليه.

---

## 7) أوامر Laravel بعد ضبط `.env`

```bash
cd ~/right

# مفتاح التطبيق (مرة واحدة)
php artisan key:generate

# جداول قاعدة البيانات
php artisan migrate --force

# بيانات تجريبية + حساب الأدمن (مرة واحدة للعرض على العميل)
php artisan db:seed --force

# رابط مجلد التخزين للصور والملفات
php artisan storage:link

# صلاحيات المجلدات
chmod -R 775 storage bootstrap/cache

# تخزين مؤقت للإنتاج (أسرع)
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan filament:optimize
```

### حساب لوحة التحكم بعد `db:seed`

| | |
|---|---|
| الرابط | `https://demo.example.com/admin` |
| البريد | `admin@right-center.org` |
| كلمة المرور | `password` |

> **غيّر كلمة المرور فوراً** بعد أول دخول في بيئة العرض.

---

## 8) بديل: إذا لم تستطع توجيه Document Root إلى `public`

ضع المشروع خارج `public_html` مثلاً في `~/right/`  
وانسخ **محتويات** `public/` فقط إلى مجلد الـ subdomain، ثم عدّل `index.php`:

في أول سطرين بعد `define('LARAVEL_START'...)` — المسارات في `index.php`:

```php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
```

إذا كان `index.php` داخل مجلد الـ subdomain والمشروع في `~/right/`:

```php
require __DIR__.'/../../right/vendor/autoload.php';
$app = require_once __DIR__.'/../../right/bootstrap/app.php';
```

(عدّل المسار حسب مكان المجلدات عندك)

---

## 9) نقل المحتوى من جهازك المحلي (اختياري)

المشروع محلياً يستخدم **SQLite**. على cPanel الأفضل **MySQL**.

**خيار أ — بداية جديدة (الأسهل):**
```bash
php artisan migrate --force
php artisan db:seed --force
```
ثم أعد رفع المحتوى من لوحة التحكم.

**خيار ب — نقل بيانات SQLite:**
1. صدّر البيانات محلياً أو استخدم أداة تحويل SQLite → MySQL.
2. أو ارفع ملف `database/database.sqlite` واستخدم `DB_CONNECTION=sqlite` في `.env`:
   ```env
   DB_CONNECTION=sqlite
   # DB_DATABASE=  ← اتركه فارغاً؛ Laravel يستخدم database/database.sqlite
   ```
   وتأكد أن الملف **قابل للكتابة**:
   ```bash
   chmod 664 database/database.sqlite
   chmod 775 database
   ```
   > بعض استضافات cPanel لا تدعم SQLite — MySQL أنسب.

**خيار ج — رفع ملفات الصور المرفوعة:**
إذا رفعت صوراً من الأدمن محلياً، انسخ:
```
storage/app/public/
```
إلى نفس المسار على السيرفر، ثم:
```bash
php artisan storage:link
```

---

## 10) SSL (HTTPS)

1. **SSL/TLS Status** → فعّل **AutoSSL** أو Let's Encrypt للـ subdomain.
2. بعد التفعيل حدّث `.env`:
   ```env
   APP_URL=https://demo.example.com
   ```
3. ثم:
   ```bash
   php artisan config:cache
   ```

---

## 11) اختبار بعد النشر

| # | ماذا تختبر |
|---|------------|
| 1 | الصفحة الرئيسية `/` |
| 2 | النسخة الإنجليزية `/en` |
| 3 | لوحة التحكم `/admin` |
| 4 | رفع صورة شريك أو نشاط — تظهر في الموقع؟ |
| 5 | نموذج التواصل / طلب عرض سعر |
| 6 | لا يظهر `APP_DEBUG` أو stack trace للزائر |

---

## 12) مشاكل شائعة وحلولها

### 500 Internal Server Error
```bash
# اقرأ آخر خطأ
tail -50 storage/logs/laravel.log

# امسح الكاش وأعد البناء
php artisan optimize:clear
php artisan config:cache
```
- تحقق من صلاحيات `storage/` و `bootstrap/cache/` (775).
- تحقق من `APP_KEY` موجود في `.env`.

### الصفحة بيضاء / CSS لا يعمل
- تأكد أن `public/build/manifest.json` موجود (شغّل `npm run build` محلياً وارفع `public/build/`).
- `APP_URL` صحيح.

### الصور المرفوعة لا تظهر
```bash
php artisan storage:link
ls -la public/storage
```
- `FILESYSTEM_DISK=public` في `.env`.
- مجلد `storage/app/public` قابل للكتابة.

### `/admin` يعطي 404
```bash
php artisan route:cache
```
- Document Root يجب أن يكون `public/`.
- ملف `public/.htaccess` موجود وـ **mod_rewrite** مفعّل.

### Composer غير موجود
```bash
cd ~
curl -sS https://getcomposer.org/installer | php
php composer.phar install --no-dev --optimize-autoloader -d ~/right
```

### Node غير متوفر على السيرفر
لا مشكلة — **ابنِ محلياً** (`npm run build`) وارفع `public/build/` فقط. لا تحتاج Node على cPanel.

---

## 13) أوامر مفيدة لاحقاً (تحديثات)

```bash
cd ~/right

# بعد رفع ملفات جديدة
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 14) أمان بيئة العرض للعميل

```env
APP_DEBUG=false
APP_ENV=production
```

- غيّر كلمة مرور الأدمن الافتراضية.
- لا ترفع `.env` المحلي إلى السيرفر.
- احذف أو احمِ أي ملفات اختبار بعد التأكد من عمل الموقع.

---

## ملخص سريع (Checklist)

- [ ] `npm run build` محلياً + رفع `public/build/`
- [ ] Subdomain + Document Root → `.../right/public`
- [ ] PHP 8.2+ والإضافات مفعّلة
- [ ] MySQL + `.env` مضبوط
- [ ] `composer install --no-dev`
- [ ] `php artisan key:generate`
- [ ] `php artisan migrate --force`
- [ ] `php artisan db:seed --force` (أو نقل البيانات)
- [ ] `php artisan storage:link`
- [ ] `chmod -R 775 storage bootstrap/cache`
- [ ] `php artisan config:cache` + `route:cache` + `view:cache`
- [ ] SSL + `APP_URL` بـ https
- [ ] اختبار `/` و `/admin`

---

**آخر تحديث:** مشروع Laravel 12 + Filament 3 — RIGHT Center
