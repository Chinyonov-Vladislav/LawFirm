<template>
    <fragment>
        <my-preloader></my-preloader>
        <my-header></my-header>
        <div class="sign-up-area ptb-100 mt-restore-password-title">
            <div class="container">
                <div class="section-title">
                    <breadcrumbs :prop_breadcrumbs="breadcrumbs"></breadcrumbs>
                    <h2>Восстановление пароля</h2>
                </div>
                <div class="sign-up-form">
                    <form id="restorePasswordForm" @submit.prevent="restorePassword" novalidate>
                        <div class="form-group mt-2">
                            <label for="email">Email-адрес</label>
                            <div class="input-group mb-5">
                                <input v-model="email" v-bind:class="{ 'is-invalid': errors.emailErrors.length >0 }"
                                       readonly onfocus="this.removeAttribute('readonly')" type="email"
                                       class="form-control"
                                       id="email" placeholder="Введите email-адрес">
                                <div class="invalid-feedback" v-if="errors.emailErrors.length >0">
                                    <div class="col-lg-12 ">
                                        <ul>
                                            <li v-for="item in errors.emailErrors">
                                                {{ item.message }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button id="restorePasswordButton" type="submit" class="btn default-btn-one">Восстановить пароль</button>
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
    name: "RestorePassword",
    methods:{
        validate()
        {
            this.errors.emailErrors = [];
            let hasError = false;
            if(this.email.length>0)
            {
                let regex = new RegExp('[a-z0-9]+@[a-z]+\.[a-z]{2,3}');
                if(!regex.test(this.email))
                {
                    this.errors.emailErrors.push({"message": "Введите корректный email-адрес!"});
                    hasError = true;
                }
            }
            else
            {
                this.errors.emailErrors.push({"message":"Вы не заполнили поле \"Email - адрес\""});
                hasError = true;
            }
            return hasError;
        },
        restorePassword(){
            this.controlButtonRestorePassword(true);
            if(!this.validate())
            {
                this.makeRequestRestorePassword();
            }
            else
            {
                this.controlButtonRestorePassword(false);
            }
        },
        controlButtonRestorePassword(control_flag)
        {
            document.getElementById("restorePasswordButton").disabled = control_flag;
        },
        makeRequestRestorePassword()
        {
            let data = {
                "email": this.email
            }
            axios.post("/restorePassword", data).then((response)=>{
                if(response.data.errors)
                {
                    Object.keys(response.data.errors).map((key)=>{
                        response.data.errors[key].map((elem)=> {
                            if(key==="email")
                            {
                                this.errors.emailErrors.push({"message": elem});
                            }
                        })
                    });
                    this.controlButtonRestorePassword(false);
                }
                if(response.data.success)
                {
                    this.showSwal("success",response.data.message, 5000).then(()=>{
                        window.location = "/login";
                    });
                }
                else {
                    this.showSwal("error",response.data.message, 2000).then(()=>{
                        this.controlButtonRestorePassword(false);
                    });
                }
            }).catch((error)=>{
                this.showSwal("error",error.text, 2000).then(()=>{
                    this.controlButtonRestorePassword(false);
                });
            });
        },
        showSwal(icon, message, timer){
            return Swal.fire({
                position: 'top-end',
                icon: icon,
                title: message,
                showConfirmButton: false,
                timer: timer
            });
        }
    },
    data() {
        return {
            email: "",
            errors: {
                emailErrors: [],
            },
            breadcrumbs:{default:null}
        }
    },
    props:{
        prop_breadcrumbs: {default:null}
    },
    created() {
        this.breadcrumbs = this.prop_breadcrumbs;
    }
}
</script>

<style scoped>

</style>
