<template>
    <multiple-select inline-template>
        <div class="">
            <div>{{ tenantId }}</div>
            <select-2 :options="options" name="tags[]" id="select_tags" v-model="selected" multiple=true></select-2>
            <pre class="code">
              <p v-text="selected"></p>
            </pre>
        </div>
    </multiple-select>
</template>

<script>
    import axios from 'axios';

    Vue.component('select-2', {
        template: '<select name="tags[]" id="select_tag" class="form-control" multiple></select>',
        props: ['tenantId'],
        data() {
            return {
                select2data: [],
                value: null,
            }
        },
        created() {
            
        },
        mounted() {
            let vm = this;
            console.log(this.tenantId);
            const url = window.location.protocol + "//" + window.location.host + "/" + 'api/tag/' + this.tenantId + '/generate-select-tag';
            let select = $(this.$el);

            axios.get(url).then(response => {
                console.log(response.data.selectOption);
                select
                    .select2({
                        placeholder: 'Choose...',
                        theme: 'bootstrap',
                        width: '100%',
                        data: response.data.selectOption
                    })
                    .on('change', function () {
                        vm.$emit('input', select.val());
                    });
                select.val(vm.value).trigger('change');
            }).catch(error => {
                console.log(error);
            })
        },
        methods: {
            // formatOptions() {
            //     this.select2data.push({ id: '', text: 'Select' });
            //     for (let key in this.options) {
            //         this.select2data.push({ id: key, text: this.options[key] })
            //     }
            // }
        },
        destroyed: function () {
            $(this.$el).off().select2('destroy')
        }
    });

    const options = {
        apples: 'green',
        bananas: 'yellow',
        orange: 'orange'
    };

    const multiSelect = Vue.component('multiple-select', {
        data () {
            return {
                selected: 'apples',
                options
            }
        }
    });

    export default {
        name: "tag-component"
    }
</script>