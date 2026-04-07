<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login - WASPAS Pasar</title>
  <link rel="stylesheet" href="{{ asset('dashboard/vendors/feather/feather.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/vendors/ti-icons/css/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/vendors/css/vendor.bundle.base.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/css/vertical-layout-light/style.css') }}">
  <link rel="shortcut icon" href="{{ asset('dashboard/images/favicon.png') }}" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5 shadow-lg rounded">
              <div class="brand-logo text-center">
                <h3 class="font-weight-bold text-primary"><i class="fas fa-shopping-basket mr-2"></i>WASPAS-PASAR</h3>
              </div>
              <h4 class="font-weight-light">Silakan login untuk melanjutkan.</h4>
              
              <form class="pt-3" action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="form-group">
                  <input type="text" name="username" class="form-control form-control-lg @error('username') is-invalid @enderror" id="exampleInputEmail1" placeholder="Username" value="{{ old('username') }}" required>
                  @error('username')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
                <div class="form-group">
                  <input type="password" name="password" class="form-control form-control-lg" id="exampleInputPassword1" placeholder="Password" required>
                </div>
                <div class="mt-3">
                  <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">MASUK</button>
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" class="form-check-input">
                      Ingat saya
                    </label>
                  </div>
                </div>
              </form>
            </div>
            <p class="text-center mt-4 text-muted small">© 2026 WASPAS-Pasar Surya. Sistem Pendukung Keputusan.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="{{ asset('dashboard/vendors/js/vendor.bundle.base.js') }}"></script>
  <script src="{{ asset('dashboard/js/off-canvas.js') }}"></script>
  <script src="{{ asset('dashboard/js/hoverable-collapse.js') }}"></script>
  <script src="{{ asset('dashboard/js/template.js') }}"></script>
  <script src="{{ asset('dashboard/js/settings.js') }}"></script>
  <script src="{{ asset('dashboard/js/todolist.js') }}"></script>
</body>
</html>
