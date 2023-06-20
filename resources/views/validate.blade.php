@extends('layouts.master')


@section('content')
    <h1>Validate Test</h1>
    <form action="{{ route('validateCheck') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class=" form-label" for="">Validate Test</label>
            <input type="text" class=" form-control @error('title') is-invalid @enderror" value="{{ old('title') }}"
                name="title">
            @error('title')
                <div class=" invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        @php
            $genders = ['male', 'female', 'other'];
            
        @endphp

        <div class="mb-3">
            <label for=" form-label">Gender</label>
            @foreach ($genders as $gender)
                <div class="form-check @error('gender') is-invalid @enderror">
                    <input class="form-check-input" type="radio" {{ old('gender' === $gender ? 'checked' : '') }}
                        id="gender_{{ $gender }}" value="{{ $gender }}" name="gender">
                    <label class="form-check-label" for="gender_{{ $gender }}">
                        {{ $gender }}
                    </label>
                </div>
            @endforeach
            @error('gender')
                <div class=" invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for=" form-label" for="township">Select Townshi</label>
            <select name="township" class=" form-select  @error('township') is-invalid @enderror" id="township">
                <option value="">Select One</option>
                @foreach (App\Models\Township::all() as $township)
                    <option value="{{ $township->name }}" {{ old('township' === $township->name ? 'selected' : '') }}>
                        {{ $township->name }}
                    </option>
                @endforeach
            </select>
            @error('township')
                <div class=" invalid-feedback">{{ $message }}</div>
            @enderror
        </div>


        <div class="mb-3    ">
            <label for="" class=" form-label">Select Your Skill</label>

            @foreach (App\Models\Skill::all() as $skill)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="skills[]"
                        {{ in_array($skill->title, old('skills', [])) ? 'checked' : '' }} value="{{ $skill->title }}"
                        id="skill_{{ $skill->title }}">
                    <label class="form-check-label" for="skill_{{ $skill->title }}">
                        {{ $skill->title }}
                    </label>
                </div>
            @endforeach
            @error('skills')
                <div class="  text-danger small">{{ $message }}</div>
            @enderror
            @error('skills.*')
                <div class="  text-danger small">{{ $message }}</div>
            @enderror
        </div>


        {{-- <div class="mb-3">
            <label for="" class=" form-label">Photo Upload</label>
            <input type="file" class=" form-control @error('photo') is-invalid  @enderror" name="photo">
            @error('photo')
                <div class="  text-danger small">{{ $message }}</div>
            @enderror
        </div> --}}


        <div class="mb-3">
            <label for="" class=" form-label">Certificate Attachment</label>
            <input type="file" class=" form-control " name="certificates[]" multiple>
            @error('certificates')
                <div class="  text-danger small">{{ $message }}</div>
            @enderror

            @error('certificates,*')
                <div class="  text-danger small">{{ $message }}</div>
            @enderror
        </div>


        <button class=" btn btn-primary">Save Article</button>
    </form>
@endsection
