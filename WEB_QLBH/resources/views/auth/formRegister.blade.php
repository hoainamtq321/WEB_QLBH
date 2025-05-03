<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Đăng ký</title>

    <link rel="stylesheet" href="css/myCode.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/bootstrap.bundle.min.js"></script>

</head>
<body>
    <div class="content full-screen d-flex align-items-center">
        <form class="form-input">
            <h1 class="form-header">Đăng ký</h1>
            <div class="mb-3">
              <input type="text" class="form-control" id="username" name="username" placeholder="Tên tài khoản">
            </div>
            <div class="mb-3">
              <input type="password" class="form-control" id="password" name="password" placeholder="Mật khẩu">
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" id="password_confirm " name="password_confirm" placeholder="Nhập lại mật khẩu">
              </div>
            <div class="mb-3 d-flex justify-content-around">
                <a href="#">
                    <button type="button" class="btn btn-primary">Đăng nhập</button>
                </a>
                <button type="submit" class="btn btn-primary">Đăng ký</button>
            </div>
            
          </form>
    </div>
</body>
</html>