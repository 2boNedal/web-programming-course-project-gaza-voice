@extends('layouts.author') {{-- تأكد إن هاد اسم الليوت عندك --}}

@section('content')
<div class="container-fluid">
    <div class="card card-primary mt-4">
        <div class="card-header">
            <h3 class="card-title">إضافة مقال جديد (مسودة)</h3>
        </div>

        <form action="{{ route('author.articles.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                {{-- العنوان --}}
                <div class="form-group">
                    <label>عنوان المقال</label>
                    <input type="text" name="title" class="form-control" placeholder="اكتب العنوان هنا..." required>
                </div>

                {{-- القسم --}}
                <div class="form-group">
                    <label>القسم</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">اختر القسم</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- المحتوى --}}
                <div class="form-group">
                    <label>نص المقال</label>
                    <textarea name="content" class="form-control" rows="8" required></textarea>
                </div>

                {{-- الوسوم --}}
                <div class="form-group">
                    <label>الوسوم (على الأقل وسم واحد)</label>
                    <select name="tags[]" class="form-control" multiple required>
                        @foreach($tags as $tag)
                            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- الصورة --}}
                <div class="form-group">
                    <label>صورة الغلاف (jpg, jpeg, png, webp)</label>
                    <input type="file" name="cover_image" class="form-control" required>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">حفظ كمسودة</button>
            </div>
        </form>
    </div>
</div>
@endsection
