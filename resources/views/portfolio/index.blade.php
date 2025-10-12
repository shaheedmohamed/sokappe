@extends('layouts.app')

@section('title', 'معرض الأعمال')

@section('content')
<div style="max-width: 1200px; margin: 0 auto; padding: 20px;">
    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; background: white; padding: 25px; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <div>
            <h1 style="margin: 0 0 5px; color: #1e293b; font-size: 24px;">🎨 معرض الأعمال</h1>
            <p style="margin: 0; color: #64748b;">عرض أعمالك وإنجازاتك للعملاء المحتملين</p>
        </div>
        <a href="{{ route('portfolio.create') }}" style="padding: 12px 24px; background: #10b981; color: white; text-decoration: none; border-radius: 8px; font-weight: 600;">
            ➕ إضافة عمل جديد
        </a>
    </div>

    @if(session('success'))
        <div style="background: #dcfce7; border: 1px solid #22c55e; color: #166534; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    @if($portfolios->count() > 0)
        <!-- Portfolio Grid -->
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 25px; margin-bottom: 30px;">
            @foreach($portfolios as $portfolio)
                <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: transform 0.3s ease;">
                    <!-- Image -->
                    <div style="position: relative; height: 200px; background: #f8fafc;">
                        <img src="{{ $portfolio->main_image }}" 
                             style="width: 100%; height: 100%; object-fit: cover;"
                             alt="{{ $portfolio->title }}">
                        
                        @if($portfolio->is_featured)
                            <div style="position: absolute; top: 10px; right: 10px; background: #f59e0b; color: white; padding: 4px 8px; border-radius: 12px; font-size: 11px; font-weight: 600;">
                                ⭐ مميز
                            </div>
                        @endif
                        
                        <div style="position: absolute; bottom: 10px; left: 10px; background: rgba(0,0,0,0.7); color: white; padding: 4px 8px; border-radius: 12px; font-size: 11px;">
                            👁️ {{ $portfolio->views_count }} مشاهدة
                        </div>
                    </div>

                    <!-- Content -->
                    <div style="padding: 20px;">
                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 10px;">
                            <h3 style="margin: 0; color: #1e293b; font-size: 16px; font-weight: 600;">
                                {{ $portfolio->title }}
                            </h3>
                            <span style="background: #e0f2fe; color: #0369a1; padding: 3px 8px; border-radius: 12px; font-size: 10px; font-weight: 600;">
                                {{ $portfolio->category_name }}
                            </span>
                        </div>

                        <p style="margin: 0 0 15px; color: #64748b; font-size: 13px; line-height: 1.5;">
                            {{ Str::limit($portfolio->description, 100) }}
                        </p>

                        <!-- Technologies -->
                        @if($portfolio->technologies && count($portfolio->technologies) > 0)
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; flex-wrap: wrap; gap: 5px;">
                                    @foreach(array_slice($portfolio->technologies, 0, 3) as $tech)
                                        <span style="background: #f1f5f9; color: #475569; padding: 2px 6px; border-radius: 8px; font-size: 10px;">
                                            {{ $tech }}
                                        </span>
                                    @endforeach
                                    @if(count($portfolio->technologies) > 3)
                                        <span style="color: #64748b; font-size: 10px;">+{{ count($portfolio->technologies) - 3 }}</span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <!-- Actions -->
                        <div style="display: flex; gap: 8px; justify-content: space-between;">
                            <div style="display: flex; gap: 8px;">
                                <a href="{{ route('portfolio.show', $portfolio) }}" 
                                   style="padding: 6px 12px; background: #3b82f6; color: white; text-decoration: none; border-radius: 6px; font-size: 11px;">
                                    👁️ عرض
                                </a>
                                <a href="{{ route('portfolio.edit', $portfolio) }}" 
                                   style="padding: 6px 12px; background: #10b981; color: white; text-decoration: none; border-radius: 6px; font-size: 11px;">
                                    ✏️ تعديل
                                </a>
                            </div>
                            
                            <form method="POST" action="{{ route('portfolio.destroy', $portfolio) }}" 
                                  style="display: inline;" 
                                  onsubmit="return confirm('هل أنت متأكد من حذف هذا العمل؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        style="padding: 6px 12px; background: #ef4444; color: white; border: none; border-radius: 6px; font-size: 11px; cursor: pointer;">
                                    🗑️ حذف
                                </button>
                            </form>
                        </div>

                        <!-- Date -->
                        @if($portfolio->completion_date)
                            <div style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #f1f5f9;">
                                <span style="color: #64748b; font-size: 11px;">
                                    📅 اكتمل في {{ $portfolio->completion_date->format('M Y') }}
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($portfolios->hasPages())
            <div style="display: flex; justify-content: center;">
                {{ $portfolios->links() }}
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div style="text-align: center; padding: 80px 20px; background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <div style="font-size: 64px; margin-bottom: 20px;">🎨</div>
            <h3 style="margin: 0 0 15px; color: #1e293b; font-size: 20px;">معرض الأعمال فارغ</h3>
            <p style="margin: 0 0 25px; color: #64748b; font-size: 16px;">ابدأ في عرض أعمالك وإنجازاتك لجذب المزيد من العملاء</p>
            <a href="{{ route('portfolio.create') }}" 
               style="padding: 15px 30px; background: #10b981; color: white; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 16px;">
                ➕ إضافة أول عمل
            </a>
        </div>
    @endif
</div>

<style>
div[style*="grid-template-columns"] > div:hover {
    transform: translateY(-5px);
}
</style>
@endsection
