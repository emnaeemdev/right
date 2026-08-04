# رفع المشروع على GitHub ثم النشر على cPanel

المسار: **GitHub أولاً** → ثم **git clone** على cPanel.

> بعد GitHub، أكمل من `DEPLOY_CPANEL.md` (من القسم 3 فصاعداً).

---

## 1) قبل أول رفع — على جهازك

افتح Terminal/PowerShell داخل مجلد المشروع:

```powershell
cd c:\xampp\htdocs\right

# بناء CSS/JS (مهم — يُرفع مع Git لأن cPanel غالباً بدون Node)
npm install
npm run build

# تأكد أن اللوجو موجود (مستخدم في الهيدر والفوتر)
# public/images/logo_ar.jpeg
```

---

## 2) إنشاء Repository على GitHub

1. ادخل [github.com](https://github.com) → **New repository**
2. الاسم: مثلاً `right-center` أو `right-website`
3. **Private** (مُفضّل — موقع عميل)
4. **لا** تضف README / .gitignore / license (المشروع موجود محلياً)
5. انسخ رابط الـ repo:
   ```
   https://github.com/YOUR_USERNAME/right-center.git
   ```

---

## 3) رفع المشروع لأول مرة (محلياً)

```powershell
cd c:\xampp\htdocs\right

git init
git branch -M main

git add .
git status
```

**تأكد أن `git status` لا يعرض:**
- `.env` ← يجب أن يكون م ignored
- `node_modules/`
- `vendor/`

**يجب أن يُرفع:**
- `public/build/` (بعد npm run build)
- `public/js/filament/forms/components/rich-editor.js`
- `public/images/` (بما فيها `logo_ar.jpeg`)
- `DEPLOY_CPANEL.md` و `.env.example`

```powershell
git commit -m "Initial commit: RIGHT Center website"

git remote add origin https://github.com/YOUR_USERNAME/right-center.git
git push -u origin main
```

> إذا طلب GitHub تسجيل دخول: استخدم **Personal Access Token** بدل كلمة المرور، أو **GitHub Desktop**.

---

## 4) تحديثات لاحقة (بعد أي تعديل)

```powershell
cd c:\xampp\htdocs\right

# إذا غيّرت CSS/JS
npm run build

git add .
git commit -m "وصف التعديل"
git push
```

---

## 5) سحب المشروع على cPanel (Terminal)

بعد إنشاء subdomain و MySQL (راجع `DEPLOY_CPANEL.md`):

```bash
cd ~

# أول مرة — استنساخ
git clone https://github.com/YOUR_USERNAME/right-center.git right
cd right

# إعداد البيئة
cp .env.example .env
nano .env
# عدّل: APP_URL, DB_*, APP_DEBUG=false

composer install --no-dev --optimize-autoloader
php artisan key:generate
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
chmod -R 775 storage bootstrap/cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan filament:optimize
```

**Document Root** في cPanel → `/home/USERNAME/right/public`

### تحديث الموقع بعد push جديد

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

## 6) بديل: Git Version Control من cPanel (بدون Terminal)

1. cPanel → **Git™ Version Control** → **Create**
2. Clone URL: `https://github.com/YOUR_USERNAME/right-center.git`
3. Repository Path: `/home/USERNAME/right`
4. بعد الاستنساخ: نفّذ أوامر Laravel من Terminal (القسم 5)

---

## 7) ملفات لا تُرفع أبداً على GitHub

| ملف/مجلد | السبب |
|-----------|--------|
| `.env` | أسرار (APP_KEY, DB password) |
| `vendor/` | يُثبّت على السيرفر بـ `composer install` |
| `node_modules/` | ثقيل — يُبنى محلياً فقط |
| `database/*.sqlite` | قاعدة بيانات محلية |
| `storage/logs/*.log` | سجلات |

**على السيرفر:** أنشئ `.env` يدوياً من `.env.example` — لا تنسخ `.env` المحلي.

---

## 8) Deploy Key (اختياري — repo خاص)

إذا الـ repo **Private** و cPanel يطلب صلاحية:

1. GitHub → Repo → **Settings → Deploy keys** → Add
2. أو استخدم **Personal Access Token** في رابط clone:
   ```
   https://TOKEN@github.com/YOUR_USERNAME/right-center.git
   ```

---

## 9) Checklist سريع

- [ ] `npm run build` قبل أول push
- [ ] `logo_ar.jpeg` داخل `public/images/`
- [ ] `.env` **غير** مرفوع
- [ ] Repo على GitHub (Private)
- [ ] `git push` نجح
- [ ] `git clone` على cPanel
- [ ] `.env` على السيرفر + `composer install` + `migrate` + `storage:link`
- [ ] Document Root → `public/`

---

**التالي:** [`DEPLOY_CPANEL.md`](DEPLOY_CPANEL.md) — تفاصيل subdomain، MySQL، SSL، وحل المشاكل.
