<template>
    <div>
        <button type="button" class="btn btn-success">
            Add Role <i class="fa fa-plus-circle"></i>
        </button> <br> <br>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(user_group, index) in user_groups">
                    <td>{{ index + 1 }}</td>
                    <td>{{ user_group.name }}</td>
                    <td>
                        <a role="button" class="btn btn-warning">
                            <i class="fa fa-pencil-square"></i>
                        </a>
                        <a role="button" class="btn btn-danger">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        name: "user-group-index",
        props: ['tenant_id'],
        created() {
            this.getAllUserGroup();
        },
        data() {
            return {
               user_group: {
                   systemId: '',
                   name: '',
                   recOwner: ''
               },
                user_groups: []
            }
        },
        methods: {
            getAllUserGroup: function () {
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/user_group/' + this.tenant_id + '/' + 'get-all-user-group';
                axios.get(url).then(response => {
                    this.user_groups = response.data.data;
                }).catch(error => {
                    console.log(error);
                })
            }
        }
    }
</script>

<style scoped>

</style>