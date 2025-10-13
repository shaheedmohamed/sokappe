@extends('layouts.admin')

@section('title', 'إدارة الرسائل')

@section('content')
<div class="admin-container">
    <!-- Header -->
    <div class="admin-header">
        <h1>💬 إدارة الرسائل</h1>
        <div class="admin-stats">
            <div class="stat-card">
                <div class="stat-number">{{ $conversations->total() }}</div>
                <div class="stat-label">إجمالي المحادثات</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">{{ $conversations->where('is_active', true)->count() }}</div>
                <div class="stat-label">محادثات نشطة</div>
            </div>
        </div>
    </div>

    <!-- Conversations Table -->
    <div class="admin-card">
        <div class="card-header">
            <h3>📋 قائمة المحادثات</h3>
        </div>
        
        @if($conversations->count() > 0)
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>المشروع</th>
                            <th>العميل</th>
                            <th>المحترف</th>
                            <th>قيمة العرض</th>
                            <th>آخر رسالة</th>
                            <th>الحالة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($conversations as $conversation)
                            <tr>
                                <!-- Project Info -->
                                <td>
                                    <div style="max-width: 200px;">
                                        <div style="font-weight: 600; color: #1e293b; margin-bottom: 4px;">
                                            {{ Str::limit($conversation->project->title, 30) }}
                                        </div>
                                        <div style="font-size: 12px; color: #64748b;">
                                            ID: {{ $conversation->project->id }}
                                        </div>
                                    </div>
                                </td>
                                
                                <!-- Client -->
                                <td>
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <img src="{{ $conversation->client->avatar_url }}" 
                                             style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover;">
                                        <div>
                                            <div style="font-weight: 600; color: #1e293b;">{{ $conversation->client->name }}</div>
                                            <div style="font-size: 12px; color: #64748b;">{{ $conversation->client->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                
                                <!-- Freelancer -->
                                <td>
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        <img src="{{ $conversation->freelancer->avatar_url }}" 
                                             style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover;">
                                        <div>
                                            <div style="font-weight: 600; color: #1e293b;">{{ $conversation->freelancer->name }}</div>
                                            <div style="font-size: 12px; color: #64748b;">{{ $conversation->freelancer->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                
                                <!-- Bid Amount -->
                                <td>
                                    <div style="text-align: center;">
                                        <div style="color: #10b981; font-weight: 700; font-size: 16px;">
                                            ${{ number_format($conversation->bid->amount, 2) }}
                                        </div>
                                        <div style="color: #64748b; font-size: 12px;">
                                            {{ $conversation->bid->delivery_time }} أيام
                                        </div>
                                    </div>
                                </td>
                                
                                <!-- Last Message -->
                                <td>
                                    @if($conversation->latestMessage)
                                        <div style="max-width: 200px;">
                                            <div style="font-size: 13px; color: #374151; margin-bottom: 4px;">
                                                {{ Str::limit($conversation->latestMessage->message, 50) }}
                                            </div>
                                            <div style="font-size: 11px; color: #64748b;">
                                                {{ $conversation->latestMessage->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    @else
                                        <span style="color: #94a3b8; font-style: italic;">لا توجد رسائل</span>
                                    @endif
                                </td>
                                
                                <!-- Status -->
                                <td>
                                    @if($conversation->is_active)
                                        <span class="badge badge-success">🟢 نشط</span>
                                    @else
                                        <span class="badge badge-secondary">⚫ غير نشط</span>
                                    @endif
                                </td>
                                
                                <!-- Actions -->
                                <td>
                                    <div style="display: flex; gap: 4px;">
                                        <a href="{{ route('admin.messages.show', $conversation) }}" 
                                           class="btn btn-sm btn-primary" title="عرض المحادثة">
                                            👁️ مشاهدة
                                        </a>
                                        <a href="{{ route('projects.show', $conversation->project) }}" 
                                           class="btn btn-sm btn-outline" title="عرض المشروع" target="_blank">
                                            📋 المشروع
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($conversations->hasPages())
                <div class="admin-pagination">
                    {{ $conversations->links() }}
                </div>
            @endif
        @else
            <div class="empty-state">
                <div class="empty-icon">💬</div>
                <h3>لا توجد محادثات</h3>
                <p>لم يتم إنشاء أي محادثات بعد</p>
            </div>
        @endif
    </div>
</div>

<style>
.admin-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 20px;
}

.admin-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
}

.admin-header h1 {
    margin: 0;
    color: #1e293b;
    font-size: 28px;
}

.admin-stats {
    display: flex;
    gap: 20px;
}

.stat-card {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    text-align: center;
    min-width: 120px;
}

.stat-number {
    font-size: 24px;
    font-weight: 700;
    color: #3b82f6;
    margin-bottom: 5px;
}

.stat-label {
    font-size: 12px;
    color: #64748b;
    font-weight: 600;
}

.admin-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    overflow: hidden;
}

.card-header {
    padding: 20px;
    border-bottom: 1px solid #e5e7eb;
    background: #f8fafc;
}

.card-header h3 {
    margin: 0;
    color: #1e293b;
    font-size: 18px;
}

.table-responsive {
    overflow-x: auto;
}

.admin-table {
    width: 100%;
    border-collapse: collapse;
}

.admin-table th {
    background: #f1f5f9;
    padding: 12px;
    text-align: right;
    font-weight: 600;
    color: #374151;
    border-bottom: 1px solid #e5e7eb;
    font-size: 14px;
}

.admin-table td {
    padding: 12px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: top;
}

.admin-table tr:hover {
    background: #f8fafc;
}

.badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 600;
}

.badge-success {
    background: #dcfce7;
    color: #166534;
}

.badge-secondary {
    background: #f1f5f9;
    color: #64748b;
}

.btn {
    padding: 6px 12px;
    border-radius: 6px;
    text-decoration: none;
    font-size: 12px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    display: inline-block;
}

.btn-sm {
    padding: 4px 8px;
    font-size: 11px;
}

.btn-primary {
    background: #3b82f6;
    color: white;
}

.btn-outline {
    background: transparent;
    color: #3b82f6;
    border: 1px solid #3b82f6;
}

.btn:hover {
    opacity: 0.8;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
}

.empty-icon {
    font-size: 64px;
    margin-bottom: 20px;
    opacity: 0.5;
}

.empty-state h3 {
    margin: 0 0 12px;
    color: #1e293b;
    font-size: 24px;
}

.empty-state p {
    margin: 0;
    color: #64748b;
    font-size: 16px;
}

.admin-pagination {
    padding: 20px;
    display: flex;
    justify-content: center;
}
</style>
@endsection
