@extends('layouts.app')

@section('title', 'التقييمات - ' . $user->name)

@section('content')
<div style="max-width: 1000px; margin: 0 auto; padding: 20px;">
    <!-- Header -->
    <div style="background: white; border-radius: 12px; padding: 30px; margin-bottom: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 20px;">
            <img src="{{ $user->avatar_url }}" 
                 style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover;">
            <div>
                <h1 style="margin: 0 0 5px; color: #1e293b; font-size: 24px;">تقييمات {{ $user->name }}</h1>
                <div style="display: flex; align-items: center; gap: 15px;">
                    <div style="display: flex; align-items: center; gap: 5px;">
                        @for($i = 1; $i <= 5; $i++)
                            <span style="color: {{ $i <= $averageRating ? '#fbbf24' : '#e5e7eb' }}; font-size: 18px;">★</span>
                        @endfor
                        <span style="font-weight: 600; color: #1e293b; margin-left: 5px;">{{ number_format($averageRating, 1) }}</span>
                    </div>
                    <span style="color: #64748b;">({{ $ratingsCount }} تقييم)</span>
                </div>
            </div>
        </div>
    </div>

    @if($ratingsCount > 0)
        <div style="display: grid; grid-template-columns: 1fr 350px; gap: 30px;">
            <!-- Reviews List -->
            <div>
                <h2 style="margin: 0 0 20px; color: #1e293b; font-size: 20px;">💬 آراء العملاء</h2>
                
                @foreach($ratings as $rating)
                    <div style="background: white; border-radius: 12px; padding: 25px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                        <!-- Client Info -->
                        <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 15px;">
                            <img src="{{ $rating->client->avatar_url }}" 
                                 style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                            <div>
                                <h4 style="margin: 0 0 3px; color: #1e293b; font-size: 16px;">{{ $rating->client->name }}</h4>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="display: flex; align-items: center; gap: 2px;">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span style="color: {{ $i <= $rating->overall_rating ? '#fbbf24' : '#e5e7eb' }}; font-size: 14px;">★</span>
                                        @endfor
                                        <span style="font-weight: 600; color: #1e293b; margin-left: 5px; font-size: 14px;">{{ $rating->overall_rating }}</span>
                                    </div>
                                    <span style="color: #64748b; font-size: 12px;">{{ $rating->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Project Info -->
                        <div style="background: #f8fafc; padding: 12px; border-radius: 8px; margin-bottom: 15px;">
                            <span style="color: #64748b; font-size: 12px;">المشروع:</span>
                            <a href="{{ route('projects.show', $rating->project) }}" 
                               style="color: #3b82f6; text-decoration: none; font-weight: 500; margin-right: 5px;">
                                {{ $rating->project->title }}
                            </a>
                        </div>

                        <!-- Review Text -->
                        @if($rating->review)
                            <div style="color: #374151; line-height: 1.6; margin-bottom: 15px;">
                                "{{ $rating->review }}"
                            </div>
                        @endif

                        <!-- Detailed Ratings -->
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 10px; margin-top: 15px; padding-top: 15px; border-top: 1px solid #f1f5f9;">
                            @foreach($rating->rating_categories as $category => $data)
                                <div style="display: flex; justify-content: space-between; align-items: center; font-size: 12px;">
                                    <span style="color: #64748b;">{{ $data['name'] }}:</span>
                                    <div style="display: flex; align-items: center; gap: 2px;">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span style="color: {{ $i <= $data['rating'] ? '#fbbf24' : '#e5e7eb' }}; font-size: 10px;">★</span>
                                        @endfor
                                        <span style="margin-right: 3px; font-weight: 600;">{{ $data['rating'] }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <!-- Pagination -->
                @if($ratings->hasPages())
                    <div style="display: flex; justify-content: center; margin-top: 30px;">
                        {{ $ratings->links() }}
                    </div>
                @endif
            </div>

            <!-- Rating Statistics -->
            <div>
                <div style="background: white; border-radius: 12px; padding: 25px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <h3 style="margin: 0 0 20px; color: #1e293b; font-size: 18px;">📊 إحصائيات التقييم</h3>
                    
                    <!-- Overall Rating -->
                    <div style="text-align: center; margin-bottom: 25px; padding: 20px; background: #f8fafc; border-radius: 8px;">
                        <div style="font-size: 36px; font-weight: 700; color: #1e293b; margin-bottom: 5px;">
                            {{ number_format($averageRating, 1) }}
                        </div>
                        <div style="display: flex; justify-content: center; align-items: center; gap: 2px; margin-bottom: 5px;">
                            @for($i = 1; $i <= 5; $i++)
                                <span style="color: {{ $i <= $averageRating ? '#fbbf24' : '#e5e7eb' }}; font-size: 20px;">★</span>
                            @endfor
                        </div>
                        <div style="color: #64748b; font-size: 14px;">من {{ $ratingsCount }} تقييم</div>
                    </div>

                    <!-- Detailed Stats -->
                    <div style="space-y: 15px;">
                        @php
                            $categories = [
                                'communication' => 'التواصل والتفاهم',
                                'quality' => 'جودة العمل المسلم',
                                'expertise' => 'الخبرة بالمجال المطلوب',
                                'delivery' => 'التسليم بالموعد',
                                'cooperation' => 'التعامل والأخلاق المهنية',
                                'rehire' => 'إعادة التوظيف'
                            ];
                        @endphp

                        @foreach($categories as $key => $name)
                            <div style="margin-bottom: 15px;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
                                    <span style="color: #374151; font-size: 13px; font-weight: 500;">{{ $name }}</span>
                                    <span style="color: #1e293b; font-weight: 600; font-size: 14px;">{{ number_format($ratingStats[$key], 1) }}</span>
                                </div>
                                <div style="background: #e5e7eb; height: 6px; border-radius: 3px; overflow: hidden;">
                                    <div style="background: #fbbf24; height: 100%; width: {{ ($ratingStats[$key] / 5) * 100 }}%; transition: width 0.3s ease;"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Rating Distribution -->
                <div style="background: white; border-radius: 12px; padding: 25px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <h3 style="margin: 0 0 20px; color: #1e293b; font-size: 18px;">⭐ توزيع التقييمات</h3>
                    
                    @php
                        $ratingDistribution = [];
                        for ($i = 5; $i >= 1; $i--) {
                            $count = $ratings->where('overall_rating', '>=', $i)->where('overall_rating', '<', $i + 1)->count();
                            $percentage = $ratingsCount > 0 ? ($count / $ratingsCount) * 100 : 0;
                            $ratingDistribution[$i] = ['count' => $count, 'percentage' => $percentage];
                        }
                    @endphp

                    @foreach($ratingDistribution as $stars => $data)
                        <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 10px;">
                            <span style="color: #374151; font-size: 13px; width: 20px;">{{ $stars }}★</span>
                            <div style="flex: 1; background: #e5e7eb; height: 8px; border-radius: 4px; overflow: hidden;">
                                <div style="background: #fbbf24; height: 100%; width: {{ $data['percentage'] }}%; transition: width 0.3s ease;"></div>
                            </div>
                            <span style="color: #64748b; font-size: 12px; width: 30px; text-align: left;">{{ $data['count'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <!-- No Ratings -->
        <div style="text-align: center; padding: 80px 20px; background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <div style="font-size: 64px; margin-bottom: 20px;">⭐</div>
            <h3 style="margin: 0 0 15px; color: #1e293b; font-size: 20px;">لم يتم التقييم بعد</h3>
            <p style="margin: 0; color: #64748b; font-size: 16px;">لا توجد تقييمات لهذا المحترف حتى الآن</p>
        </div>
    @endif
</div>
@endsection
