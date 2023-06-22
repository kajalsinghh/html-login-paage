@extends('layouts.app')
@section('title', 'Profile')

@section('content')
<script src="https://cdn.tiny.cloud/1/YOUR_API_KEY/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<div class="container">
    <div class="row my-5">
        <div class="col-lg-12">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="text-secondary fw-bold">User Exam Profile</h2>
                    <a href="{{ route('exam.logout') }}" class="btn btn-dark">Logout</a>
                </div>
                <div class="card-body p-5">
                    <div class="row">
                        <div class="col-lg-4 px-5 text-center" style="border-right:1px solid #999;">
                            @if($userInfo->picture) 
                            <img src="storage/images/{{ $userInfo->picture }}" id="image_preview" class="img-fluid rounded-circle img-thumbnail" width="200">
                            @else
                            <img src="{{ asset('img/profile.jpg') }}"  id="image_preview" class="img-fluid rounded-circle img-thumbnail" width="200">
                            @endif     
                            <div>
                                <label for="picture">Change Profile Picture</label>
                                <input type="file" name="picture" id="picture" class="form-control rounded-pill">
                            </div>
                        </div>
                        <input type="hidden" name="user_id" id="user_id" value="{{ $userInfo->id }}">
                        <div class="col-lg-8 px-5">
                            <form action="#" method="POST" id="profile_form">
                                @csrf
                                <div class="my-2">
                                    <label for="name">Full Name</label>
                                    <input type="text" name="name" id="name" class="form-control rounded-0" value="{{ $userInfo->name }}">
                                    <div class="invalid-feedback" id="name_error"></div>
                                </div>

                                <div class="my-2">
                                    <label for="examname">Exam Name</label>
                                    <input type="text" name="examname" id="examname" class="form-control rounded-0" value="{{ $userInfo->examname }}">
                                    <div class="invalid-feedback" id="examname_error"></div>
                                </div>
                                <div class="my-2">
                                    <label for="email">E-Mail</label>
                                    <input type="email" name="email" id="email" class="form-control rounded-0" value="{{ $userInfo->email }}">
                                    <div class="invalid-feedback" id="email_error"></div>
                                </div>
                                <div class="col-lg">
                                    <label for="gender">Gender</label>
                                    <select name="gender" id="gender" class="form-select rounded-o">
                                        <option value="" selected disabled>-Select-</option>
                                        <option value="Male" {{ $userInfo->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ $userInfo->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                        <option value="Gay" {{ $userInfo->gender == 'Gay' ? 'selected' : '' }}>Gay</option>
                                        <option value="Lesbian" {{ $userInfo->gender == 'Lesbian' ? 'selected' : '' }}>Lesbian</option>
                                    </select>
                                    <div class="invalid-feedback" id="gender_error"></div>
                                </div>
                                <div class="my-2">
                                    <label for="bio">BIO</label>
                                    <textarea name="bio" id="bio" class="form-control rounded-0">{{ $userInfo->bio }}</textarea>
                                    <div class="invalid-feedback" id="bio_error"></div>
                                </div>

                                <div class="col-lg">
                                    <label for="dob">Date Of Birth</label>
                                    <input type="date" name="dob" id="dob" class="form-control rounded-0" value="{{ $userInfo->dob }}">
                                    <div class="invalid-feedback" id="dob_error"></div>
                                </div>
                                <div class="my-2">
                                    <input type="submit" value="Update Profile" class="btn btn-primary rounded-0 float-end" id="profile_btn">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>   
@endsection

@section('script')
<script>
    tinymce.init({
      selector: '#bio',
      height: 300,
      menubar: false,
      plugins: [
        'advlist autolink lists link image charmap print preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table paste code help wordcount'
      ],
      toolbar: 'undo redo | formatselect | ' +
        'bold italic backcolor | alignleft aligncenter ' +
        'alignright alignjustify | bullist numlist outdent indent | ' +
        'removeformat | help',
      content_css: '//www.tiny.cloud/css/codepen.min.css'
    });
    
    $(function(){
        $("#picture").change(function(e){
            const file = e.target.files[0];
            let url = window.URL.createObjectURL(file);
            $("#image_preview").attr('src', url );
            let fd = new FormData();
            fd.append('picture',file);
            fd.append('user_id',$("#user_id").val());
            fd.append('_token','{{ csrf_token() }}');
            $.ajax({
                url: '{{ route('profile.image') }}',
                method: 'post',
                data: fd,
                cache: false,
                processData: false,
                contentType: false,
                dataType: 'json',
                success:function(response){
                }
            });
        });

        $("#profile_form").submit(function(e){
            e.preventDefault();
            let id = $("#user_id").val();
            $("#profile_btn").val('Updating...');
            removeValidationClasses();

            var name       = $("#name").val();
            var examname   = $("#examname").val();
            var email      = $("#email").val();
            var gender     = $("#gender").val();
            var dob        = $("#dob").val();
            var bio        = tinymce.activeEditor.getContent();

            var valid = true;

            if (name.trim() === "") {
                showError('name', 'Name is required.');
                valid = false;
            }

            if (examname.trim() === "") {
                showError('examname', 'Exam name is required.');
                valid = false;
            }

            if (!validateEmail(email)) {
                showError('email', 'Invalid email address.');
                valid = false;
            }

            if (gender === "") {
                showError('gender', 'Gender is required.');
                valid = false;
            }
            if (bio.trim() === "") {
                showError('bio', 'Bio is required.');
                valid = false;
            }

            if (dob === "") {
                showError('dob', 'Date of birth is required.');
                valid = false;
            }

            if(valid){
                $.ajax({
                    url: '{{ route('profile.update') }}',
                    method: 'post',
                    data: { 
                        id: id,
                        name: name,
                        examname: examname,
                        email: email,
                        gender: gender,
                        dob: dob,
                        bio: bio,
                        _token: '{{ csrf_token() }}' 
                    },
                    dataType: 'json',
                    success:function(response){
                        if(response.success){
                            $("#profile_btn").val('Update Profile');
                            showSuccess(response.success);
                            var alert = $('<div class="alert alert-success mt-1">Thank you! Your data Has Been Updated.</div>');
                            $(this).after(alert);

                        }
                        else if(response.error){
                            $("#profile_btn").val('Update Profile');
                            showError('profile', response.error);
                        }
                    }
                });
            } else {
                $("#profile_btn").val('Update Profile');
            }
        });

        function validateEmail(email) {
            var re = /\S+@\S+\.\S+/;
            return re.test(email);
        }

        function showError(id, error) {
            $("#" + id).addClass("is-invalid");
            $("#" + id + "_error").text(error);
        }

        function showSuccess(message) {
            $(".invalid-feedback").empty();
            $(".form-control").removeClass("is-invalid");
            $(".form-control").addClass("is-valid");
            $(".valid-feedback").text(message);
        }

        function removeValidationClasses() {
            $(".invalid-feedback").empty();
            $(".valid-feedback").empty();
            $(".form-control").removeClass("is-invalid");
            $(".form-control").removeClass("is-valid");
        }
    });
</script>
@endsection
