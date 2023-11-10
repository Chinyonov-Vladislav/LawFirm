<template>
    <fragment>
        <my-preloader></my-preloader>
        <my-header></my-header>
        <div class="sign-in-area ptb-100">
            <div class="container">
                <div class="section-title mt-changePassword-title">
                    <h2>Смена пароля</h2>
                </div>
                <div class="sign-in-form">
                    <div class="form-group mt-2">
                        <label for="Password">Пароль</label>
                        <div class="input-group ">
                            <input v-model="password_info.password"
                                   readonly onfocus="this.removeAttribute('readonly')"
                                   v-bind:class="{ 'is-invalid': errors.password_errors.length >0 }"
                                   type="password" class="form-control"
                                   id="Password" placeholder="Введите пароль">
                            <span class="input-group-text bg-transparent" id="inputPasswordEye"
                                  @click="showHidePassword"><i id="eye_password"
                                                               class="lar la-eye"></i></span>
                            <div class="invalid-feedback" v-if="errors.password_errors.length >0">
                                <div class="col-lg-12">
                                    <ul>
                                        <li v-for="item in errors.password_errors">
                                            {{ item.message }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-2">
                        <label for="СonfirmPassword">Подтверждение пароля</label>
                        <div class="input-group">
                            <input v-model="password_info.password_confirm"
                                   v-bind:class="{ 'is-invalid': errors.confirm_password_errors.length >0 }"
                                   type="password"
                                   readonly onfocus="this.removeAttribute('readonly')"
                                   class="form-control"
                                   id="СonfirmPassword"
                                   placeholder="Подтверждение пароля">
                            <span class="input-group-text bg-transparent" id="inputConfirmPasswordEye"
                                  @click="showHidePassword"><i id="eye_confirm_password"
                                                               class="lar la-eye"></i></span>
                            <div class="invalid-feedback" v-if="errors.confirm_password_errors.length >0">
                                <div class="col-lg-12">
                                    <ul>
                                        <li v-for="item in errors.confirm_password_errors">
                                            {{ item.message }}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 mt-2">
                        <button @click="saveChanges" id="saveChangePassword" class="btn default-btn-one">Сохранить
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <my-footer></my-footer>
    </fragment>
</template>

<script>
import Swal from "sweetalert2";

export default {
    name: "ChangePasswordPage",
    data(){
        return {
            password_info:{
                password: "",
                password_confirm: ""
            },
            errors:{
                password_errors: [],
                confirm_password_errors: []
            }
        }
    },
    props:{
        email:{default:null},

    },
    methods:{
        validate()
        {
            this.errors.password_errors = [];
            this.errors.confirm_password_errors = [];
            let hasError = false;
            if (this.password_info.password.length <= 0) {
                this.errors.password_errors.push({"message": "Поле \"Пароль\" не заполнено"})
                hasError = true;
            }
            if (this.password_info.password_confirm.length <= 0)
            {
                this.errors.confirm_password_errors.push({"message": "Поле \"Подтверждение пароля\" не заполнено"})
                hasError = true;
            }
            if(this.password_info.password.length > 0 && this.password_info.password_confirm.length>0)
            {
                if (this.password_info.password !== this.password_info.password_confirm)
                {
                    this.errors.password_errors.push({"message": "Значение в поле \"Пароль\" не совпадает со значением в поле \"Подтверждение пароля\""});
                    this.errors.confirm_password_errors.push({"message": "Значение в поле \"Подтверждение пароля\" не совпадает со значением в поле \"Пароль\""});
                    hasError = true;
                }
                else
                {
                    if (this.password_info.password.length < 8) {
                        this.errors.password_errors.push({"message": "Минимальная длина пароля должна составлять 8 символов"});
                        hasError = true;
                    }
                }
            }
            return hasError;
        },
        controlButtonSaveNewPassword(flag_control)
        {
            document.getElementById("saveChangePassword").disabled = flag_control;
        },
        saveChanges()
        {
            this.controlButtonSaveNewPassword(true);
            if(!this.validate())
            {
                this.makeRequestSaveNewPassword();
            }
            else
            {
                this.controlButtonSaveNewPassword(false);
            }
        },
        makeRequestSaveNewPassword()
        {
            let data = {
                'email':this.email,
                'password': this.password_info.password,
                'confirm_password': this.password_info.password_confirm
            };
            axios.put("/restorePassword", data).then((response)=>{
                if(response.data.errors)
                {
                    Object.keys(response.data.errors).map((key)=>{
                        response.data.errors[key].map((elem)=> {
                            if(key==="password")
                            {
                                this.errors.password_errors.push({"message": elem});
                            }
                            else if(key==="confirm_password")
                            {
                                this.errors.confirm_password_errors.push({"message": elem});
                            }
                        });
                    });
                    this.controlButtonSaveNewPassword(false);
                }
                else{
                    if(response.data.success)
                    {
                        this.showSwal("success", response.data.message).then(()=>{
                            window.location="/login"
                        });
                    }
                    else
                    {
                        this.showSwal("error", response.data.message).then(()=>{
                            this.controlButtonSaveNewPassword(false);
                        });
                    }
                }
            }).catch((error)=>{
                this.showSwal("error",error.text);
            });
        },
        showSwal(icon, title_text) {
            return Swal.fire({
                position: 'top-end',
                icon: icon,
                title: title_text,
                showConfirmButton: false,
                timer: 1500
            })
        },
        showHidePassword(event) {
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
        },
    }
}
</script>

<style scoped>

</style>
