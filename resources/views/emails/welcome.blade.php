Hellow {{$user->name}}
Thank you for create an account. please verify your email using  this links:

{{route('verify',$user->verification_token)}}
 
