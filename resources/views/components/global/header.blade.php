
<!-- Meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="google-signin-scope" content="profile">
<meta name="google-signin-client_id" content="748862615970-6p7uecuhtnq1roh3p388qqrts810fv6d.apps.googleusercontent.com">

<!-- fonts & icons --> 
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;600;700&display=swap">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

<!-- compiled css and js -->
@vite(['resources/css/app.css', 'resources/js/app.js'])

<!-- set the base URL for javascript. Uses a 'var' to be global -->
<script>var baseurl = '{{ env('APP_URL'); }}';</script>
