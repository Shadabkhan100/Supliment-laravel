<form
    id="adminForm"
    action="{{ url('/signup-user') }}"
    method="POST">

    @csrf

    <div class="drawer-body">

        <div class="drawer-card">

            <h5 class="mb-4">
                <i class="fa fa-user-shield text-primary me-2"></i>
                Add New Administrator
            </h5>

            <div class="row">

                <!-- Full Name -->

                <div class="col-12 mb-4">

                    <label>Full Name</label>

                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        placeholder="Enter Full Name"
                        required>

                </div>

                <!-- Email -->

                <div class="col-12 mb-4">

                    <label>Email Address</label>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        placeholder="Enter Email Address"
                        required>

                </div>

                <!-- Password -->

                <div class="col-12 mb-4">

                    <label>Password</label>

                    <div class="position-relative">

                        <input style="color:black;"

                            type="password"
                            id="admin_password"
                            name="password"
                            class="form-control pe-5"
                            placeholder="Enter Password"
                            required>

                        <i class="fa fa-eye"
                           id="togglePassword"
                           style="position:absolute;right:18px;top:50%;transform:translateY(-50%);cursor:pointer;"></i>

                    </div>

                </div>

                <!-- Rank -->

                <div class="col-12 mb-4">

                    <label>Admin Rank</label>

                    <select style="color:black;"
                        name="status"
                        class="form-control"
                        required>

                        <option value="">Select Rank</option>

                        <option value="Admin" style="color:black;"
>
                            Admin
                        </option>

                        <option style="color:black;"
 value="Sub Admin">
                            Sub Admin
                        </option>

                    </select>

                </div>

            </div>

        </div>

    </div>

    <div class="drawer-footer">

        <button
            type="submit"
            class="btn btn-primary btn-lg">

            <i class="fa fa-user-plus me-2"></i>

            Create Admin

        </button>

    </div>

</form>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>

$('#togglePassword').click(function(){

    let input = $('#admin_password');

    if(input.attr('type') === 'password'){

        input.attr('type','text');

        $(this)
            .removeClass('fa-eye')
            .addClass('fa-eye-slash');

    }else{

        input.attr('type','password');

        $(this)
            .removeClass('fa-eye-slash')
            .addClass('fa-eye');

    }

});




$(document).ready(function(){

    /* ==========================
       SHOW / HIDE PASSWORD
    ========================== */

    $('#togglePassword').click(function(){

        let input = $('#admin_password');

        if(input.attr('type') === 'password'){

            input.attr('type','text');

            $(this)
                .removeClass('fa-eye')
                .addClass('fa-eye-slash');

        }else{

            input.attr('type','password');

            $(this)
                .removeClass('fa-eye-slash')
                .addClass('fa-eye');

        }

    });


    /* ==========================
        AJAX SUBMIT
    ========================== */

    $('#adminForm').on('submit', function(e){

        e.preventDefault();

        let form = $(this);

        let btn = form.find('button[type="submit"]');

        let oldText = btn.html();

        btn.prop('disabled', true);

        btn.html('<i class="fa fa-spinner fa-spin me-2"></i> Creating...');

        $.ajax({

            url: form.attr('action'),

            type: 'POST',

            data: form.serialize(),

            dataType: 'json',

            success:function(response){
             
                btn.prop('disabled', false);

                btn.html(oldText);

                Swal.fire({

                    icon:'success',

                    title:'Success',

                    text: response.message

                });

                form.trigger('reset');

                $('#admin_password').attr('type','password');

                $('#togglePassword')
                    .removeClass('fa-eye-slash')
                    .addClass('fa-eye');

            },

            error:function(xhr){

                btn.prop('disabled', false);

                btn.html(oldText);

                let message = 'Something went wrong.';

                if(xhr.responseJSON){

                    if(xhr.responseJSON.message){

                        message = xhr.responseJSON.message;

                    }

                    if(xhr.responseJSON.errors){

                        message = Object.values(xhr.responseJSON.errors)[0][0];

                    }

                }

                Swal.fire({

                    icon:'error',

                    title:'Error',

                    text:message

                });

            }

        });

    });

});


</script>