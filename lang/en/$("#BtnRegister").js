 <style>
      .form-control.error {
        border-color: red !important;
        box-shadow: none !important;
      }
      .alert.alert-danger.warningError {
        border: none !important;
        box-shadow: none !important;
        background-color: transparent !important;
      }
    </style>
    
        
    <div class="col-sm-12 col-md-12 col-lg-5">
      <form id="government-platform" style="background: linear-gradient(135deg, rgb(250, 248, 248), orange); backdrop-filter: blur(10px); padding: 20px; border-radius: 5px;">
        <input type="hidden" name="_token" id="tokenValue" />
        <h2 class="text20 text-center" style="color: #ca7c1c;">Join the 50% Faster, RBI Grade B Selection Squad</h2>
        <div class="formsectionfields" style="padding: 10px;">
          <div class="form-group">
            <input type="text" value="" class="form-control" id="stickyName" placeholder="Your Name" required style="border-radius: 5px;" />
            <div id="eMessageName" class="alert alert-danger warningError" style="display: none;"></div>
          </div>
          <div class="form-group mobileBottomZero">
            <input type="email" value="" class="form-control" id="stickyEmail" placeholder="Your Email ID*" style="border-radius: 5px;" />
            <div id="eMessageEmail" class="alert alert-danger warningError" style="display: none;"></div>
          </div>
          <div class="form-group mobileBottomZero">
            <input type="text" value="" pattern="[2345789][0-9]{9}" maxlength="10" class="form-control" id="sticky_mobile" placeholder="Phone No.*" required style="border-radius: 5px;" />
            <div id="eMessageMobile" class="alert alert-danger warningError" style="display: none;"></div>
          </div>
          <div class="form-group">
            <label for="workingProfessional" style="color: #443a3ad5;">Are you a working professional?</label><br>
            <input type="radio" name="workingProfessional" id="workingProfessionalYes" value="yes" required>
            <label for="workingProfessionalYes" style="color: #443a3ad5;">Yes</label>
            <input type="radio" name="workingProfessional" id="workingProfessionalNo" value="no" required>
            <label for="workingProfessionalNo" style="color: #443a3ad5;">No</label>
            <div id="eMessageProfessional" class="alert alert-danger warningError" style="display: none;"></div>
          </div>
          <div class="row">
            <div class="col-sm-12 text-center">
              <button id="BtnRegister" class="submitButton" type="button" data-source-id="47" data-cf-modified-fab0ac53979d88a5797beb08-="">Submit</button>
            </div>
          </div>
        </div>
      </form>
    </div>
    
    <script>
      document.getElementById('BtnRegister').addEventListener('click', validateForm);
    
      function validateForm() {
        var name = document.getElementById('stickyName');
        var email = document.getElementById('stickyEmail');
        var mobile = document.getElementById('sticky_mobile');
        var workingProfessionalYes = document.getElementById('workingProfessionalYes');
        var workingProfessionalNo = document.getElementById('workingProfessionalNo');
    
        var isValid = true;
    
        if (name.value.trim() === '') {
          document.getElementById('eMessageName').innerHTML = 'Please enter your name.';
          document.getElementById('eMessageName').style.display = 'block';
          name.classList.add('error');
          isValid = false;
        } else {
          document.getElementById('eMessageName').style.display = 'none';
          name.classList.remove('error');
        }
    
        if (email.value.trim() === '') {
          document.getElementById('eMessageEmail').innerHTML = 'Please enter your email ID.';
          document.getElementById('eMessageEmail').style.display = 'block';
          email.classList.add('error');
          isValid = false;
        } else if (!validateEmail(email.value)) {
          document.getElementById('eMessageEmail').innerHTML = 'Please enter a valid email ID.';
          document.getElementById('eMessageEmail').style.display = 'block';
          email.classList.add('error');
          isValid = false;
        } else {
          document.getElementById('eMessageEmail').style.display = 'none';
          email.classList.remove('error');
        }
    
        if (mobile.value.trim() === '') {
          document.getElementById('eMessageMobile').innerHTML = 'Please enter your phone number.';
          document.getElementById('eMessageMobile').style.display = 'block';
          mobile.classList.add('error');
          isValid = false;
        } else if (!validateMobile(mobile.value)) {
          document.getElementById('eMessageMobile').innerHTML = 'Please enter a valid phone number.';
          document.getElementById('eMessageMobile').style.display = 'block';
          mobile.classList.add('error');
          isValid = false;
        } else {
          document.getElementById('eMessageMobile').style.display = 'none';
          mobile.classList.remove('error');
        }
    
        if (!workingProfessionalYes.checked && !workingProfessionalNo.checked) {
          document.getElementById('eMessageProfessional').innerHTML = 'Please select whether you are a working professional.';
          document.getElementById('eMessageProfessional').style.display = 'block';
          isValid = false;
        } else {
          document.getElementById('eMessageProfessional').style.display = 'none';
        }
    
        return isValid;
      }
    
      function validateEmail(email) {
        var emailRegex = /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/;
        return emailRegex.test(email);
      }
    
      function validateMobile(mobile) {
        var mobileRegex = /^[2345789]\d{9}$/;
        return mobileRegex.test(mobile);
      }
    
    </script>
