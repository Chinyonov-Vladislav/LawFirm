<template>
    <fragment>
        <my-preloader></my-preloader>
        <my-header></my-header>
        <!-- Start Sign up Area -->
        <div class="sign-up-area ptb-100" style="margin-top: 137px;">
            <div class="container">
                <div class="section-title">
                    <h2>Create an Account!</h2>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Laudantium quas cumque iste veniam id
                        dolorem deserunt ratione error voluptas rem ullam.</p>
                </div>

                <div class="sign-up-form" >
                    <form id="registration_form" @submit.prevent="CheckAndSendForm">
                        <div class="input-group mb-5">
                            <input v-model="username" v-bind:class="{ 'is-invalid': errors.textUsernameErrors.length >0 }" readonly onfocus="this.removeAttribute('readonly')" type="text" class="form-control" id="email" placeholder="Enter your username">
                            <div class="invalid-feedback" v-if="errors.textUsernameErrors.length >0">
                                <div class="col-lg-12 ">
                                    <ul>
                                        <li v-for="item in errors.textUsernameErrors">
                                            {{item.message}}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="input-group mb-5">
                            <input v-model="email" v-bind:class="{ 'is-invalid': errors.textEmailErrors.length >0 }" readonly onfocus="this.removeAttribute('readonly')" type="text" class="form-control" id="email" placeholder="Enter your email">
                            <div class="invalid-feedback" v-if="errors.textEmailErrors.length >0">
                                <div class="col-lg-12 ">
                                    <ul>
                                        <li v-for="item in errors.textEmailErrors">
                                            {{item.message}}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="input-group mb-5">
                            <input v-model="password" v-bind:class="{ 'is-invalid': errors.textPasswordErrors.length >0 }" readonly onfocus="this.removeAttribute('readonly')" type="password" class="form-control" id="Password" placeholder="Enter your password">
                            <span  class="input-group-text bg-transparent" id="inputPasswordEye" @click="showHidePassword"><i id="eye_password" class="lar la-eye"></i></span>
                            <div class="invalid-feedback" v-if="errors.textPasswordErrors.length >0">
                                <div class="col-lg-12 ">
                                    <ul>
                                        <li v-for="item in errors.textPasswordErrors">
                                            {{item.message}}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>


                        <div class="input-group mb-5">
                            <input v-model="confirm_password" v-bind:class="{ 'is-invalid': errors.textConfirmPasswordErrors.length >0 }" readonly onfocus="this.removeAttribute('readonly')" type="password" class="form-control" id="СonfirmPassword" placeholder="Confirm your password">
                            <span  class="input-group-text bg-transparent" id="inputConfirmPasswordEye" @click="showHidePassword"><i id="eye_confirm_password" class="lar la-eye"></i></span>
                            <div class="invalid-feedback" v-if="errors.textConfirmPasswordErrors.length >0">
                                <div class="col-lg-12 ">
                                    <ul>
                                        <li v-for="item in errors.textConfirmPasswordErrors">
                                            {{item.message}}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn default-btn-one">Sign Up</button>
                            <p class="account-decs">
                                Already have an account? <a href="/login">Sign In</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- End Sign up  Area -->
        <my-footer></my-footer>
    </fragment>
</template>

<script>
import Swal from "sweetalert2";

