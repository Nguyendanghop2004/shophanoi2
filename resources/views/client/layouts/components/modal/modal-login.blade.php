<div class="modal modalCentered fade form-sign-in modal-part-content" id="login">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="header">
                <div class="demo-title">Đăng nhập</div>
                <span class="icon-close icon-close-popup" data-bs-dismiss="modal"></span>
            </div>

            <div class="tf-login-form">
                <form action="{{ route('account.login') }}" method="post">
                    @csrf
                    <div class="tf-field style-1">
                        <input class="tf-field-input tf-input" placeholder="Nhập Email" type="email" name="email">
                        <label class="tf-field-label" for="">Email *</label>
                    </div>
                    <div class="tf-field style-1">
                        <input class="tf-field-input tf-input" placeholder=" " type="password" name="password">
                        <label class="tf-field-label" for="">Mật khẩu *</label>
                    </div>
                    <div>
                        <a href="#forgotPassword" data-bs-toggle="modal" class="btn-link link">Quên mật khẩu?</a>
                    </div>
                    <div class="bottom">
                        <div class="w-100">
                            <button type="submit"
                                class="tf-btn btn-fill animate-hover-btn radius-3 w-100 justify-content-center"><span>Đăng
                                    nhập</span></button>
                        </div>
                        <div class="w-100">
                            <a href="#register" data-bs-toggle="modal" class="btn-link fw-6 w-100 link">
                                Khách hàng mới? Tạo tài khoản tại đây
                                <i class="icon icon-arrow1-top-left"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal modalCentered fade form-sign-in modal-part-content" id="forgotPassword">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="header">
                <div class="demo-title">Đặt lại mật khẩu</div>
                <span class="icon-close icon-close-popup" data-bs-dismiss="modal"></span>
            </div>
            <div class="tf-login-form">
                <form class="">
                    <div>
                        <p>Đăng ký nhận thông báo khuyến mãi, sản phẩm mới, và các xu hướng thời trang. Để hủy đăng ký,
                            hãy bấm "Hủy đăng ký" trong email của chúng tôi.</p>
                    </div>
                    <div class="tf-field style-1">
                        <input class="tf-field-input tf-input" placeholder=" " type="email" name="">
                        <label class="tf-field-label" for="">Email *</label>
                    </div>
                    <div>
                        <a href="#login" data-bs-toggle="modal" class="btn-link link">Hủy</a>
                    </div>
                    <div class="bottom">
                        <div class="w-100">
                            <button type="submit"
                                class="tf-btn btn-fill animate-hover-btn radius-3 w-100 justify-content-center"><span>Đặt lại
                                    mật khẩu</span></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal modalCentered fade form-sign-in modal-part-content" id="register">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="header">
                <div class="demo-title">Đăng ký</div>
                <span class="icon-close icon-close-popup" data-bs-dismiss="modal"></span>
            </div>
            <div class="tf-login-form">

                <form action="{{ route('accountUser.register') }}" method="post">
                    @csrf
                    <div class="tf-field style-1">
                        <input class="tf-field-input tf-input" placeholder=" " type="text" name="name"
                            value="{{ old('name') }}">
                        <label class="tf-field-label" for="">Họ và tên</label>
                        @error('name')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="tf-field style-1">
                        <input class="tf-field-input tf-input" placeholder=" " type="email" name="email"
                            value="{{ old('email') }}">
                        <label class="tf-field-label" for="">Email *</label>
                        @error('email')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="tf-field style-1">
                        <input class="tf-field-input tf-input" placeholder=" " type="password" name="password"
                            value="{{ old('password') }}">
                        <label class="tf-field-label" for="">Mật khẩu</label>
                        @error('password')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="tf-field style-1">
                        <input class="tf-field-input tf-input" placeholder=" " type="password"
                            name="password_confirmation" value="{{ old('password') }}">
                        <label class="tf-field-label" for="">Xác nhận mật khẩu *</label>
                        @error('Password')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="bottom">
                        <button class="tf-btn btn-fill animate-hover-btn radius-3 w-100 justify-content-center"
                            type="submit">Đăng ký</button>

                        <div class="w-100">
                            <a href="#login" data-bs-toggle="modal" class="btn-link fw-6 w-100 link">
                                Đã có tài khoản? Đăng nhập tại đây
                                <i class="icon icon-arrow1-top-left"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
