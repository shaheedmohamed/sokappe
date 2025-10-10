@extends('layouts.app')

@section('content')
<div class="form-container">
    <div class="form-header">
        <h1>⚙️ إعدادات الحساب</h1>
        <p>قم بتحديث معلوماتك الشخصية وإعدادات الأمان</p>
    </div>
    
    <div style="display: grid; gap: 32px;">
        <!-- Personal Information -->
        <div class="form-card">
            <h2 style="margin: 0 0 24px; color: var(--dark); display: flex; align-items: center; gap: 8px;">
                👤 المعلومات الشخصية
            </h2>
            
            @if (session('status') === 'profile-updated')
                <div class="form-success">
                    ✅ تم تحديث الملف الشخصي بنجاح!
                </div>
            @endif
            
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('patch')
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="name">📝 الاسم الكامل</label>
                        <input class="form-input @error('name') error @enderror" type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="email">📧 البريد الإلكتروني</label>
                        <input class="form-input @error('email') error @enderror" type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')<span class="form-error">{{ $message }}</span>@enderror
                        
                        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                            <div style="margin-top: 8px; padding: 12px; background: #fef3c7; border: 1px solid #fbbf24; border-radius: 8px; color: #92400e; font-size: 14px;">
                                ⚠️ بريدك الإلكتروني غير مؤكد.
                                <form method="POST" action="{{ route('verification.send') }}" style="display: inline; margin-right: 8px;">
                                    @csrf
                                    <button type="submit" style="background: none; border: none; color: var(--primary); text-decoration: underline; cursor: pointer;">
                                        إرسال رابط التأكيد مرة أخرى
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">💾 حفظ التغييرات</button>
                </div>
            </form>
        </div>

        <!-- Password Update -->
        <div class="form-card">
            <h2 style="margin: 0 0 24px; color: var(--dark); display: flex; align-items: center; gap: 8px;">
                🔒 تغيير كلمة المرور
            </h2>
            
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                @method('put')
                
                <div class="form-group">
                    <label class="form-label" for="current_password">🔑 كلمة المرور الحالية</label>
                    <input class="form-input @error('current_password', 'updatePassword') error @enderror" type="password" id="current_password" name="current_password" autocomplete="current-password">
                    @error('current_password', 'updatePassword')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="password">🆕 كلمة المرور الجديدة</label>
                        <input class="form-input @error('password', 'updatePassword') error @enderror" type="password" id="password" name="password" autocomplete="new-password">
                        @error('password', 'updatePassword')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="password_confirmation">✅ تأكيد كلمة المرور</label>
                        <input class="form-input @error('password_confirmation', 'updatePassword') error @enderror" type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password">
                        @error('password_confirmation', 'updatePassword')<span class="form-error">{{ $message }}</span>@enderror
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">🔒 تحديث كلمة المرور</button>
                </div>
            </form>
        </div>

        <!-- Account Settings -->
        <div class="form-card">
            <h2 style="margin: 0 0 24px; color: var(--dark); display: flex; align-items: center; gap: 8px;">
                🎛️ إعدادات الحساب
            </h2>
            
            <div style="display: grid; gap: 16px;">
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 16px; background: var(--gray-50); border-radius: 8px;">
                    <div>
                        <h4 style="margin: 0 0 4px; color: var(--dark);">📧 إشعارات البريد الإلكتروني</h4>
                        <p style="margin: 0; color: var(--muted); font-size: 14px;">استقبال إشعارات المشاريع والعروض الجديدة</p>
                    </div>
                    <label style="position: relative; display: inline-block; width: 60px; height: 34px;">
                        <input type="checkbox" checked style="opacity: 0; width: 0; height: 0;">
                        <span style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: var(--primary); transition: .4s; border-radius: 34px; display: block;"></span>
                    </label>
                </div>
                
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 16px; background: var(--gray-50); border-radius: 8px;">
                    <div>
                        <h4 style="margin: 0 0 4px; color: var(--dark);">🔔 الإشعارات الفورية</h4>
                        <p style="margin: 0; color: var(--muted); font-size: 14px;">إشعارات المتصفح للرسائل والتحديثات المهمة</p>
                    </div>
                    <label style="position: relative; display: inline-block; width: 60px; height: 34px;">
                        <input type="checkbox" style="opacity: 0; width: 0; height: 0;">
                        <span style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: var(--gray-300); transition: .4s; border-radius: 34px; display: block;"></span>
                    </label>
                </div>
                
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 16px; background: var(--gray-50); border-radius: 8px;">
                    <div>
                        <h4 style="margin: 0 0 4px; color: var(--dark);">👁️ إظهار الملف الشخصي</h4>
                        <p style="margin: 0; color: var(--muted); font-size: 14px;">السماح للآخرين بمشاهدة ملفك الشخصي</p>
                    </div>
                    <label style="position: relative; display: inline-block; width: 60px; height: 34px;">
                        <input type="checkbox" checked style="opacity: 0; width: 0; height: 0;">
                        <span style="position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: var(--primary); transition: .4s; border-radius: 34px; display: block;"></span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Danger Zone -->
        <div class="form-card" style="border: 2px solid var(--danger);">
            <h2 style="margin: 0 0 24px; color: var(--danger); display: flex; align-items: center; gap: 8px;">
                ⚠️ منطقة الخطر
            </h2>
            
            <div style="background: #fef2f2; padding: 16px; border-radius: 8px; border: 1px solid #fecaca; margin-bottom: 16px;">
                <h4 style="margin: 0 0 8px; color: var(--danger);">🗑️ حذف الحساب</h4>
                <p style="margin: 0; color: var(--danger); font-size: 14px; line-height: 1.5;">
                    بمجرد حذف حسابك، ستفقد جميع بياناتك ومعلوماتك نهائياً. هذا الإجراء لا يمكن التراجع عنه.
                </p>
            </div>
            
            <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('هل أنت متأكد من حذف حسابك؟ هذا الإجراء لا يمكن التراجع عنه!')">
                @csrf
                @method('delete')
                
                <div class="form-group">
                    <label class="form-label" for="password_delete">🔑 أدخل كلمة المرور للتأكيد</label>
                    <input class="form-input @error('password', 'userDeletion') error @enderror" type="password" id="password_delete" name="password" placeholder="كلمة المرور">
                    @error('password', 'userDeletion')<span class="form-error">{{ $message }}</span>@enderror
                </div>
                
                <button type="submit" class="btn btn-danger">🗑️ حذف الحساب نهائياً</button>
            </form>
        </div>
    </div>
</div>
@endsection
