<template>
    <div>
        <table class="table table-bordered table-striped table-responsive" id="table_tags" width="100%">
            <thead>
            <tr>
                <th>Name</th>
                <th>Is default?</th>
                <th>Color</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="tag in tags">
                <td>
                    <a role="button">
                        {{ tag.name }}
                    </a>
                </td>
                <td>
                    <span v-if="tag.defValue === 1" class="text-green">Yes</span>
                    <span v-else class="text-red">No</span>
                </td>
                <td>
                    <div style="width: 30px; height: 30px; border-radius: 50%;" v-bind:style="{ background: tag.bgColor }"></div>
                </td>
                <td>
                    <a role="button" class="btn btn-warning" v-bind:href="tag.edit_url">
                        <i class="fa fa-pencil-square"></i>
                    </a>
                    <button type="button" class="btn btn-danger">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
            </tbody>
        </table>

        <!-- Modal -->
        <div class="modal fade"
             id="modal_delete_tag"
             tabindex="-1"
             role="dialog"
             aria-labelledby="modal_delete_tag"
             aria-hidden="true"
             data-type="tag"
             data-id="">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h3 class="modal-title text-danger" id="exampleModalLabel">
                            Alert! <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                        </h3>
                    </div>
                    <div class="modal-body">
                        Are you sure want to delete this item ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">
                            Delete <i class="fa fa-trash-o"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "tag-index-component",
        props: ['tenant_id'],
        data() {
            return {
                tags: [],
                tag: {
                    systemId: '',
                    name: '',
                    defValue: '',
                    bgColor: '',
                    recOwner: ''
                }
            }
        },
        created() {
            this.getTagList();
        },
        methods: {
            getTagList: function() {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host  + '/api/tag/' + this.tenant_id + '/get-tag-list';
                axios.get(url).then(response => {
                    vm.tags = response.data.data;
                }).catch(error => {
                    console.log(error);
                });
            },
        },

    }
</script>

<style scoped>

</style>