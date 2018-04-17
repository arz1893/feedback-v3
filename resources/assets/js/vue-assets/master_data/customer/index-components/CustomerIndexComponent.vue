<template>
    <div>
        <div class="alert alert-success" role="alert" id="alert_customer_success" style="display: none;">
            <strong>Success!</strong> Customer has been updated
        </div>

        <table class="table table-striped table-hover table-bordered" id="table_customer" style="width: 100%;">
            <thead>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Birth Date</th>
                <th>Gender</th>
                <th>Address</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
                <tr v-for="customer in customers">
                    <td>
                        <a role="button">
                            {{ customer.name }}
                        </a>
                    </td>
                    <td>{{ customer.phone }}</td>
                    <td>
                        <span v-if="customer.email !== null">
                            {{ customer.email }}
                        </span>
                        <span v-else>
                            -
                        </span>
                    </td>
                    <td>
                        {{ customer.birthdate }}
                    </td>
                    <td>
                        <span v-if="customer.gender === 1">
                            Male
                        </span>
                        <span v-else>
                            Female
                        </span>
                    </td>
                    <td>
                        <span v-if="customer.address !== null">
                            {{ customer.address}}
                        </span>
                        <span v-else>
                            -
                        </span>
                    </td>
                    <td>
                        <a role="button" class="btn btn-warning" v-bind:href="customer.show_edit_url">
                            <i class="fa fa-pencil-square"></i>
                        </a>
                        <button type="button" class="btn btn-danger">
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
</template>

<script>
    export default {
        name: "customer-index",
        props: ['tenant_id'],
        created() {
            this.getCustomers();
        },
        data() {
            return {
                customers: [],
                pagination: {
                    currentPage: '',
                    endPage: '',
                    prevPage: '',
                    nextPage: '',
                    path: ''
                },
            }
        },
        methods: {
            getCustomers: function () {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/customer/'+ vm.tenant_id + '/get-all-customer';
                axios.get(url).then(response => {
                    vm.customers = response.data.data;
                    vm.makePagination(response.data);
                }).catch(error => {
                    console.log(error);
                })
            },
            makePagination: function (data) {
                let vm = this;
                vm.pagination.currentPage = data.meta.current_page;
                vm.pagination.endPage = data.meta.last_page;
                vm.pagination.path = data.meta.path;
                vm.pagination.prevPage = (data.links.prev === null ? null:data.links.prev);
                vm.pagination.nextPage = (data.links.next === null ? null:data.links.next);
            },
            changePage: function (url) {
                let vm = this;
                vm.searchStatus = 'Loading...';
                function fireRequest() {
                    axios.get(url).then(response => {
                        vm.feedbackProducts = response.data.data;
                        vm.makePagination(response.data);
                        vm.searchStatus = '';
                    }).catch(error => {
                        console.log('something wrong within the process');
                        console.log(Object.assign({}, error));
                    });
                }

                let debounceFunction = _.debounce(fireRequest, 1000);
                debounceFunction(vm);
            }
        }
    }
</script>

<style scoped>

</style>