<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif

            <div class="content">
            <table>
            @foreach($user as $users)
                     <tr>
                         <th>{{$users->name}}</th>
                         <td>
                              <form action="{{ asset('onecharge') }}" method="POST">
                                  {{ csrf_field() }}
                                  <input type="hidden" name="iddata" value="{{$users->id}}">
                                          <script
                                                  src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                                  data-key="{{ env('STRIPE_KEY') }}"
                                                  data-amount="1000"
                                                  data-name="Stripe Demo"
                                                  data-label="このユーザーを通じて決済をする"
                                                  data-description="Online course about integrating Stripe"
                                                  data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                                                  data-locale="auto"
                                                  data-currency="JPY">
                                          </script>
                              </form>
                         </td>
                     </tr>
            @endforeach
            </table>
            </div>
        </div>
    </body>
</html>