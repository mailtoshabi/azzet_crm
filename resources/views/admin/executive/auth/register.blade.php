@extends('admin.layouts.executive.master-without-nav')
@section('title')
@lang('translation.Register')
@endsection
@section('css')
<link href="{{ URL::asset('assets/libs/twitter-bootstrap-wizard/twitter-bootstrap-wizard.min.css') }}" rel="stylesheet">
<style type="text/css">
    #personal_information,
    #company_information{
        display:none;
    }
</style>
@endsection
@section('content')
<div class="auth-page">
    <div class="container-fluid p-0">
        <div class="row g-0">
            <div class="col-xxl-6 col-lg-6 col-md-6">
                <div class="auth-full-page-content d-flex p-sm-5 p-4">
                    <div class="w-100">
                        <div class="d-flex flex-column h-100">
                            <div class="mb-4 mb-md-5 text-center">
                                <a href="{{ url('/') }}" class="d-block auth-logo">
                                    <img src="{{ URL::asset('assets/images/logo-sm.svg') }}" alt="" height="28"> <span class="logo-txt">Dason</span>
                                </a>
                            </div>
                            <div class="auth-content my-auto">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title mb-0">Create an account</h4>
                                                <p class="text-muted mb-0">Already have an account ? <a href="{{ route('seller.login') }}" class="text-primary fw-semibold"> Sign in here </a> </p>
                                            </div>

                                <div class="mt-5 text-center">

                                </div>

                                <form action="{{ route('seller.store') }}" method="POST" enctype="multipart/form-data">
                                    @method('POST')
                                    @csrf
                                            <div class="card-body">
                                                <div id="basic-pills-wizard" class="twitter-bs-wizard">
                                                    <ul class="twitter-bs-wizard-nav">
                                                        <li class="nav-item">
                                                            <a href="#seller-details" class="nav-link" data-toggle="tab">
                                                                <div class="step-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Seller Details">
                                                                    <i class="bx bx-list-ul"></i>
                                                                </div>
                                                            </a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a href="#company-document" class="nav-link" data-toggle="tab">
                                                                <div class="step-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Company Document">
                                                                    <i class="bx bx-book-bookmark"></i>
                                                                </div>
                                                            </a>
                                                        </li>

                                                        <li class="nav-item">
                                                            <a href="#bank-detail" class="nav-link" data-toggle="tab">
                                                                <div class="step-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Bank Details">
                                                                    <i class="bx bxs-bank"></i>
                                                                </div>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                    <!-- wizard-nav -->

                                                    <div class="tab-content twitter-bs-wizard-tab-content">

                                                        <div class="tab-pane" id="seller-details">
                                                            <div class="text-center mb-4">
                                                                <h5>Seller Details</h5>
                                                                <p class="card-title-desc">Fill all information below</p>
                                                            </div>

                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <div class="mb-3">
                                                                            <label for="first_name" class="form-label">First name</label>
                                                                            <input type="text" class="form-control" placeholder="Enter Your First Name" id="first_name" name="first_name">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="mb-3">
                                                                            <label for="last_name" class="form-label">Last name</label>
                                                                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Your Last Name">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <div class="mb-3">
                                                                            <label for="phone" class="form-label">Phone</label>
                                                                            <input type="text" class="form-control"  placeholder="Enter Your Phone No." id="phone" name="phone">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="mb-3">
                                                                            <label for="email" class="form-label">Email</label>
                                                                            <input type="text" class="form-control" placeholder="Enter Your Email ID" id="email" name="email">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <div class="mb-3">
                                                                            <label for="password" class="form-label">Password</label>
                                                                            <input type="password" class="form-control" placeholder="Passwrod" id="password" name="password">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="mb-3">
                                                                            <label for="confirmpassword" class="form-label">Confirm Password</label>
                                                                            <input type="password" class="form-control" placeholder="Confirm Passwrod" id="confirmpassword" name="confirmpassword">
                                                                        </div>
                                                                    </div>

                                                                </div>

                                                                <div class="row">

                                                                    <div class="col-lg-12">
                                                                        <div class="mb-3">
                                                                            <label for="address" class="form-label">Address</label>
                                                                            <textarea class="form-control" rows="2" placeholder="Enter Your Address" id="address" name="address"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            <ul class="pager wizard twitter-bs-wizard-pager-link">
                                                                <li class="next"><a href="javascript: void(0);" class="btn btn-primary" id="next" onclick="nextTab(0)">Next <i
                                                                            class="bx bx-chevron-right ms-1"></i></a></li>
                                                            </ul>
                                                        </div>
                                                        <!-- tab pane -->
                                                        <div class="tab-pane" id="company-document">
                                                            <div>
                                                            <div class="text-center mb-4">
                                                                <h5>Company Document</h5>
                                                                <p class="card-title-desc">Fill all information below</p>
                                                            </div>

                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <div class="mb-3">
                                                                            <label for="legal_name" class="form-label">Leagal Name</label>
                                                                            <input type="text" class="form-control" id="legal_name" name="legal_name" placeholder="Legal Name">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-6">
                                                                        <div class="mb-3">
                                                                            <label for="business_email" class="form-label">Business Email</label>
                                                                            <input type="text" class="form-control" id="business_email" name="business_email" placeholder="Business Email">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <div class="mb-3">
                                                                            <label for="vat_number" class="form-label">VAT/TIN No.</label>
                                                                            <input type="text" class="form-control" id="vat_number" name="vat_number" placeholder="VAT/TIN No.">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-6">
                                                                        <div class="mb-3">
                                                                            <label for="vat_scan" class="form-label">VAT Certificate </label>
                                                                            <input type="file" class="form-control" name="vat_scan" id="vat_scan" >


                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <div class="mb-3">
                                                                            <label for="cr_number" class="form-label">CR Number</label>
                                                                            <input type="text" class="form-control" id="cr_number" name="cr_number" placeholder="CR Number">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-6">
                                                                        <div class="mb-3">
                                                                            <label for="cr_scan" class="form-label">CR Scan</label>
                                                                            <input type="file" class="form-control" name="cr_scan" id="cr_scan" />


                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <div class="mb-3">
                                                                            <label for="image" class="form-label">Logo</label>
                                                                            <input type="file" class="form-control" name="image" id="image" />
                                                                        </div>
                                                                    </div>

                                                                </div>



                                                            <ul class="pager wizard twitter-bs-wizard-pager-link">
                                                                <li class="previous"><a href="javascript: void(0);" class="btn btn-primary" onclick="nextPrev(-1)"><i
                                                                            class="bx bx-chevron-left me-1"></i> Previous</a></li>
                                                                <li class="next"><a href="javascript: void(0);" class="btn btn-primary" onclick="nextPrev(1)">Next <i
                                                                            class="bx bx-chevron-right ms-1"></i></a></li>
                                                            </ul>
                                                            </div>
                                                        </div>
                                                        <!-- tab pane -->
                                                        <div class="tab-pane" id="bank-detail">
                                                            <div>
                                                                <div class="text-center mb-4">
                                                                    <h5>Bank Details</h5>
                                                                    <p class="card-title-desc">Fill all information below</p>
                                                                </div>

                                                                    <div class="row">
                                                                        <div class="col-lg-6">
                                                                            <div class="mb-3">
                                                                                <label for="bank_id" class="form-label">Bank Name</label>
                                                                                <select class="form-select" id="bank_id" name="bank_id">
                                                                                    <option selected>Select Bank Details</option>
                                                                                    @foreach ($banks as $bank)
                                                                                    <option value="{{ $bank->id }}">{{ $bank->name_en }}</option>
                                                                                    @endforeach
                                                                            </select>


                                                                            </div>
                                                                        </div>

                                                                        <div class="col-lg-6">
                                                                            <div class="mb-3">
                                                                                <label class="form-label">Branch Name</label>
                                                                                <input type="text" class="form-control" placeholder="Branch Name" id="branch_name" name="branch_name">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-lg-6">
                                                                            <div class="mb-3">
                                                                                <label for="iban_number" class="form-label">IBAN </label>
                                                                                <input type="text" class="form-control" placeholder="IBAN" id="iban_number" name="iban_number">
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-lg-6">
                                                                            <div class="mb-3">
                                                                                <label for="account_number" class="form-label">Account Number
                                                                                </label>
                                                                                <input type="text" class="form-control" id="account_number" name="account_number" placeholder="Account Number">
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                <ul class="pager wizard twitter-bs-wizard-pager-link">
                                                                    <li class="previous"><a href="javascript: void(0);" class="btn btn-primary" onclick="nextTab(1)"><i
                                                                                class="bx bx-chevron-left me-1"></i> Previous</a></li>
                                                                    <li class="float-end">
                                                                        <input type="submit" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".confirmModal"></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <!-- tab pane -->
                                                    </div>
                                                    <!-- end tab content -->
                                                </div>
                                            </div>
                                            <!-- end card body -->

                                </form>
                                        </div>
                                        <!-- end card -->
                                    </div>
                                    <!-- end col -->
                                </div>
                            </div>
                            <div class="mt-4 mt-md-5 text-center">
                                <p class="mb-0">© <script>document.write(new Date().getFullYear())</script> Dason   . Crafted with <i class="mdi mdi-heart text-danger"></i> by WebMahal.com</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end auth full page content -->
            </div>
            <!-- end col -->
            <div class="col-xxl-6 col-lg-6 col-md-6">
                <div class="auth-bg pt-md-5 p-4 d-flex">
                    <div class="bg-overlay"></div>
                    <ul class="bg-bubbles">
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                    </ul>
                    <!-- end bubble effect -->
                    <div class="row justify-content-center align-items-end">
                        <div class="col-xl-7">
                            <div class="p-0 p-sm-4 px-xl-0">
                                <div id="reviewcarouselIndicators" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-indicators auth-carousel carousel-indicators-rounded justify-content-center mb-0">
                                        <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1">
                                            <img src="{{ URL::asset('assets/images/users/avatar-1.jpg') }}" class="avatar-md img-fluid rounded-circle d-block" alt="...">
                                        </button>
                                        <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="1" aria-label="Slide 2">
                                            <img src="{{ URL::asset('assets/images/users/avatar-2.jpg') }}" class="avatar-md img-fluid rounded-circle d-block" alt="...">
                                        </button>
                                        <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="2" aria-label="Slide 3">
                                            <img src="{{ URL::asset('assets/images/users/avatar-3.jpg') }}" class="avatar-md img-fluid rounded-circle d-block" alt="...">
                                        </button>
                                    </div>
                                    <!-- end carouselIndicators -->
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <div class="testi-contain text-center text-white">
                                                <i class="bx bxs-quote-alt-left text-success display-6"></i>
                                                <h4 class="mt-4 fw-medium lh-base text-white">“I feel confident
                                                    imposing change
                                                    on myself. It's a lot more progressing fun than looking back.
                                                    That's why
                                                    I ultricies enim
                                                    at malesuada nibh diam on tortor neaded to throw curve balls.”
                                                </h4>
                                                <div class="mt-4 pt-1 pb-5 mb-5">
                                                    <h5 class="font-size-16 text-white">Richard Drews
                                                    </h5>
                                                    <p class="mb-0 text-white-50">Web Designer</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="carousel-item">
                                            <div class="testi-contain text-center text-white">
                                                <i class="bx bxs-quote-alt-left text-success display-6"></i>
                                                <h4 class="mt-4 fw-medium lh-base text-white">“Our task must be to
                                                    free ourselves by widening our circle of compassion to embrace
                                                    all living
                                                    creatures and
                                                    the whole of quis consectetur nunc sit amet semper justo. nature
                                                    and its beauty.”</h4>
                                                <div class="mt-4 pt-1 pb-5 mb-5">
                                                    <h5 class="font-size-16 text-white">Rosanna French
                                                    </h5>
                                                    <p class="mb-0 text-white-50">Web Developer</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="carousel-item">
                                            <div class="testi-contain text-center text-white">
                                                <i class="bx bxs-quote-alt-left text-success display-6"></i>
                                                <h4 class="mt-4 fw-medium lh-base text-white">“I've learned that
                                                    people will forget what you said, people will forget what you
                                                    did,
                                                    but people will never forget
                                                    how donec in efficitur lectus, nec lobortis metus you made them
                                                    feel.”</h4>
                                                <div class="mt-4 pt-1 pb-5 mb-5">
                                                    <h5 class="font-size-16 text-white">Ilse R. Eaton</h5>
                                                    <p class="mb-0 text-white-50">Manager
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end carousel-inner -->
                                </div>
                                <!-- end review carousel -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container fluid -->
</div>
@endsection
@section('script')
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> --}}
<script src="{{ URL::asset('assets/libs/twitter-bootstrap-wizard/twitter-bootstrap-wizard.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/form-wizard.init.js') }}"></script>
{{-- <script src="{{ URL::asset('/assets/js/app.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/feather-icon.init.js') }}"></script>
<script src="{{ URL::asset('assets/js/pages/form-validation.init.js') }}"></script> --}}
@endsection



