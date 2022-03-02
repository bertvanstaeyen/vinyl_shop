@extends('layouts.template')

@section('title', 'Contact Info')

@section('css_after')
    <style>
        .close {
            display: none;
        }
    </style>
@endsection

@section('main')
    <h1>Contact us</h1>
    @include('shared.alert')
    @if (!session()->has('success'))
    <form action="/contact-us" method="post">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name"
                   class="form-control {{ $errors->any() ? ($errors->first('name') ? 'is-invalid' : 'is-valid') : '' }}"
                   class="form-control"
                   placeholder="Your name"
                   required
                   value="{{old('name')}}">
            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email"
                   class="form-control {{ $errors->any() ? ($errors->first('email') ? 'is-invalid' : 'is-valid') : '' }}"
                   class="form-control"
                   placeholder="Your email"
                   required
                   value="{{old('email')}}">
            <div class="invalid-feedback">{{ $errors->first('email') }}</div>
        </div>
        <div class="form-group">
            <label for="contact">Contact</label>
            <select name="contact" id="contact"
                    class="form-control {{ $errors->any() ? ($errors->first('contact') ? 'is-invalid' : 'is-valid') : '' }}"
                    class="form-control"
                    placeholder="Your email"
                    required
                    value="{{old('contact')}}">
                <option value="" selected disabled>Select Contact</option>
                @if (old('contact') == "info")
                    <option value="info" selected>The Vinyl Shop - Info</option>
                @else
                    <option value="info">The Vinyl Shop - Info</option>
                @endif
                @if (old('contact') == "billing")
                    <option value="billing" selected>The Vinyl Shop - Billing</option>
                @else
                    <option value="billing">The Vinyl Shop - Billing</option>
                @endif
                @if (old('contact') == "support")
                    <option value="support" selected>The Vinyl Shop - Support</option>
                @else
                    <option value="support">The Vinyl Shop - Support</option>
                @endif
            </select>
            <div class="invalid-feedback">{{ $errors->first('contact') }}</div>
        </div>
        <div class="form-group">
            <label for="message">Message</label>
            <textarea name="message" id="message" rows="5"
                      class="form-control {{ $errors->any() ? ($errors->first('message') ? 'is-invalid' : 'is-valid') : '' }}"
                      class="form-control"
                      placeholder="Your message"
                      required
                      minlength="10">{{old('message')}}</textarea>
            <div class="invalid-feedback">{{ $errors->first('message') }}</div>
        </div>
        <button type="submit" class="btn btn-success">Send Message</button>
    </form>
    @endif
@endsection

