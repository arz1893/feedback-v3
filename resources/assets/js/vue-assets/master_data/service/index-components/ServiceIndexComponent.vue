<template>
    <div>

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

        <div class="row">
            <div class="col-lg-7 col-md-4 col-sm-5">
                <div class="form-inline pull-left" id="form_search_list">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for..." v-model="searchString">
                        <span class="input-group-btn">
                        <button class="btn btn-primary" type="button" @click="filterByName()">
                            <i class="ion ion-search"></i>
                        </button>
                    </span>
                    </div>
                </div>
            </div>

            <div class="visible-xs">
                <br> <br>
            </div>

            <div class="col-lg-4 col-md-5 col-sm-5 col-lg-offset-1">
                <multiselect id="select_tags" v-model="selectedTags" :options="options" :multiple="true" :close-on-select="false" :clear-on-select="false" :hide-selected="true" :preserve-search="true" placeholder="Choose Tag..." label="name" track-by="name"></multiselect>
            </div>
        </div> <br>

        <div class="table-responsive" v-show="errorMessage === ''">
            <table class="table table-bordered table-striped" cellspacing="0" width="100%" id="table_service">
                <thead>
                <tr>
                    <th width="10%">Image</th>
                    <th width="20%">Name</th>
                    <th>Tags</th>
                    <th width="10%">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="service in services">
                    <td>
                        <a role="button" v-bind:href="service.show_service_url">
                            <img v-bind:src="service.img" style="width: 75px; height: 50px;">
                        </a>
                    </td>
                    <td>
                        <a role="button" v-bind:href="service.show_service_url">
                            {{ service.name }}
                        </a>
                    </td>
                    <td>
                        <div v-if="service.serviceTags.length > 0">
                            <span v-for="tag in service.serviceTags" class="label" v-bind:style="{ background: tag.bgColor, 'margin-right': '2px'}">
                                {{ tag.name }}
                            </span>
                        </div>
                        <div v-else>-</div>
                    </td>
                    <td>
                        <a v-bind:href="service.show_edit_service_url" role="button" class="btn btn-warning">
                            <i class="fa fa-pencil-square"></i>
                        </a>
                        <button class="btn btn-danger">
                            <i class="fa fa-trash-o"></i>
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
        </div>
    </div>
</template>

<script>
    import MultiSelect from 'vue-multiselect';

    Vue.component('multiselect', MultiSelect);

    export default {
        name: "service-index-component",
        props: ['tenantid'],
        created() {
            this.getServiceList();
            this.getTagList();
        },
        data() {
            return {
                services: [],
                service: {
                    name: '',
                    description: '',
                    img: '',
                    tags: []
                },
                pagination: {
                    currentPage: '',
                    endPage: '',
                    prevPage: '',
                    nextPage: '',
                    path: ''
                },
                selectedTags: [],
                options: [],
                searchString: '',
                searchStatus: '',
                errorMessage: '',
                default_image: window.location.protocol + "//" + window.location.host  + '/default-images/no-image.jpg'
            }
        },
        methods: {
            getServiceList: function () {
                this.errorMessage = '';
                this.searchString = '';
                const url = window.location.protocol + "//" + window.location.host  + '/api/service/' + this.tenantid + '/get-all-service';
                axios.get(url).then(response => {
                    console.log(response.data.data);
                    this.services = response.data.data;
                    this.makePagination(response.data);
                }).catch(error => {
                    console.log(response);
                });
            },
            getTagList: function() {
                const url = window.location.protocol + "//" + window.location.host  + '/api/tag/' + this.tenantid + '/generate-select-tag';
                axios.get(url).then(response => {
                    this.options = response.data;
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
            },
        }
    }
</script>

<style scoped>

</style>