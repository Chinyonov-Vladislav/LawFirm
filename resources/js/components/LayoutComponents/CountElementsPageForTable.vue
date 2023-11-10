<template>
    <div class="row">
        <div class="offset-0 offset-sm-0 offset-md-0 offset-lg-6 offset-xl-6
                                    col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 d-flex align-items-center justify-content-end">
                    <p>Количество элементов на странице</p>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6 d-flex align-items-center">
                    <select @change="ChangeSelect" class="form-select form-select-lg"
                            aria-label=".form-select-lg example" v-model="current_value">
                        <option :selected="current_value === value" :value="value" v-for="value in values"
                        >{{value}}</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "CountElementsPageForTable",
    data(){
        return {
            values: [
                5, 25, 50, 100
            ],
            /*values: [
              1,2,3
            ],*/
            current_value: 0,
            name_table_elements: {default:null}
        }
    },
    created()
    {
        this.current_value = this.values[0];
        this.name_table_elements = this.prop_name_table_elements;
        this.$emit("changeCountElementsTable", {
            name_table: this.name_table_elements,
            count: this.current_value
        });
    },
    props:{
        prop_name_table_elements: {default:null}
    },
    methods:{
        ChangeSelect()
        {
            this.$emit("changeCountElementsTable", {
                name_table: this.name_table_elements,
                count: this.current_value
            });
            console.log("Изменение select");
            console.log(this.current_value);
        }
    }
}
</script>

<style scoped>

</style>
