@extends('layouts.master')

@section('title', 'Home')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card" style="text-align: center;background: #f4f4f4; padding: 20px 0; margin-top:200px">

                @if(!empty($userInfos))
                <h1>
                    Profile
                </h1>
                @foreach ($userInfos as $user)

                {!! Form::open(['action' => ['UserInfoController@update',$user->id], 'method'=>'POST', 'enctype'=>'multipart/form-data']) !!}
                <div class="form-group">
                    {{Form::label('username', 'Username')}}
                    {{Form::text('username',$user->username,['class'=>'form-control', 'placeholder'=>'username'])}}
                    @error('username')
                    <div class="alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    {{Form::label('email', 'Email')}}
                    {{Form::email('email',$user->email,['class'=>'form-control', 'placeholder'=>'Email'])}}
                </div>
                <div class="form-group">
                    {{Form::label('phone', 'Phone')}}
                    {{Form::text('phone',$user->phone,['class'=>'form-control', 'placeholder'=>'Phone'])}}
                </div>
                <div class="form-group">
                    {{Form::label('sex', 'Sex')}}
                    {{Form::select('sex', ['male' => 'Male', 'female' => 'Female'], $user->sex, ['class'=>'form-control'])}}
                </div>
                <div class="form-group">
                    {{Form::label('age', 'Age')}}
                    {{Form::number('age',$user->age,['class'=>'form-control', 'placeholder'=>'Age'])}}
                </div>
                <div class="form-group">
                    {{Form::label('weight', 'Weight')}}
                    {{Form::number('weight',$user->weight,['class'=>'form-control', 'placeholder'=>'Weight'])}}
                </div>
                <div class="form-group">
                    {{Form::label('blood_group', 'Blood Group')}}
                    {{Form::select('blood_group', ['A+'=>'A+','A-'=>'A-','B+'=>'B+','B-'=>'B-','AB+'=>'AB+','AB-'=>'AB-','O+'=>'O+','O-'=>'O-'], $user->blood_group, ['class'=>'form-control'])}}
                </div>
                <div class="form-group">
                    {{Form::label('district', 'District')}}
                    {{Form::select('district', ['dhaka' => 'Dhaka', 'khulna' => 'Khulna', 'chitagong'=>'Chitagong'], $user->district, ['class'=>'form-control'])}}
                </div>
                <div class="form-group">
                    {{Form::label('test_positive_date', 'Test Positive Date')}}
                    {{Form::date('test_positive_date',$user->test_positive_date,['class'=>'form-control', 'placeholder'=>'Test Positive Date'])}}
                    @error('test_positive_date')
                    <div class="alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    {{Form::label('test_negative_date', 'Test Negative Date')}}
                    {{Form::date('test_negative_date',$user->test_negative_date,['class'=>'form-control', 'placeholder'=>'Test Negative Date'])}}
                    @error('test_negative_date')
                    <div class="alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    {{Form::label('test_negative_date_second', 'Test Negative Date Second Time')}}
                    {{Form::date('test_negative_date_second',$user->test_negative_date_second,['class'=>'form-control', 'placeholder'=>'Test Negative Date Second Time'])}}
                    @error('test_negative_date_second')
                    <div class="alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    @if(!empty($user->image))
                    <img src="{{asset("public/storage/images/$user->image")}}" alt="{{$user->username}}" style="width: 200px; height: 200px;"/>
                    @endif
                    <hr>
                    {{Form::file('image')}}
                </div>
                <div class="form-group">
                    {{Form::submit('Update',['class'=>'btn btn-primary'])}}
                </div>
                <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
                {{Form::hidden('_method','PUT')}}
                {!! Form::close() !!}
                @endforeach
                @endif
            </div>
        </div>
    </div>
</div>
@endsection