export default {
    name: "RegistrationPage",
    data() {
        return {
            username: "",
            email: "",
            password:"",
            confirm_password:"",
            errors: {
                textEmailErrors: [],
                textPasswordErrors: [],
                textUsernameErrors:[],
                textConfirmPasswordErrors:[]
            }
        }
    },
    methods:{
        ControlElementOnForm(bool_block)
        {
            var form = document.getElementById("registration_form");
            var elements = form.elements;
            for (var i = 0, len = elements.length; i < len; ++i) {
                elements[i].readOnly = bool_block;
            }
        },
        MakeRegistration()
        {
            this.errors.textUsernameErrors = [];
            this.errors.textEmailErrors = [];
            this.errors.textPasswordErrors = [];
            this.errors.textConfirmPasswordErrors = [];
            const userData = {
                name: this.username,
                email: this.email,
                password: this.password,
                password_confirmation: this.confirm_password,
            };
            axios.post("/register", userData).then(response=>{
                if (response.data.errors)
                {
                    Object.keys(response.data.errors).map((key)=>{
                            response.data.errors[key].map((elem)=>{
                                if(key === "email") {
                                    this.errors.textEmailErrors.push({
                                        message: elem
                                    })
                                }
                                else if(key === "password")
                                {
                                    this.errors.textPasswordErrors.push({
                                        message: elem
                                    })
                                }
                                else if(key === "name")
                                {
                                    this.errors.textUsernameErrors.push({
                                        message: elem
                                    })
                                }
                                else if(key === "password_confirmation")
                                {
                                    this.errors.textConfirmPasswordErrors.push({
                                        message: elem
                                    })
                                }
                            })
                    })
                }
                else if(!response.data.error)
                {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Новый аккаунт был успешно зарегистрирован!',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(()=>{
                        window.location.href="/login";
                    });
                }
                else
                {
                    console.log(response);
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        text: response.data.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(()=>{
                        this.ControlElementOnForm(false);
                    });
                }
            }).catch(error=>{
                console.log(error);
                this.ControlElementOnForm(false);
            });
        },
        CheckAndSendForm()
        {
            this.ControlElementOnForm(true);
            let hasError = this.validate();
            if(!hasError)
            {
                this.MakeRegistration();
            }
            else
            {
                this.ControlElementOnForm(false);
            }
        },
        validate()
        {
            let hasError = false;
            this.errors.textUsernameErrors = [];
            this.errors.textEmailErrors = [];
            this.errors.textPasswordErrors = [];
            this.errors.textConfirmPasswordErrors = [];
            if(this.username.length <=0)
            {
                this.errors.textUsernameErrors.push({message: "Поле для ввода имени пользователя не заполнено!"});
                hasError = true;
            }
            if(this.email.length <=0)
            {
                this.errors.textEmailErrors.push({message: "Поле для ввода email-адреса не заполнено!"});
                hasError = true;
            }
            if(this.password.length <8)
            {
                this.errors.textPasswordErrors.push({message: "Текст в поле \"Пароль\" слишком короткий. Должно быть как минимум 8 символов!"})
                hasError = true;
            }
            if(this.confirm_password !== this.password)
            {
                this.errors.textConfirmPasswordErrors.push({message: "Текст в полях \"Пароль\" и \"Подтверждение пароля\" не совпадают!"});
                hasError = true;
            }
            if (this.confirm_password === "")
            {
                this.errors.textConfirmPasswordErrors.push({message: "Поле \"Подтверждение пароля\" не заполнено!"});
                hasError = true;
            }
            return hasError;
        },
        showHidePassword(event)
        {
            let clickedElement = event.target;
            let idClickedElement = clickedElement.id;

            let passwordInputId, eyeElement;

            if (idClickedElement === "inputPasswordEye" || idClickedElement === "eye_password") {
                passwordInputId = "Password";
                eyeElement = idClickedElement === "eye_password" ? event.target : event.target.querySelector('i');
            } else if (idClickedElement === "inputConfirmPasswordEye" || idClickedElement === "eye_confirm_password") {
                passwordInputId = "СonfirmPassword";
                eyeElement = idClickedElement === "eye_confirm_password" ? event.target : event.target.querySelector('i');
            }

            let elementPasswordInput = document.getElementById(passwordInputId);

            if (elementPasswordInput.type === "password") {
                elementPasswordInput.type = "text";
                eyeElement.classList.remove("la-eye");
                eyeElement.classList.add("la-eye-slash");
            } else {
                elementPasswordInput.type = "password";
                eyeElement.classList.remove("la-eye-slash");
                eyeElement.classList.add("la-eye");
            }
        }
    }
}
</script>

<style scoped>

</style>
