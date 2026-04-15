@extends('layouts2.app')

@section('title', 'Fundi Digital Connections')

@section('content')

    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-lg-6 col-md-6 col-sm-6 shadow-lg bg-light">
                <div class="form-container">
                    <h6 class="text-center text-primary">Fundi Digital Connections</h6>
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>

                            <p class="text-end">
                                <a href="#"> 
                                    Forgot Password?
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

