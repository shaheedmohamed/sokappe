# 💳 نظام المحفظة الإلكترونية - Sokappe

## 🚀 المميزات

### 💰 إدارة المحفظة
- **إنشاء محافظ تلقائياً** للمستخدمين الجدد
- **دعم العملات المتعددة** (حالياً USD)
- **تتبع الرصيد** (متاح، معلق، إجمالي الأرباح)
- **سجل كامل للمعاملات**

### 🔄 أنواع المعاملات
- **إيداع** - شحن الرصيد
- **سحب** - سحب الأموال
- **دفع** - دفع مقابل الخدمات
- **استرداد** - استرداد المبالغ
- **عمولة** - أرباح من المشاريع
- **مكافأة** - مكافآت النظام

### 🌐 بوابات الدفع
- **OPay** - دعم كامل لمصر ونيجيريا
- **تحويل بنكي** - للمعاملات الكبيرة
- **بطاقة ائتمان** - قريباً

### 👨‍💼 لوحة الإدارة
- **إدارة شاملة للمعاملات**
- **موافقة/رفض المعاملات**
- **إحصائيات مفصلة**
- **تصدير التقارير**
- **مراقبة الأنشطة**

## ⚙️ التثبيت والإعداد

### 1. متغيرات البيئة
أضف هذه المتغيرات في ملف `.env`:

```env
# OPay Settings
OPAY_MERCHANT_ID=your_merchant_id_here
OPAY_PUBLIC_KEY=your_public_key_here
OPAY_SECRET_KEY=your_secret_key_here
OPAY_BASE_URL=https://sandboxapi.opaycheckout.com
OPAY_ENVIRONMENT=sandbox
```

### 2. تشغيل الميجريشن
```bash
php artisan migrate
```

### 3. إنشاء بيانات تجريبية
```bash
php artisan db:seed --class=WalletSeeder
php artisan db:seed --class=TransactionSeeder
```

### 4. اختبار الاتصال بـ OPay
```bash
php artisan opay:test
```

## 🔧 الاستخدام

### للمستخدمين
1. **عرض المحفظة**: `/wallet`
2. **شحن الرصيد**: `/wallet/deposit`
3. **سحب الأموال**: `/wallet/withdraw`
4. **سجل المعاملات**: `/wallet/transactions`

### للإدارة
1. **إدارة المعاملات**: `/admin/transactions`
2. **الإحصائيات**: `/admin/transactions/analytics`
3. **تصدير البيانات**: `/admin/transactions/export`

## 📊 هيكل قاعدة البيانات

### جدول المحافظ (wallets)
```sql
- id: معرف المحفظة
- user_id: معرف المستخدم
- balance: الرصيد المتاح
- pending_balance: الرصيد المعلق
- total_earned: إجمالي الأرباح
- total_withdrawn: إجمالي المسحوبات
- currency: العملة (USD)
- is_active: حالة المحفظة
- last_transaction_at: آخر معاملة
```

### جدول المعاملات (transactions)
```sql
- id: معرف المعاملة
- wallet_id: معرف المحفظة
- user_id: معرف المستخدم
- transaction_id: معرف فريد للمعاملة
- type: نوع المعاملة
- amount: المبلغ
- fee: الرسوم
- net_amount: المبلغ الصافي
- currency: العملة
- status: الحالة
- payment_method: طريقة الدفع
- external_id: معرف خارجي
- gateway_response: استجابة البوابة
- description: الوصف
- notes: ملاحظات
```

## 🔐 الأمان

### التوقيع الرقمي
- **التحقق من التوقيع** لجميع callbacks من OPay
- **تشفير SHA512** للبيانات الحساسة
- **التحقق من IP** للطلبات الواردة

### حماية البيانات
- **تشفير المعلومات الحساسة**
- **تسجيل جميع العمليات**
- **مراقبة الأنشطة المشبوهة**

## 🚨 استكشاف الأخطاء

### مشاكل شائعة

#### 1. خطأ في الاتصال بـ OPay
```bash
# اختبر الاتصال
php artisan opay:test

# تحقق من المتغيرات
php artisan config:clear
```

#### 2. مشكلة في Callbacks
- تأكد من أن URL الخاص بك متاح من الإنترنت
- تحقق من إعدادات Firewall
- راجع logs في `storage/logs/laravel.log`

#### 3. مشاكل المعاملات
```bash
# عرض المعاملات المعلقة
php artisan tinker
>>> Transaction::where('status', 'pending')->get()
```

## 📞 الدعم الفني

### ملفات السجل
- **Laravel Logs**: `storage/logs/laravel.log`
- **OPay Logs**: البحث عن "OPay" في السجلات

### معلومات مفيدة
- **إصدار Laravel**: 10.x
- **إصدار PHP**: 8.1+
- **قاعدة البيانات**: MySQL/SQLite

## 🔄 التحديثات المستقبلية

### قريباً
- [ ] دعم Stripe
- [ ] دعم PayPal  
- [ ] محفظة العملات المشفرة
- [ ] نظام الإشعارات
- [ ] تطبيق الجوال

### تحت التطوير
- [ ] API للمطورين
- [ ] نظام الولاء
- [ ] خصومات وعروض
- [ ] تحليلات متقدمة

---

**تم تطوير هذا النظام بواسطة فريق Sokappe** 🚀

للاستفسارات: [support@sokappe.com](mailto:support@sokappe.com)
