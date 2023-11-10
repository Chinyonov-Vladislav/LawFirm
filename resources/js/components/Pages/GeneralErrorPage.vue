<template>
    <div class="error-area">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="container">
                    <div class="error">
                        <img class="error-image" src="/photos/GeneralError.png" style="width: 25%" alt="image">
                        <h2 class="mt-2">{{text_error}}</h2>
                        <button @click="goBack" class=" mt-2 default-btn-one disabled" style="pointer-events: all; cursor: pointer;">Вернуться назад</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "GeneralErrorPage",
    props:{
        text_error: {default:null}
    },
    mounted() {
        console.log("ErrorPage")
      console.log(this.text_error);
    },
    methods:{
        goBack() {
            window.history.length > 1 ? window.history.go(-1) : window.history.go('/');
        }
    }
}
</script>

<style scoped>

</style>
