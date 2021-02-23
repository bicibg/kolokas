@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('trx.verify_email') }}</div>

                    <div class="card-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('trx.verification_email_sent') }}
                            </div>
                        @endif

                        {{ __('trx.check_email_for_verification') }}
                        {{ __('trx.if_you_did_not_receive_email') }},
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <base-button :role="'submit'" :className="'btn-link p-0 m-0 align-baseline'">
                                {{ __('trx.request_another_email') }} }}
                            </base-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
