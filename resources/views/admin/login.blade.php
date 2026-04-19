<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Cormorant+Garamond:ital,wght@1,400&display=swap" rel="stylesheet">
  @vite(['resources/scss/admin.scss', 'resources/js/admin.js'])
</head>
<body class="admin-body login-body">
  <div class="login-wrapper">
    <div class="login-card">
      <div class="login-brand">
        <span class="login-ornament">✦</span>
        <h1>Wedding Admin</h1>
        <p>Sign in to manage your invitation</p>
      </div>

      @if($errors->any())
        <div class="alert alert-error">{{ $errors->first() }}</div>
      @endif

      <form method="POST" action="{{ route('login') }}" class="login-form">
        @csrf
        <div class="form-group">
          <label>Email</label>
          <input type="email" name="email" value="{{ old('email') }}" required autofocus>
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" name="password" required>
        </div>
        <div class="form-group">
          <label class="toggle-label">
            <input type="checkbox" name="remember">
            <span>Remember me</span>
          </label>
        </div>
        <button type="submit" class="btn btn-primary btn-full">Sign In</button>
      </form>
    </div>
  </div>
</body>
</html>
