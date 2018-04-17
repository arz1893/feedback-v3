<template>
    <div>

        <div class="alert alert-success alert-dismissible" role="alert" v-show="alertSuccess">
            <button type="button" class="close" aria-label="Close" @click="alertSuccess = false"><span aria-hidden="true">&times;</span></button>
            <strong>Success <i class="fa fa-check"></i> </strong> Tag has been successfully deleted
        </div>

        <div v-if="searchStatus.length > 0" class="text-center"><i class="fa fa-spinner fa-spin"></i> {{ searchStatus }}</div>

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
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal_delete_tag" @click="setCurrentTag(tag)">
                        <i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
            </tbody>
        </table>

        <div class="text-center">
            <ul v-show="pagination.currentPage !== ''" class="pagination">
                <li v-bind:class="{disabled:pagination.prevPage === null}">
                    <a v-if="pagination.prevPage !== null" role="button" aria-label="Previous" @click="changePage(pagination.prevPage)">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                    <a v-else role="button" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li v-for="n in pagination.endPage" v-bind:class="{ active:n===pagination.currentPage }">
                    <a v-if="n !== pagination.currentPage" role="button" @click="changePage(pagination.path + '?page=' + n)">{{ n }}</a>
                    <a v-else role="button">{{ n }}</a>
                </li>
                <li v-bind:class="{disabled:pagination.nextPage === null}">
                    <a v-if="pagination.nextPage !== null" role="button" aria-label="Next" @click="changePage(pagination.nextPage)">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                    <a v-else role="button">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </div>

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
                        Are you sure want to delete this tag ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" @click="deleteTag()">
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
                },
                pagination: {
                    currentPage: '',
                    endPage: '',
                    prevPage: '',
                    nextPage: '',
                    path: ''
                },
                alertSuccess: false,
                searchStatus: ''
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
                    vm.makePagination(response.data);
                }).catch(error => {
                    console.log(error);
                });
            },
            setCurrentTag: function(selectedTag) {
                this.tag = selectedTag;
            },
            deleteTag: function() {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host  + '/api/tag/delete-tag';
                axios.post(url, {
                    tag_id: vm.tag.systemId
                }).then(response => {
                    if(response.data.message === 'success') {
                        vm.alertSuccess = true;
                        function sendRequest() {
                            vm.getTagList();
                        }
                        let debounceFunction = _.debounce(sendRequest, 1000);
                        debounceFunction();
                    }
                }).catch(error => {
                    console.log(error);
                });
            },
            makePagination: function (data) {
                let vm = this;
                vm.pagination.currentPage = data.meta.current_page;
                vm.pagination.endPage = data.meta.last_page;
                vm.pagination.path = data.meta.path;
                vm.pagination.prevPage = (data.links.prev === null ? null:data.links.prev);
                vm.pagination.nextPage = (data.links.next === null ? null:data.links.next);
            }
        },

    }
</script>

<style scoped>

</style>