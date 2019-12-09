<template>
    <div>
        <div class="dialog-content">
            <div class="dialog-header">
                <div class="dialog-close-button pull-right">
                    <a href="#" @click="$emit('close')" class="text-18 text-red">
                        <i class="fa fa-times-circle"></i>
                    </a>
                </div>
                <div class="dialog-c-title">Delete this department?</div>
            </div>
        </div>
        <div class="vue-dialog-buttons p-3">
            <button type="button" class="m-2 btn btn-success" style="flex: 1 1 50%;" @click="submit">Confirm</button>
            <button type="button" class="m-2 btn btn-danger" style="flex: 1 1 50%;" @click="$emit('close')">Cancel</button>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'DeleteDepartmentModal',
        props: {
            id: '',
        },
        methods: {
            close: function() {
                this.$emit('close');
            },
            submit: function() {
                console.log('Delete department');

                let pageUrl = '/api/admin/departments/'+this.id;
                axios.delete(pageUrl)
                .then(response => {
                    this.$store.commit('SET_DEPARTMENTS_PAGINATE', response.data.departments);
                    this.close();
                })
                .catch(error => {

                    console.log(error);

                    if(error) {
                        if(error.response) {
                            console.log(error.response.data);

                            let errors;

                            if(error.response.data.errors) {
                                errors = error.response.data.errors;
                            } else {
                                errors = false;
                            }

                            this.$root.showErrorPopup(error.response.data.message, errors);
                        }
                    }
                })
            },
        }
    }
</script>