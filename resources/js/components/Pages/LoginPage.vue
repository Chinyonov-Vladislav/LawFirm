<template>
    <fragment>
        <my-preloader></my-preloader>
        <my-header></my-header>
        <div class="sign-in-area ptb-100">
            <div class="container" style="margin-top: 100px;">
                <div class="section-title">
                    <breadcrumbs :prop_breadcrumbs="breadcrumbs"></breadcrumbs>
                    <h2>Авторизация</h2>
                </div>
                <div class="sign-in-form">
                    <form id="login_form" @submit.prevent="ValidateAndSendForm">
                        <div class="input-group mb-5">
                            <input v-model="email" v-bind:class="{ 'is-invalid': errors.textEmailErrors.length >0 }"
                                   readonly onfocus="this.removeAttribute('readonly')" type="text" class="form-control"
                                   id="email" placeholder="Enter your Email">
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
                            <input v-model="password"
                                   v-bind:class="{ 'is-invalid': errors.textPasswordErrors.length >0 }" readonly
                                   onfocus="this.removeAttribute('readonly')" type="password" class="form-control"
                                   id="Password" placeholder="Enter your password">
                            <span class="input-group-text bg-transparent" id="inputPasswordEye"
                                  @click="showHidePassword"><i id="eye_password" class="lar la-eye"></i></span>
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
                        <div class="row">
                            <div class="form-group form-check text-center col-6">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1" v-model="remember">
                                <label class="form-check-label" for="exampleCheck1">Remember me</label>
                            </div>
                            <p class="col-6 d-flex justify-content-end">
                                <a href="/restorePassword" style="color:#c8242f">Забыли пароль?</a>
                            </p>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn default-btn-one">Войти</button>
                            <p class="account-decs">
                                Еще нет аккаунта? <a href="/register">Зарегистрироваться</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <my-footer></my-footer>
    </fragment>
</template>

<script>
import Swal from "sweetalert2";

export default {
    name: "LoginPage",
    data() {
        return {
            email: "",
            password: "",
            remember: false,
            errors: {
                textEmailErrors: [],
                textPasswordErrors: []
            },
            breadcrumbs:{default:null}
        }
    },
    props:{
        prop_breadcrumbs: {default:null}
    },
    created()
    {
        this.breadcrumbs = this.prop_breadcrumbs;
    },
    methods: {
        ControlElementOnForm(bool_block)
        {
            var form = document.getElementById("login_form");
            var elements = form.elements;
            for (var i = 0, len = elements.length; i < len; ++i) {
                elements[i].readOnly = bool_block;
            }
        },
        ValidateAndSendForm()
        {
            this.ControlElementOnForm(true);
            let hasError = this.validate()
            if(!hasError)
            {
                this.MakeRequestLogin();
            }
            else
            {
                this.ControlElementOnForm(false);
            }
        },
        MakeRequestLogin()
        {
            const userData = {
                email: this.email,
                password: this.password,
                remember: this.remember
            };
            axios.post("/login", userData)
                .then((response)=>{
                    console.log(response);
                    if (response.data.errors)
                    {
                        Object.keys(response.data.errors).map((key)=>{
                            response.data.errors[key].map((elem)=>{
                                if(elem==="email")
                                {
                                    this.errors.textEmailErrors.push({
                                        message: elem
                                    })
                                }
                                else if(elem==="password")
                                {
                                    this.errors.textPasswordErrors.push({
                                        message: elem
                                    })
                                }
                            })});
                    }
                    else if(response.data.error)
                    {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: response.data.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                    else
                    {
                        if (response.data.hasAccountLawyer || response.data.hasAccountClient)
                        {
                            window.location.href="/";
                        }
                        else if (!response.data.hasAccountClient)
                        {
                            window.location.href="/";
                        }
                        else
                        {
                            window.location.href="/";
                        }
                    }
                })
                .catch((error)=>{
                    let title_text = "";
                    if (error.response.status === 422)
                    {
                        title_text = "Данные не были обработаны для входа!";
                    }
                    else if(error.response.status===429)
                    {
                        title_text = "Слишком много запросов!";
                    }
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: title_text,
                        showConfirmButton: false,
                        timer: 1500
                    })
                    this.ControlElementOnForm(false);
                });
        },
        validate() {
            let hasError = false;
            this.errors.textEmailErrors = [];
            this.errors.textPasswordErrors = [];
            if (this.email.length <= 0) {
                this.errors.textEmailErrors.push({message: "Поле для ввода email-адреса не заполнено!"});
                hasError = true;
            }
            else
            {
                let regex = new RegExp('[a-z0-9]+@[a-z]+\.[a-z]{2,3}');
                if(!regex.test(this.email))
                {
                    this.errors.textEmailErrors.push({"message": "Введите корректный email-адрес!"});
                    hasError = true;
                }
            }
            if (this.password.length < 8) {
                this.errors.textPasswordErrors.push({message: "Текст в поле \"Пароль\" слишком короткий. Должно быть как минимум 8 символов!"})
                hasError = true;
            }
            return hasError;
        },
        showHidePassword(event) {
            let clicked_element = event.target;
            let id_clicked_element = clicked_element.id;
            let element_password_input = document.getElementById("Password")
            if (element_password_input.type === "password") {
                element_password_input.type = "text";
                if (id_clicked_element === "eye_password") {
                    event.target.classList.remove("la-eye");
                    event.target.classList.add("la-eye-slash");
                } else {
                    let nested_element = event.target.querySelector('i');
                    nested_element.classList.remove("la-eye");
                    nested_element.classList.add("la-eye-slash");
                }
            } else {
                element_password_input.type = "password";
                if (id_clicked_element === "eye_password") {
                    event.target.classList.remove("la-eye-slash");
                    event.target.classList.add("la-eye");
                } else {
                    let nested_element = event.target.querySelector('i');
                    nested_element.classList.remove("la-eye-slash");
                    nested_element.classList.add("la-eye");

                }
            }
        }
    }
}
</script>

<style scoped>

</style>
