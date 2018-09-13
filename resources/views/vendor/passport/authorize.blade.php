<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no,viewport-fit=cover">

    <title>{{ config('app.name') }} - Authorization</title>

    <!-- Styles -->
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">

    <style>
        .navbar {
            font-weight: 500;
            border-bottom: 1px solid #dee9f2;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
        }

        .passport-authorize .passport-container {
            margin-top: 30px;
        }

/*        .passport-authorize .scopes {
            margin-top: 20px;
        }*/

        .passport-authorize .buttons {
            margin-top: 25px;
            text-align: center;
        }

        .passport-authorize .btn {
            width: 125px;
        }

        .passport-authorize .btn-approve {
            margin-right: 15px;
        }

        .passport-authorize form {
            display: inline;
        }
    </style>
</head>
<body class="passport-authorize">
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
        <div class="container" style="max-width: 100%;">
            <a class="navbar-brand">
                <img itemprop="image" src="/images/logoDark.svg" height="45" alt="JustBookr Logo" />
                JustBookr
            </a>
        </div>
    </nav>

    <div class="passport-container container">
        <div class="row">
            <div class="col-lg-6 m-auto">
                <h1 class="text-center mb-3"><strong>{{ $client->name }}</strong> wants your info.</h1>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card facebook-card">
                    <div class="card-body">

                        <!-- Scope List -->
                        @if (count($scopes) > 0)
                            <div class="scopes">
                                    <p><strong>This application will be able to:</strong></p>
                                    <ul>
                                        @foreach ($scopes as $scope)
                                            <li>{{ $scope->description }}</li>
                                        @endforeach
                                    </ul>
                            </div>
                        @else
                            <div class="scopes">
                                    <p>This application will be able to:</p>
                                    <ul style="font-weight:500;">
                                        <li>See, update, create, and delete all of your data on JustBookr.</li>
                                    </ul>
                            </div>
                        @endif

                        <div class="buttons">
                            <!-- Authorize Button -->
                            <form method="post" action="{{ url('/oauth/authorize') }}">
                                {{ csrf_field() }}

                                <input type="hidden" name="state" value="{{ $request->state }}">
                                <input type="hidden" name="client_id" value="{{ $client->id }}">
                                <button type="submit" class="btn btn-primary btn-approve">Allow</button>
                            </form>

                            <!-- Cancel Button -->
                            <form method="post" action="{{ url('/oauth/authorize') }}">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}

                                <input type="hidden" name="state" value="{{ $request->state }}">
                                <input type="hidden" name="client_id" value="{{ $client->id }}">
                                <button class="btn btn-secondary">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6 offset-md-3">
                <p class="text-muted text-center">Do not allow access to applications that you do not trust.</p>
            </div>
        </div>
    </div>
</body>
</html>
