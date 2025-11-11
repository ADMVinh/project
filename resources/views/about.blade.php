@extends('layouts.app')
@section('content')

<style>
  .breadcrumb-item + .breadcrumb-item::before {
    content: "/";
  }
  
  .about-section {
    padding: 60px 0;
  }
  
  .about-img {
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
  }
  
  .stat-card {
    text-align: center;
    padding: 30px;
    border-radius: 10px;
    background: #f8f9fa;
    transition: all 0.3s;
  }
  
  .stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
  }
  
  .stat-number {
    font-size: 3rem;
    font-weight: bold;
    color: #0d6efd;
  }
  
  .team-member {
    text-align: center;
    margin-bottom: 30px;
  }
  
  .team-member img {
    width: 200px;
    height: 200px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 20px;
  }
  
  .value-card {
    padding: 30px;
    border-left: 4px solid #0d6efd;
    background: #f8f9fa;
    margin-bottom: 20px;
  }
</style>

<main class="pt-90">
  <div class="mb-4 pb-4"></div>
  
  <section class="contact-us container">
    <div class="mw-930">
      <h2 class="page-title">Giới Thiệu Về Chúng Tôi</h2>
    </div>
  </section>

  <div class="mb-4 pb-4"></div>

  <!-- Breadcrumb -->
  <section class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{route('home.index')}}">Trang chủ</a></li>
        <li class="breadcrumb-item active" aria-current="page">Giới thiệu</li>
      </ol>
    </nav>
  </section>

  <!-- Giới thiệu chính -->
  <section class="about-section container">
    <div class="row align-items-center">
      <div class="col-lg-6 mb-4 mb-lg-0">
        <div class="about-img">
          <img src="{{ asset('assets/images/about/about-1.jpg') }}" alt="About Us" class="w-100">
        </div>
      </div>
      <div class="col-lg-6">
        <h2 class="mb-4">Câu Chuyện Của Chúng Tôi</h2>
        <p class="mb-3">
          Surfside Media được thành lập vào năm 2020 với sứ mệnh mang đến những sản phẩm thời trang 
          chất lượng cao và phong cách độc đáo cho khách hàng Việt Nam.
        </p>
        <p class="mb-3">
          Chúng tôi tin rằng thời trang không chỉ là quần áo, mà là cách bạn thể hiện bản thân. 
          Với đội ngũ thiết kế tài năng và am hiểu xu hướng, chúng tôi luôn mang đến những bộ sưu tập 
          mới nhất, phù hợp với mọi phong cách và cá tính.
        </p>
        <p>
          Từ những ngày đầu khởi nghiệp, chúng tôi đã không ngừng phát triển và mở rộng, 
          hiện tại có mặt tại 15 tỉnh thành trên cả nước với hơn 50 cửa hàng và đội ngũ 
          hơn 200 nhân viên tận tâm.
        </p>
      </div>
    </div>
  </section>

  <div class="mb-5 pb-4"></div>

  <!-- Số liệu thống kê -->
  <section class="container">
    <div class="row g-4">
      <div class="col-md-3 col-6">
        <div class="stat-card">
          <div class="stat-number">50+</div>
          <p class="mb-0">Cửa Hàng</p>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="stat-card">
          <div class="stat-number">10K+</div>
          <p class="mb-0">Sản Phẩm</p>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="stat-card">
          <div class="stat-number">100K+</div>
          <p class="mb-0">Khách Hàng</p>
        </div>
      </div>
      <div class="col-md-3 col-6">
        <div class="stat-card">
          <div class="stat-number">200+</div>
          <p class="mb-0">Nhân Viên</p>
        </div>
      </div>
    </div>
  </section>

  <div class="mb-5 pb-4"></div>

  <!-- Giá trị cốt lõi -->
  <section class="container">
    <div class="text-center mb-5">
      <h2>Giá Trị Cốt Lõi</h2>
      <p class="text-muted">Những giá trị định hướng mọi hoạt động của chúng tôi</p>
    </div>
    <div class="row">
      <div class="col-md-6 mb-4">
        <div class="value-card">
          <h4>
            <i class="fa fa-heart text-primary me-2"></i>
            Chất Lượng Đầu Tiên
          </h4>
          <p class="mb-0">
            Chúng tôi cam kết mang đến sản phẩm với chất lượng tốt nhất, 
            từ vải vóc đến từng đường may.
          </p>
        </div>
      </div>
      <div class="col-md-6 mb-4">
        <div class="value-card">
          <h4>
            <i class="fa fa-users text-primary me-2"></i>
            Khách Hàng Là Trung Tâm
          </h4>
          <p class="mb-0">
            Sự hài lòng của khách hàng là ưu tiên hàng đầu. 
            Chúng tôi luôn lắng nghe và cải thiện dịch vụ.
          </p>
        </div>
      </div>
      <div class="col-md-6 mb-4">
        <div class="value-card">
          <h4>
            <i class="fa fa-leaf text-primary me-2"></i>
            Bền Vững & Trách Nhiệm
          </h4>
          <p class="mb-0">
            Chúng tôi cam kết sản xuất bền vững, thân thiện với môi trường 
            và có trách nhiệm xã hội.
          </p>
        </div>
      </div>
      <div class="col-md-6 mb-4">
        <div class="value-card">
          <h4>
            <i class="fa fa-lightbulb text-primary me-2"></i>
            Đổi Mới & Sáng Tạo
          </h4>
          <p class="mb-0">
            Luôn cập nhật xu hướng mới nhất và không ngừng sáng tạo 
            để mang đến trải nghiệm tốt nhất.
          </p>
        </div>
      </div>
    </div>
  </section>

  <div class="mb-5 pb-4"></div>

  <!-- Đội ngũ -->
  <section class="container">
    <div class="text-center mb-5">
      <h2>Đội Ngũ Lãnh Đạo</h2>
      <p class="text-muted">Những người đứng sau thành công của Surfside Media</p>
    </div>
    <div class="row justify-content-center">
      <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="team-member">
          <img src="{{ asset('assets/images/team/team-1.jpg') }}" alt="CEO">
          <h5>Nguyễn Văn A</h5>
          <p class="text-muted">CEO & Founder</p>
          <div class="social-links">
            <a href="#" class="me-2"><i class="fa fa-facebook"></i></a>
            <a href="#" class="me-2"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-linkedin"></i></a>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="team-member">
          <img src="{{ asset('assets/images/team/team-2.jpg') }}" alt="Creative Director">
          <h5>Trần Thị B</h5>
          <p class="text-muted">Creative Director</p>
          <div class="social-links">
            <a href="#" class="me-2"><i class="fa fa-facebook"></i></a>
            <a href="#" class="me-2"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-linkedin"></i></a>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="team-member">
          <img src="{{ asset('assets/images/team/team-3.jpg') }}" alt="Marketing Manager">
          <h5>Lê Văn C</h5>
          <p class="text-muted">Marketing Manager</p>
          <div class="social-links">
            <a href="#" class="me-2"><i class="fa fa-facebook"></i></a>
            <a href="#" class="me-2"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-linkedin"></i></a>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="team-member">
          <img src="{{ asset('assets/images/team/team-4.jpg') }}" alt="Operations Manager">
          <h5>Phạm Thị D</h5>
          <p class="text-muted">Operations Manager</p>
          <div class="social-links">
            <a href="#" class="me-2"><i class="fa fa-facebook"></i></a>
            <a href="#" class="me-2"><i class="fa fa-twitter"></i></a>
            <a href="#"><i class="fa fa-linkedin"></i></a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <div class="mb-5 pb-4"></div>

  <!-- Cam kết -->
  <section class="container">
    <div class="row align-items-center">
      <div class="col-lg-6 order-lg-2 mb-4 mb-lg-0">
        <div class="about-img">
          <img src="{{ asset('assets/images/about/about-2.jpg') }}" alt="Our Commitment" class="w-100">
        </div>
      </div>
      <div class="col-lg-6 order-lg-1">
        <h2 class="mb-4">Cam Kết Của Chúng Tôi</h2>
        <div class="mb-3">
          <h5><i class="fa fa-check-circle text-success me-2"></i>Chất Lượng Đảm Bảo</h5>
          <p>Mọi sản phẩm đều được kiểm tra kỹ lưỡng trước khi đến tay khách hàng.</p>
        </div>
        <div class="mb-3">
          <h5><i class="fa fa-check-circle text-success me-2"></i>Đổi Trả Dễ Dàng</h5>
          <p>Chính sách đổi trả trong vòng 30 ngày, không cần lý do.</p>
        </div>
        <div class="mb-3">
          <h5><i class="fa fa-check-circle text-success me-2"></i>Giao Hàng Nhanh</h5>
          <p>Giao hàng toàn quốc, nhanh chóng trong 2-5 ngày.</p>
        </div>
        <div class="mb-3">
          <h5><i class="fa fa-check-circle text-success me-2"></i>Hỗ Trợ 24/7</h5>
          <p>Đội ngũ chăm sóc khách hàng luôn sẵn sàng hỗ trợ bạn.</p>
        </div>
      </div>
    </div>
  </section>

  <div class="mb-5 pb-4"></div>

  <!-- Call to Action -->
  <section class="container text-center">
    <div class="bg-light rounded-3 p-5">
      <h2 class="mb-4">Tham Gia Cộng Đồng Surfside Media</h2>
      <p class="mb-4">
        Nhận ngay ưu đãi 10% cho đơn hàng đầu tiên khi đăng ký nhận tin từ chúng tôi
      </p>
      <div class="row justify-content-center">
        <div class="col-md-6">
          <form class="input-group">
            <input type="email" class="form-control" placeholder="Email của bạn">
            <button class="btn btn-dark" type="submit">Đăng Ký</button>
          </form>
        </div>
      </div>
    </div>
  </section>

  <div class="mb-5 pb-5"></div>

</main>

@endsection